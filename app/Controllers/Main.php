<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Main extends BaseController
{
    protected $models = ['BoardConfModel'];

    public function index()
    {
        //  게시판 리스트 불러오기
        $this->BoardConfModel->where("boc_deleted_at is null or boc_deleted_at = ''");
        $data['boc'] = $this->BoardConfModel->find();

        /*foreach ($boc as $board) {
            echo "<a href='/board/".$board['boc_code']."'>".$board['boc_title']."</a><br/>";
        }*/

        return $this->run("{$this->THEME}/main", $data);

    }
}
