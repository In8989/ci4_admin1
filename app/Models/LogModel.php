<?php

namespace App\Models;

class LogModel extends BaseModel
{

    protected $table = '';
    protected $prefix = '';
    protected $allowedFields = [];


    public function logLoginGet()
    {
        $this->setLogTable('login');

        return $this->get()->getResultArray();
    }

    public function logLoginInsert($input, $rs = 1)
    {
        $this->setLogTable('login');

        $set = array(
            'lol_mem_id' => $input['mem_id'],
            'lol_login_result' => $rs,
            'lol_created_ip' => $_SERVER["REMOTE_ADDR"],
        );

        return $this->insert($set);
    }

    public function logAccessGet()
    {
        $this->setLogTable('access');

        return $this->get()->getResultArray();
    }

    public function logAccessInsert($input)
    {
        $this->setLogTable('access');

        $set = array(
            'log_is_robot' => $input['is_robot'],
            'log_is_mobile' => $input['is_mobile'],
            'log_browser' => $input['browser'],
            'log_browser_ver' => $input['browser_ver'],
            'log_platform' => $input['platform'],
            'log_refer' => $input['refer'],
            //'log_keyword' => $input[''],
            'log_created_ip' => $_SERVER["REMOTE_ADDR"],
        );

        return $this->insert($set);
    }

    public function logAdminGet()
    {
        $this->setLogTable('admin');

        return $this->get()->getResultArray();
    }

    public function logAdminInsert($input)
    {
        $this->setLogTable('admin');

        $set = array(
            'log_is_robot' => $input['is_robot'],
            'log_is_mobile' => $input['is_mobile'],
            'log_browser' => $input['browser'],
            'log_browser_ver' => $input['browser_ver'],
            'log_platform' => $input['platform'],
            'log_refer' => $input['refer'],
            //'log_keyword' => $input[''],
            'log_created_ip' => $_SERVER["REMOTE_ADDR"],
        );

        return $this->insert($set);
    }


    private function setLogTable($tbl)
    {
        switch ($tbl) {
            case 'login':
                $this->table = 'log_login';
                $this->prefix = 'lol';
                $this->allowedFields = ['lol_mem_id', 'lol_login_result', 'lol_created_ip', 'lol_created_at',];
                break;

            case 'access':
                $this->table = 'log_access';
                $this->prefix = 'log';
                $this->allowedFields = ['log_is_robot', 'log_is_mobile', 'log_browser', 'log_browser_ver', 'log_platform',
                                        'log_refer', 'log_keyword', 'log_created_ip', 'log_created_at',];
                break;

            case 'admin':
                $this->table = 'log_admin';
                $this->prefix = 'loa';
                $this->allowedFields = ['loa_url', 'loa_method', 'loa_data', 'loa_menu_name',
                                        'loa_created_id', 'loa_created_ip', 'loa_created_at',
                                        'loa_updated_id', 'loa_updated_ip', 'loa_updated_at',
                                        'loa_deleted_id', 'loa_deleted_ip', 'loa_deleted_at',];

                $this->createdField = $this->prefix . '_created_at';
                $this->updatedField = $this->prefix . '_updated_at';
                $this->deletedField = $this->prefix . '_deleted_at';
                break;

        }

        if ($tbl !== 'admin') {
            $this->createdField = $this->prefix . '_created_at';
            $this->updatedField = '';
            $this->deletedField = '';
        }


    }





}
