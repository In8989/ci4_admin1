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
        $option["perPage"] = 3;
        $pager = $this->model->getPager($option);

        $data = [
            'list'        => $pager['list'],
            'links'       => $pager['links'],
            'total_count' => $pager['total_count'],
        ];

        // 첨부파일 데이터 가져오기
        $bod_idx = array();
        foreach ($data['list'] as $boc) {
            $bod_idx[] = $boc['bod_idx'];
        }
        $where = array(
            "bod_idx" => $bod_idx,
            "bod_code" => $this->boc_code,
        );
        $data['bof_list'] = $this->BoardFileModel->getFileList($where);
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

            // 첨부파일 데이터 가져오기
            $where = array(
                "bod_idx" => $idx,
                "bod_code" => $this->boc_code,
            );
            $data['bof_list'] = $this->BoardFileModel->getFileList($where);

            $data['idx'] = $idx;
            $this->addData($data);

            return $this->run($this->viewPath . '/' . $this->conf['boc_skin'] . '/edit', $data);

        } else if ($this->request->getMethod() == 'post') {
            //-- 저장 시

            $input = $this->request->getPost();

            $uploader = new Uploader();
            $filesInfo = $uploader->upload("$this->cont_url/$this->boc_code");   //  업로드

            $input["bod_group"] = 1;
            $input["bod_level"] = 1;
            $input["bod_sort"] = 1;
            $input["bod_mem_id"] = "";
            $input["bod_origin_mem_idx"] = "";

            if ($this->mem_session['MIDX']) {
                $input["bod_mem_id"] = $this->mem_session["MID"];
                $input["bod_origin_mem_idx"] = $this->mem_session["MIDX"];
                $input["bod_writer_name"] = $this->mem_session["Mname"];
                $input["bod_password"] = $this->mem_session["Mpass"];
            }

            $bod_idx = $this->model->edit($input);

            //-- board_file db 저장부분 시작
            $bof_input = array();

            foreach ($filesInfo as $key => $file) {
                if ($file['hasError'] != 0) continue;
                $bof_input[$key]["bof_bod_code"] = $this->boc_code;
                $bof_input[$key]["bof_bod_idx"] = $bod_idx;
                $bof_input[$key]["bof_num"] = $key;
                $bof_input[$key]["bof_file_save"] = $file['savedPath']; //  board_file db에 저장할 이미지파일 경로
                $bof_input[$key]["bof_file_name"] = $file['name'];
                $bof_input[$key]["bof_file_size"] = $file['size'];
            }

            //  기존 파일이 있는지 체크 후 파일 삭제를 위한 배열 만들기
            $ready_to_del = array();
            foreach ($bof_input as $key => $bof) {

                $this->BoardFileModel->where("(bof_deleted_at is null or bof_deleted_at = '')");
                $this->BoardFileModel->where('bof_bod_code', $bof['bof_bod_code']);
                $this->BoardFileModel->where('bof_bod_idx', $bod_idx);
                $this->BoardFileModel->where('bof_num', $key);
                $bof_info = $this->BoardFileModel->get()->getRowArray();

                if ($bof_info) {
                    if (isset($bof["bof_file_save"]) && $bof_info["bof_file_save"] != '') {
                        $ready_to_del[] = $bof_info["bof_file_save"];   //  삭제할 파일 위치
                        $this->BoardFileModel->del($bof_info['bof_idx']);   //  기존 파일 데이터 삭제처리
                    }
                }
            }

            //  board_file db 저장 실행
            foreach ($bof_input as $bof) {
                $this->BoardFileModel->edit($bof);
            }
            $uploader->file_del($ready_to_del);
            // board_file db 저장부분 끝 --

            return redirect()->to($this->cont_url . "/" . $this->boc_code);

        }

    }

    public function reply()
    {
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

            }

            $input["bod_group"] = 1;
            $input["bod_level"] = 1;
            $input["bod_sort"] = 1;
            $input["bod_mem_id"] = "";
            $input["bod_origin_mem_idx"] = "";

            if ($this->mem_session['MIDX']) {
                $input["bod_mem_id"] = $this->mem_session["MID"];
                $input["bod_origin_mem_idx"] = $this->mem_session["MIDX"];
                $input["bod_writer_name"] = $this->mem_session["Mname"];
                $input["bod_password"] = $this->mem_session["Mpass"];
            }

            $bod_idx = $this->model->edit($input);

            return redirect()->to($this->cont_url . "/" . $this->boc_code);

        }
    }

    public function delete()
    {
        $idx = $this->request->getGet('idx') ?? '';

        if ($idx) {
            if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');
        } else {
            foreach ($this->model->allowedFields as $field) $data[$field] = "";
        }

        $input = $this->request->getPost();
        print_array($input);
        exit;

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
