<?php
namespace App\Models;
use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table      = '';
    protected $prefix     = '';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct()
    {
        $this->primaryKey = $this->prefix . '_idx';
        $this->createdField  = $this->prefix . '_created_at';
        $this->updatedField  = $this->prefix . '_updated_at';
        $this->deletedField  = $this->prefix . '_deleted_at';
        $this->tempReturnType = $this->returnType;  // 중요!!!!!
    }

    public function edit($input)
    {

        $set = array();
        foreach ($this->allowedFields as $field) {
            if (isset($input[$field]) || array_key_exists($field, $input)) {
                $set[$field] = $input[$field];
            }
        }

        // 데이터 입력/수정 모두 updated 날짜 기록
        $set[$this->prefix . "_updated_id"] = 'admin';
        $set[$this->prefix . "_updated_ip"] = $_SERVER["REMOTE_ADDR"];

        if (isset($input[$this->primaryKey]) && $input[$this->primaryKey] != "") {
            // 데이터 업데이트

            $this->update($input[$this->primaryKey], $set);

        } else {
            // 데이터 입력

            $set[$this->prefix . "_created_id"] = 'admin';
            $set[$this->prefix . "_created_ip"] = $_SERVER["REMOTE_ADDR"];

            $this->insert($set);
            $input[$this->primaryKey] = $this->insertID();
        }

        return $input[$this->primaryKey];
    }

}
