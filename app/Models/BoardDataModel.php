<?php

namespace App\Models;

class BoardDataModel extends BaseModel
{

    protected $table = 'board';
    protected $prefix = 'bod';
    protected $allowedFields = ['bod_group', 'bod_level', 'bod_sort', 'bod_mem_id', 'bod_origin_mem_idx',
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

    /**
     * 다음 그룹번호 구해서 리턴하기
     * @return int|mixed
     */
    public function getNextGroupNum(){
        $this->select("max(bod_group) as bod_group");
        if($row = $this->get()->getRowArray()){
            $BDgroup = $row["bod_group"]+1;
        }else{
            $BDgroup = 1;
        }
        return $BDgroup;
    }

    /**
     * 답변글 자리 구하기
     * bod_group, bod_sort, bod_level 값을 담아서 던져줄 것
     * @param $option
     */
    public function getReplyPosition($option){
        $this->where("bod_group='" . $option["bod_group"] . "' and bod_sort>='" . $option["bod_sort"] . "'");
        $this->orderBy("bod_sort","asc");
        $REresult = $this->get();
        $bod_sort = 1;
        foreach($REresult->getResultArray() as $RErs){
            if($RErs["bod_level"]>=$option["bod_level"])$bod_sort=$RErs["bod_sort"]+1;
            else break;
        }
        return $bod_sort;
    }

    /**
     * 답변글 작성시 글 순서 뒤로 밀기
     * @param $group
     * @param $sort
     */
    public function setReplySort($group,$sort){
        $this->updatedField = "";   // updated_at 필드 업데이트 방지
        $this->where("bod_group",$group);
        $this->where("bod_sort>=",$sort);
        $this->set("bod_sort","bod_sort+1",false);
        $this->update();
    }


}
