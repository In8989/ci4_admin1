<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table = '';
    protected $prefix = '';
    protected $allowedFields = '';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $SS_MID;  // 세션변수

    public function __construct()
    {
        $this->primaryKey = $this->prefix . '_idx';
        $this->createdField = $this->prefix . '_created_at';
        $this->updatedField = $this->prefix . '_updated_at';
        $this->deletedField = $this->prefix . '_deleted_at';
        $this->tempReturnType = $this->returnType;  // 중요!!!!!

        // 세션 변수화
        $this->session = \Config\Services::session();
        $this->SS_MID = $this->session->get('MID');
    }

    public function getPager($option = array())
    {
        //  출력할 리스트 수
        $perPage = $option["perPage"] ?? 10;

        // 정렬처리
        if (isset($option["orderBy"])) $this->orderBy($option["orderBy"]);
        else $this->orderBy($this->primaryKey . " desc");

        $this->where("$this->deletedField is null or $this->deletedField = ''");

        return [
            'list'        => $this->paginate($perPage),
            'links'       => $this->pager->links(),
            'total_count' => $this->pager->gettotal(),
        ];
    }

    public function edit($input)
    {
        $set = array();
        foreach ($this->allowedFields as $field) {

            if (isset($input[$field]) || array_key_exists($field, $input)) {
                if (is_null($input[$field])) {    // Null 데이터 처리
                    $this->set($field, 'NULL', false);
                } else {   // 일반 데이터 처리
                    $set[$field] = $input[$field];
                }
            }
        }

        // 데이터 입력/수정 모두 updated 날짜 기록
        $set[$this->prefix . "_updated_id"] = $this->SS_MID;
        $set[$this->prefix . "_updated_ip"] = $_SERVER["REMOTE_ADDR"];

        if (isset($input[$this->primaryKey]) && $input[$this->primaryKey] != "") {
            // 데이터 업데이트

            $this->update($input[$this->primaryKey], $set);

        } else {
            // 데이터 입력

            $set[$this->prefix . "_created_id"] = $this->SS_MID;
            $set[$this->prefix . "_created_ip"] = $_SERVER["REMOTE_ADDR"];

            $this->insert($set);
            $input[$this->primaryKey] = $this->insertID();

        }

        return $input[$this->primaryKey];
    }

    public function del($key)
    {
        $set[$this->prefix . "_deleted_id"] = $this->SS_MID;
        $set[$this->prefix . "_deleted_ip"] = $_SERVER["REMOTE_ADDR"];

        $this->update($key, $set);
        $this->delete($key);
    }

}
