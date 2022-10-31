<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Uploader;

class Board extends BaseController
{

    protected $models = ['BoardDataModel', 'BoardConfModel', 'BoardFileModel', 'MemberModel'];
    protected $viewPath = 'theme/board';
    protected $boc_code = '';       //  게시판 고유 코드
    protected $conf = '';           //  게시판 설정 정보
    protected $mem_info = array();  //  로그인 유저 정보
    protected $auth = array();  //  로그인 유저 정보

    public function index($mode = '', $boc_code = '')
    {
        // 게시판 체크
        if (!$this->conf = $this->BoardConfModel->getInfo($boc_code)) alert("존재하지 않는 게시판입니다.");

        $this->boc_code = $this->conf['boc_code'];
        $this->model->setDataTable($this->boc_code);

        //  로그인 시 회원 정보 가져오기
        if ($this->mem_session['MIDX'] && $rs = $this->MemberModel->find($this->mem_session['MIDX'])) {
            // 주요 정보만 View로 내려주기
            $this->mem_info = array(
                "mem_idx"   => $rs["mem_idx"],
                "mem_id"    => $rs["mem_id"],
                "mem_name"  => $rs["mem_name"],
                "mem_pass"  => $rs["mem_pass"],
                "mem_level" => $rs["mem_level"],
            );
        }

        //  권한 검사
        $this->auth = $this->board_auth_check();

        // mode 이름인 메서드로 이동
        if (method_exists($this, $mode)) {
            return $this->$mode();
        }
    }

    public function list()
    {
        //  권한 검사
        if (!$this->auth['list']) alert("권한이 없습니다.");

        /***    검색 기능 시작   ***/
        if ($this->search_obj[1]) $this->model->like("mem_name", $this->search_obj[1]);
        if ($this->search_obj[2]) $this->model->like("mem_tel", $this->search_obj[2]);
        /***    /검색 기능 끝   ***/
        $option["perPage"] = 10;
        $option['orderBy'] = "bod_group desc,bod_sort asc";
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
            "bod_idx"  => $bod_idx,
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

    //  /board/$this->boc_code/write
    public function write()
    {
        //  권한 검사
        if (!$this->auth['write']) alert("권한이 없습니다.");

        $idx = $this->request->getGet('idx') ?? '';
        $reply = $this->request->getGet('reply') ?? '';

        $validate = $this->validate([
            'bod_title' => [
                'rules'  => 'required',
                'errors' => ['required' => '제목을 입력해주세요.'],
            ],
        ]);

        if (!$validate) {   //-- 기존 데이터 가져오기

            if ($reply && $idx) {   //  답글 작성 페이지
                $origin = $this->model->find($idx);
                $fields = $this->model->allowedFields;
                foreach($fields as $f){
                    $data[$f] = "";
                }
                $data["bof_list"] = array();

                // 일부 내용 변경
                $data["bod_title"] = "Re : " . $origin["bod_title"];
                $data["bod_content"] = "----- 원본글 -----------------\n" . $origin["bod_content"];

                // 원본글이 비밀글일 경우 답변글도 비밀글로 처리
                $data["bod_origin_secret"] = false;
                if($origin["bod_secret"]){
                    $data["bod_origin_secret"] = true;
                }
            } else if ($idx) { //  글 수정 페이지
                if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');

                // 첨부파일 데이터 가져오기
                $where = array(
                    "bod_idx"  => $idx,
                    "bod_code" => $this->boc_code,
                );
                $data['bof_list'] = $this->BoardFileModel->getFileList($where);

            } else {    //  새글 작성 페이지
                foreach ($this->model->allowedFields as $field) $data[$field] = "";
            }

            $data['idx'] = $idx;
            $this->addData($data);

            return $this->run($this->viewPath . '/' . $this->conf['boc_skin'] . '/edit', $data);

        } else if ($this->request->getMethod() == 'post') { //-- 저장

            $input = $this->request->getPost();

            if ($reply) {   //  답글 저장
                $origin = $this->model->find($idx);

                // 추가 정보 구성
                $input["bod_group"] = $origin["bod_group"];
                $input["bod_level"] = $origin["bod_level"] + 1;
                $input["bod_sort"] = $origin["bod_sort"] + 1;
                $input["bod_origin_mem_idx"] = $origin["bod_origin_mem_idx"];
                $input["bod_secret"] = $origin["bod_secret"];    // 원본 글 비밀글 설정 따라가기
                $input["bod_category"] = $origin["bod_category"]; // 원본 글 카테고리 가져가기

                $input["bod_mem_id"] = "";

                if($this->mem_session['MID']){
                    $input["bod_mem_id"] = $this->mem_info["mem_id"];
                    $input["bod_writer_name"] = $this->mem_info["mem_name"];
                    $input["bod_password"] = $this->mem_info["mem_pass"];
                }

                // 자리값 구하기
                $option = array(
                    "bod_group"=>$input["bod_group"],
                    "bod_level"=>$input["bod_level"],
                    "bod_sort"=>$input["bod_sort"],
                );
                $input["bod_sort"] = $this->model->getReplyPosition($option);

                // 고유값 삭제
                $input["bod_idx"] = "";

                // 게시물 순서 밀기
                $this->model->setReplySort($input["bod_group"], $input["bod_sort"]);
            } else if ($idx) {  //  글 수정

                $origin = $this->model->find($idx);

                if (!($origin['bod_mem_id'] === $this->mem_info['mem_id'] || $this->mem_session['mem_level'] === '90')) {
                    alert("잘못된 접근입니다.",$this->cont_url . "/" . $this->boc_code);
                }

            } else {    //  새글 저장
                $input["bod_group"] = $this->model->getNextGroupNum();
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
            }

            $bod_idx = $this->model->edit($input);

            /***    board_file db 저장부분 시작   ***/
            $uploader = new Uploader();
            $filesInfo = $uploader->upload("$this->cont_url/$this->boc_code");   //  업로드
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
            /***    board_file db 저장부분 끝    ***/

            return redirect()->to($this->cont_url . "/" . $this->boc_code);

        }

    }

    public function reply()
    {
        //  권한 검사
        if (!$this->auth['reply']) alert("권한이 없습니다.");

        return $this->write();
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
        print_array($data);
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

    private function board_auth_check()
    {
        $conf = $this->conf;
        $mem_level = 0;
        if (isset($this->mem_info["mem_level"])) {
            $mem_level = $this->mem_info["mem_level"];
        }

        // 게시판 관리자 체크 후 설정된 계정일 경우 관리자 권한주기
        if (trim($conf["boc_manager"])) {
            $mng = explode(",", $conf["boc_manager"]);
            if (array_search($this->SS_MID, $mng) !== false) {
                $mem_level = 99;
                $this->isMaster = true; // 강제 관리자로 만들기
            }
        }

        $auth = array(
            "list"  => false,
            "read"  => false,
            "write" => false,
            "reply" => false,
        );

        if ($conf["boc_auth_list"] <= $mem_level) $auth["list"] = true;
        if ($conf["boc_auth_read"] <= $mem_level) $auth["read"] = true;
        if ($conf["boc_auth_write"] <= $mem_level) $auth["write"] = true;
        if ($conf["boc_auth_reply"] <= $mem_level) $auth["reply"] = true;

        return $auth;
    }


}
