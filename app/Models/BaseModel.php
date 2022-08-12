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
    }

}
