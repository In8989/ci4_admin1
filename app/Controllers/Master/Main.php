<?php

namespace App\Controllers\Master;

use App\Controllers\Master\MasterController;

class Main extends MasterController
{
    public function index()
    {
        return $this->run('master/main');
    }

}

