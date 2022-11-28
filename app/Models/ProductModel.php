<?php

namespace App\Models;

class ProductModel extends BaseModel
{

    protected $table = 'product';
    protected $prefix = 'prd';
    protected $allowedFields = ['prd_mem_id', 'prd_cat_idx1', 'prd_cat_idx2', 'prd_state', 'prd_sort',
                                'prd_title', 'prd_subtitle', 'prd_code', 'prd_price_type', 'prd_common_price',
                                'prd_price', 'prd_additional', 'prd_price_notice', 'prd_content',
                                'prd_thumb1', 'prd_thumb2', 'prd_thumb3', 'prd_thumb4', 'prd_thumb5',
                                'prd_thumb6', 'prd_thumb7', 'prd_thumb8', 'prd_thumb9', 'prd_thumb10',
                                'prd_created_id', 'prd_created_ip', 'prd_created_at',
                                'prd_updated_id', 'prd_updated_ip', 'prd_updated_at',
                                'prd_deleted_id', 'prd_deleted_ip', 'prd_deleted_at',];


}
