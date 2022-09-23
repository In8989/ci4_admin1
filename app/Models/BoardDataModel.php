<?php

namespace App\Models;

class BoardDataModel extends BaseModel
{

    protected $table = 'board';
    protected $prefix = 'bod';
    protected $allowedFields = ['boc_code', 'bod_level', 'bod_sort', 'bod_mem_id', 'bod_origin_mem_idx',
                                'bod_writer_name', 'bod_password', 'bod_secret', 'bod_category', 'bod_title',
                                'bod_use_editor', 'bod_content', 'bod_read', 'bod_movie_url', 'bod_is_notice',
                                'bod_created_id', 'bod_created_ip', 'bod_created_at',
                                'bod_updated_id', 'bod_updated_ip', 'bod_updated_at',
                                'bod_deleted_id', 'bod_deleted_ip', 'bod_deleted_at'];


    /** 게시판 코드에 따른 사용 테이블 할당
     * @param $bod_code
     */
    public function setDataTable($bod_code){
        $this->setTable("board_data_".$bod_code);
    }


}
