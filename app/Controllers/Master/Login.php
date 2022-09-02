<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

class Login extends MasterController
{
    protected $models = ['MemberModel'];
    protected $viewPath = '/master/login';

    public function index()
    {
        $validate = $this->validate([
            'mem_id' => [
                'rules'  => 'required',
                'errors' => ['required' => '이름을 입력해 주세요.'],
            ],
            'mem_pass' => [
                'rules'=>'required',
                'errors'=> ['required'=>'비밀번호를 입력해 주세요.'],
            ],
        ]);

        if (!$validate) {   // Form 출력
            $this->useLayout = false;
            return $this->run($this->viewPath . '/login');

        } else if ($this->request->getMethod() == 'post') {

            $input = $this->request->getPost();

            $rs = $this->model->getAuthMember($input);

            if ($rs['mem_pass'] == $input['mem_pass']) {
                print_array($rs);

                $session_data = array(
                    "MIDX"=>$rs["mem_idx"],
                    "MID"=>$rs["mem_id"],
                    "Mname"=>$rs["mem_name"],
                    "Mpass"=>$rs["mem_pass"],
                );

                $this->session->set($session_data);
                return redirect()->to('/master');

            } else {
                alert("아이디 또는 비밀번호가 맞지 않습니다.");
            }

        }
    }

    public function logout()
    {
        $array_items = ['MIDX','MID','Mname','Mlevel','Mpass'];
        $this->session->remove($array_items);
        alert('로그아웃되었습니다.');
        return redirect()->to('/master/login');
    }


}

