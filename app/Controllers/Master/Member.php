<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

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
            //'mem_id' => [
            //    'rules'  => 'required',
            //    'errors' => ['required' => '아이디를 입력해 주세요.'],
            //],
            'userfile' => [
                'label' => 'Image File',
                'rules' => 'uploaded[userfile]'
                    . '|is_image[userfile]'
                    . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[userfile,100]'
                    . '|max_dims[userfile,1024,768]',
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

            return $this->run($this->viewPath . '/edit', $data);

        } else if ($this->request->getMethod() == 'post') {
            $input = $this->request->getPost();

            $img = $this->request->getFile('userfile');
            print_array($img);
            exit;
            //if ($this->model->edit($input)) {
            //    return redirect()->to($this->viewPath);
            //} else {
            //    alert("오류가 발생하였습니다.");
            //}
        }

    }

}
