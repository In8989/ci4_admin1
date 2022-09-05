<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        echo "<a href='/master/login'>마스터</a>";
    }
}
