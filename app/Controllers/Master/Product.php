<?php

namespace App\Controllers\Master;
use App\Controllers\Master\MasterController;

class Product extends MasterController
{
    protected $models = ['ProductModel', 'CategoryModel'];
    protected $viewPath = '/master/product';


    public function index()
    {
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
            'prd_title' => [
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

            // 카테고리 정보 가져오기
            $cat_list = $this->CategoryModel->orderBy('cat_group ASC, cat_sort ASC')->get()->getResultArray();

            $cate1 = array();
            $cate2 = array();
            foreach ($cat_list as $key => $row) {
                if ($row['cat_level'] === '1') {
                    $cate1[] = $row;
                } else {
                    $cate2[$row['cat_group']][] = $row;
                }
            }
            $data['cate1'] = $cate1;
            $data['cate2'] = $cate2;

            $data['idx'] = $idx;
            $data['mode'] = $mode;

            return $this->run($this->viewPath . '/edit', $data);

        }

        if ($this->request->getMethod() === 'post') {
            $input = $this->request->getPost();

            if ($this->model->edit($input)) {
                return redirect()->to($this->viewPath);
            }

            alert("오류가 발생하였습니다.");
        }
    }
}
