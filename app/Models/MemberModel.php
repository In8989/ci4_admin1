<?php

namespace App\Models;

class MemberModel extends BaseModel
{
    //protected $primaryKey = 'mem_idx';
    //protected $createdField  = 'mem_created_at';
    //protected $updatedField  = 'mem_updated_at';
    //protected $deletedField  = 'mem_deleted_at';

    protected $table = 'my_member';
    protected $prefix = 'mem';
    protected $allowedFields = ['mem_id', 'mem_pass', 'mem_name', 'mem_tel', 'mem_email',
                                'mem_created_id', 'mem_created_ip', 'mem_created_at',
                                'mem_updated_id', 'mem_updated_ip', 'mem_updated_at',
                                'mem_deleted_id', 'mem_deleted_ip', 'mem_deleted_at',];



}
