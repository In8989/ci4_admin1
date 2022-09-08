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
            $idx = $this->request->getGet('idx') ?? '';

            if ($idx) {
                if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');
            } else {
                foreach ($this->model->allowedFields as $field) $data[$field] = "";
            }

            $data['idx'] = $idx;

            $Uploaded = new Uploaded();
            $Uploaded->file($data['mem_thumb1']);

            return $this->run($this->viewPath . '/edit', $data);

        } else if ($this->request->getMethod() == 'post') {
            $input = $this->request->getPost();

            $uploader = new Uploader();
            //$fileInfo = $uploader->upload('member');
            $filesInfo = $uploader->multiUpload('member');

            foreach ($filesInfo as $key => $file) {
                $num = $key + 1;
                if ($file['hasError'] != 0) continue;

                $input["mem_thumb{$num}"] = $file['savedPath'];
            }

            if ($this->model->edit($input)) {
                return redirect()->to($this->viewPath);
            } else {
                alert("오류가 발생하였습니다.");
            }
        }

    }

}
