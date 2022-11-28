<?php

namespace App\Models;

class CategoryModel extends BaseModel
{

    protected $table = 'category';
    protected $prefix = 'cat';
    protected $allowedFields = ['cat_title', 'cat_state', 'cat_group', 'cat_level', 'cat_sort',
                                'cat_created_id', 'cat_created_ip', 'cat_created_at',
                                'cat_updated_id', 'cat_updated_ip', 'cat_updated_at',
                                'cat_deleted_id', 'cat_deleted_ip', 'cat_deleted_at',];


    /**
     * 다음 그룹번호 구해서 리턴하기
     * @return int|mixed
     */
    public function getNextGroupNum()
    {
        $this->select("max(cat_group) as cat_group");
        if ($row = $this->get()->getRowArray()) {
            $cat_group = $row["cat_group"] + 1;
        } else {
            $cat_group = 1;
        }
        return $cat_group;
    }

    /**
     * 카테고리 자리 구하기
     * cat_group, cat_level, cat_sort 값을 담아서 던져줄 것
     * @param $option
     */
    public function getNextSort($option)
    {
        $this->select("max(cat_sort) as cat_sort");
        $this->where("cat_group = {$option['cat_group']}");
        if ($row = $this->get()->getRowArray()) {
            $cat_sort = $row["cat_sort"] + 1;
        } else {
            $cat_sort = 1;
        }
        return $cat_sort;
    }

}
