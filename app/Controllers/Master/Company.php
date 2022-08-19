<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Member extends BaseController
{
    protected $models = ['MemberModel'];

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5;
        $list = $this->model->paginate($perPage);

        $total = $this->model->pager->gettotal();
        $data = [
            'list'  => $list,
            'pager' => $this->model->pager->makeLinks($page, $perPage, $total),
        ];

        return $this->run('master/member/list', $data);
    }

    public function edit()
    {
        $validate = $this->validate([
            'mem_name' => [
                'rules'  => 'required',
                'errors' => ['required' => '이름을 입력해 주세요.'],
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

            return $this->run('master/member/edit', $data);

        } else if ($this->request->getMethod() == 'post') {
            $input = $this->request->getPost();

            if ($this->model->edit($input)) {
                return redirect()->to('/master/member');
            } else {
                alert("오류가 발생하였습니다.");
            }
        }

    }

    public function delete()
    {
        $idx = $this->request->getGet('idx');
        $set = [
            'mem_deleted_id' => 'admin',
            'mem_deleted_ip' => $_SERVER["REMOTE_ADDR"],
        ];
        $this->model->update($idx, $set);
        $this->model->delete($idx);

        return redirect()->to('/master/member');
    }

}
