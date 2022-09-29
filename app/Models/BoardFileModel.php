<?php

namespace App\Models;

/**
 * Class BoardModel
 * @package App\Models
 *
 * 게시판 파일 정보 처리 모델.
 *
 */
class BoardFileModel extends BaseModel
{
    protected $table = 'board_file';
    protected $prefix = 'bof';
    protected $allowedFields = ['bof_bod_code', 'bof_bod_idx', 'bof_num', 'bof_file_name', 'bof_file_save',
                                'bof_file_size', 'bof_down_count',
                                'bof_created_id', 'bof_created_ip', 'bof_created_at',
                                'bof_updated_id', 'bof_updated_ip', 'bof_updated_at',
                                'bof_deleted_id', 'bof_deleted_ip', 'bof_deleted_at'];


    /**
     * 기존 업로드된 파일 정보 리턴하기
     * @param $info
     * @return array
     */
    public function getFileList($where)
    {
        if (!$where["bod_idx"]) return array();

        $this->where("bof_bod_code", $where["bod_code"]);
        if (is_array($where["bod_idx"])) {
            $this->wherein("bof_bod_idx", $where["bod_idx"]);
        } else {
            $this->where("bof_bod_idx", $where["bod_idx"]);
        }
        $this->where(" ( bof_deleted_at is null or bof_deleted_at='' ) ");
        $this->orderBy("bof_num");
        $result = $this->get()->getResultArray();

        //  배열 정리
        $list = array();
        if(is_array($where["bod_idx"])){
            foreach ($result as $rs) {
                $list[$rs["bof_bod_idx"]][$rs["bof_num"]] = $rs;
            }
        }else {
            foreach ($result as $rs) {
                $list[$rs["bof_num"]] = $rs;
            }
        }
        return $list;
    }

    public function downloadCount($info)
    {
        $this->where("bof_bod_code", $info["bod_code"]);
        $this->where("bof_bod_idx", $info["bod_idx"]);
        $this->where("bof_idx", $info["bof_idx"]);
        $this->where("bof_deleted_at", "");
        $this->set("bof_down_count", "bof_down_count+1", false);
        $this->update();
    }

}






