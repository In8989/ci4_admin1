<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

class Category extends MasterController
{
    protected $models = ['CategoryModel'];
    protected $viewPath = '/master/category';

    public function index()
    {
        $option["perPage"] = 100;
        $option['orderBy'] = "cat_group asc,cat_level asc,cat_sort asc";
        $pager = $this->model->getPager($option);

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
            'cat_title' => [
                'rules'  => 'required',
                'errors' => ['required' => '제목을 입력해 주세요.'],
            ],
        ]);

        $idx = $this->request->getGet('idx');
        $mode = $this->request->getGet('mode');

        if (!$validate) {   // Form 출력

            if ($idx) {
                if (!$data = $this->model->find($idx)) alert('데이터를 찾을 수 없습니다.');
            } else {
                foreach ($this->model->allowedFields as $field) $data[$field] = "";
            }

            $data['idx'] = $idx;
            $data['mode'] = $mode;

            return $this->run($this->viewPath . '/edit', $data);

        }

        if ($this->request->getMethod() === 'post') {
            $input = $this->request->getPost();

            $input['cat_group'] = $input['cat_group'] ?? $this->model->getNextGroupNum();
            $input['cat_level'] = $mode ? 2 : 1;
            $input['cat_sort'] = $this->model->getNextSort($input);

            if ($this->model->edit($input)) {
                return redirect()->to($this->viewPath);
            }

            alert("오류가 발생하였습니다.");
        }

    }
}
