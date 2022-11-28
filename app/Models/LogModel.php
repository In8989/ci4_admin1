<?php

namespace App\Models;

class LogModel extends BaseModel
{

    protected $table = '';
    protected $prefix = '';
    protected $allowedFields = [];


    function logLoginGet()
    {
        $this->setLogTable('login');

        return $this->get()->getResultArray();
    }

    function logLoginInsert($input, $rs = 1)
    {
        $this->setLogTable('login');

        $set = array(
            'lol_mem_id' => $input['mem_id'],
            'lol_login_result' => $rs,
            'lol_created_ip' => $_SERVER["REMOTE_ADDR"],
        );

        return $this->insert($set);
    }


    private function setLogTable($tbl)
    {
        if ($tbl == 'login') {
            $this->table = 'log_login';
            $this->prefix = 'lol';
            $this->allowedFields = ['lol_mem_id', 'lol_login_result', 'lol_created_ip', 'lol_created_at',];
        }

        $this->createdField = $this->prefix . '_created_at';
        $this->updatedField = '';
        $this->deletedField = '';
    }





}
