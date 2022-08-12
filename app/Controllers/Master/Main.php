<?php

namespace App\Controllers\Master;
use App\Controllers\BaseController;

class Main extends BaseController
{
    public function index()
    {

        return $this->run('master/main');

    }

}

