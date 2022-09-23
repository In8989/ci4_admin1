<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Main extends BaseController
{
    protected $models = ['BoardConfModel'];

    public function index()
    {
        echo "<a href='/master/login'>관리자페이지</a><br/>";

        //  게시판 리스트 불러오기
        $this->BoardConfModel->where("boc_deleted_at is null or boc_deleted_at = ''");
        $boc = $this->BoardConfModel->find();

        foreach ($boc as $board) {
            echo "<a href='/board/".$board['boc_code']."'>".$board['boc_title']."</a><br/>";
        }

        exit;
    }
}
