<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;
use App\Libraries\Uploader;
use App\Controllers\Uploaded;

class Member extends MasterController
{
    protected $models = ['MemberModel'];
    protected $viewPath = '/master/member';

    public function index()
    {
        /***    검색 기능 시작   ***/
        if ($this->search_obj[1]) $this->model->like("mem_name", $this->search_obj[1]);
        if ($this->search_obj[2]) $this->model->like("mem_tel", $this->search_obj[2]);
        /***    /검색 기능 끝   ***/

        $pager = $this->model->getPager();

        $data = [
            'list'        => $pager['list'],
            'links'       => $pager['links'],
            'total_count' => $pager['total_count'],
        ];

        return $this->run($this->viewPath . '/list', $data);
    }

    public function edit()
    {
        $validate = $this->validate([
            'mem_id' => [
                'rules'  => 'required',
                'errors' => ['required' => '아이디를 입력해 주세요.'],
            ],
        ]);

        if (!$validate) {   // Form 출력
            $idx = $this->request->getGet('idx');

            if ($idx) {
                if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');
            } else {
                foreach ($this->model->allowedFields as $field) $data[$field] = "";
            }

            $data['idx'] = $idx;

            return $this->run($this->viewPath . '/edit', $data);

        }

        if ($this->request->getMethod() === 'post') {
            $input = $this->request->getPost();

            $uploader = new Uploader();
            $filesInfo = $uploader->upload('member');   //  업로드
            //$filesInfo = $uploader->multiUpload('member');    //  멀티업로드

            foreach ($filesInfo as $key => $file) {
                if ($file['hasError'] != 0) continue;
                $input["mem_thumb{$key}"] = $file['savedPath']; //  db에 저장할 이미지파일 경로
            }

            //  기존 파일이 있는지 체크 후 파일 삭제를 위한 배열 만들기
            $ready_to_del = array();
            if ($input[$this->primaryKey]) {
                $rs_info = $this->model->find($input[$this->primaryKey]);

                for ($i = 1; $i <= 2; $i++) {

                    if (isset($input["mem_thumb{$i}"]) && $rs_info["mem_thumb{$i}"] != '')
                        $ready_to_del[] = $rs_info["mem_thumb{$i}"];
                }

                $this->viewPath = $this->viewPath . "/edit/?idx=" . $input[$this->primaryKey];
            }


            if ($this->model->edit($input)) {
                $uploader->file_del($ready_to_del);

                return redirect()->to($this->viewPath);
            }

            alert("오류가 발생하였습니다.");
        }

    }

    public function del_file()
    {
        $input = $this->request->getPost();

        $row = $this->model->find($input['idx']);

        if ($row[$input['column']] != '') {
            $set = array(
                $this->primaryKey => $input['idx'],
                $input['column']  => '',
            );

            $uploader = new Uploader();
            $uploader->file_del(array($row[$input['column']]));

            $this->model->edit($set);

            $json['result'] = 'ok';

            die(json_encode($json));

        }


    }

}
