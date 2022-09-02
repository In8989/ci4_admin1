<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

class Company extends MasterController
{
    protected $models = ['CompanyModel'];
    protected $viewPath = '/master/company';

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $pager = $this->model->getPager();

        $data = [
            'list'  => $pager['list'],
            'links'  => $pager['links'],
            'total_count'  => $pager['total_count'],
        ];

        return $this->run($this->viewPath . '/list', $data);
    }

    public function edit()
    {
        $validate = $this->validate([
            'com_name' => [
                'rules'  => 'required',
                'errors' => ['required' => '이름을 입력해 주세요.'],
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

            if ($this->model->edit($input)) {

                return redirect()->to($this->viewPath);
            } else {
                alert("오류가 발생하였습니다.");
            }
        }

    }


}
