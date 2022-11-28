<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

class Boardconf extends MasterController
{
    protected $models = ['BoardConfModel'];
    protected $viewPath = '/master/boardconf';

    public function index()
    {
        /***    검색 기능 시작   ***/
        if ($this->search_obj[1]) $this->model->like("boc_title", $this->search_obj[1]);
        if ($this->search_obj[2]) $this->model->like("boc_code", $this->search_obj[2]);
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
            'boc_code' => [
                'rules'  => 'required',
                'errors' => ['required' => '이름을 입력해 주세요.'],
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

            if ($this->model->edit($input)) {
                $this->model->boardTableCreate($input);
                return redirect()->to($this->viewPath);
            }

            alert("오류가 발생하였습니다.");
        }

    }

}
