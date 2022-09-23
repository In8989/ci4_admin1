<?php

namespace App\Models;

class CompanyModel extends BaseModel
{

    protected $table = 'company';
    protected $prefix = 'com';
    protected $allowedFields = ['com_id', 'com_pass', 'com_name', 'com_tel', 'com_email',
                                'com_created_id', 'com_created_ip', 'com_created_at',
                                'com_updated_id', 'com_updated_ip', 'com_updated_at',
                                'com_deleted_id', 'com_deleted_ip', 'com_deleted_at',];


}
