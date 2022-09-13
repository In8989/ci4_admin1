<?php

namespace App\Models;

class MemberModel extends BaseModel
{

    protected $table = 'my_member';
    protected $prefix = 'mem';
    protected $allowedFields = ['mem_id', 'mem_pass', 'mem_name', 'mem_tel', 'mem_email',
                                'mem_thumb1', 'mem_thumb2',
                                'mem_created_id', 'mem_created_ip', 'mem_created_at',
                                'mem_updated_id', 'mem_updated_ip', 'mem_updated_at',
                                'mem_deleted_id', 'mem_deleted_ip', 'mem_deleted_at',];


    function getAuthMember($input)
    {
        $this->where("mem_id", $input["mem_id"]);
        $this->where("mem_pass", $input["mem_pass"]);

        return $this->get()->getRowArray();
    }

}
