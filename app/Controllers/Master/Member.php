<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Member extends BaseController
{

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5;
        $list = $this->memberModel->paginate($perPage);

        $total = $this->memberModel->pager->gettotal();
        $data = [
            'list'  => $list,
            'pager' => $this->memberModel->pager->makeLinks($page, $perPage, $total),
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
        $data['validation'] = $this->validation;
        if (!$validate) {
            $idx = $this->request->getGet('idx');

            $data['member'] = $this->memberModel->find($idx);

            return $this->run('master/member/edit', $data);

        } else if ($this->request->getMethod() == 'post') {
            $input = $this->request->getPost();

            if (isset($input['mem_idx'])) {
                $set = [
                    'mem_id'         => $input['mem_id'],
                    'mem_name'       => $input['mem_name'],
                    'mem_email'      => $input['mem_email'],
                    'mem_tel'        => $input['mem_tel'],
                    'mem_pass'       => $input['mem_pass'],
                    'mem_created_id' => 'admin',
                    'mem_created_ip' => $_SERVER["REMOTE_ADDR"],
                    'mem_updated_id' => 'admin',
                    'mem_updated_ip' => $_SERVER["REMOTE_ADDR"],
                ];

                $this->memberModel->update($input['mem_idx'], $set);
            } else {
                $this->memberModel->insert($input);
            }

            return redirect()->to('/master/member');
        }

    }

    public function delete()
    {
        $idx = $this->request->getGet('idx');
        $set = [
            'mem_deleted_id' => 'admin',
            'mem_deleted_ip' => $_SERVER["REMOTE_ADDR"],
        ];
        $this->memberModel->update($idx, $set);
        $this->memberModel->delete($idx);

        return redirect()->to('/master/member');
    }

}
