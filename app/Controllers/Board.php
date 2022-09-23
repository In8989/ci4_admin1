<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Uploader;

class Board extends BaseController
{

    protected $models = ['BoardDataModel', 'BoardConfModel', 'BoardFileModel'];
    protected $viewPath = 'theme/board';
    protected $boc_code = '';   //  게시판 고유 코드
    protected $conf = '';   // 게시판 설정 정보

    public function index($mode = '', $boc_code = '')
    {
        // 게시판 체크
        if (!$this->conf = $this->BoardConfModel->getInfo($boc_code)) alert("존재하지 않는 게시판입니다.");

        $this->boc_code = $this->conf['boc_code'];
        $this->model->setDataTable($this->boc_code);

        // mode 이름인 메서드로 이동
        if (method_exists($this, $mode)) {
            return $this->$mode();
        }
    }

    public function list()
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

        $this->addData($data);

        return $this->run($this->viewPath . '/' . $this->conf['boc_skin'] . '/list', $data);
    }

    public function read()
    {
        //  /board/$this->boc_code/read/1
        echo 'read';

        exit;
    }

    public function write()
    {
        //  /board/$this->boc_code/write

        $validate = $this->validate([
            'bod_title' => [
                'rules'  => 'required',
                'errors' => ['required' => '제목을 입력해주세요.'],
            ],
        ]);

        if (!$validate) {
            $idx = $this->request->getGet('idx') ?? '';

            if ($idx) {
                if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');
            } else {
                foreach ($this->model->allowedFields as $field) $data[$field] = "";
            }

            $data['idx'] = $idx;
            $this->addData($data);

            return $this->run($this->viewPath . '/' . $this->conf['boc_skin'] . '/edit', $data);

        } else if ($this->request->getMethod() == 'post') {

            $input = $this->request->getPost();

            $uploader = new Uploader();
            $filesInfo = $uploader->upload("$this->cont_url/$this->boc_code");   //  업로드

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
            exit;
        }

    }

    private function addData(&$data)
    {
        $data["list_page"] = $this->cont_url . "/" . $this->boc_code;
        $data['write_page'] = $data['list_page'] . "/write";
        $data["reply_page"] = $data["list_page"] . "/reply";
        $data["delete_page"] = $data["list_page"] . "/delete";
        $data["download_page"] = $data["list_page"] . "/download";
        $data['conf'] = $this->conf;
        $data['boc_code'] = $this->boc_code;
    }
}
