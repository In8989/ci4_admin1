<?php

namespace App\Models;

class BoardConfModel extends BaseModel
{

    protected $table = 'board_conf';
    protected $prefix = 'boc';
    protected $allowedFields = ['boc_code', 'boc_title', 'boc_skin', 'boc_list_size', 'boc_file_count',
                                'boc_file_size', 'boc_image_view', 'boc_new_time', 'boc_secret', 'boc_private',
                                'boc_category', 'boc_fixed_title', 'boc_auth_list', 'boc_auth_read', 'boc_auth_write',
                                'boc_auth_reply', 'boc_auth_comment', 'boc_manager', 'boc_use_editor',
                                'boc_created_id', 'boc_created_ip', 'boc_created_at',
                                'boc_updated_id', 'boc_updated_ip', 'boc_updated_at',
                                'boc_deleted_id', 'boc_deleted_ip', 'boc_deleted_at',];


    public function getInfo($boc_code = '')
    {
        if (!$boc_code) return false;

        $this->where("(boc_deleted_at is null or boc_deleted_at = '')");
        $this->where("boc_code", $boc_code);
        return $this->get()->getRowArray();
    }

    public function boardTableCreate($info)
    {

        $DBPrefix = $this->getPrefix();

        //-- 게시판 테이블 확인 / 생성
        $sql = "SHOW TABLES LIKE '" . $DBPrefix . "board_data_" . $info["boc_code"] . "'";
        $result = $this->query($sql);   //  게시판 유무 체크

        if (!$result->getRowArray()) {
            $sql = "CREATE TABLE `" . $DBPrefix . "board_data_" . $info["boc_code"] . "` (
                        `bod_idx` int(11) NOT NULL AUTO_INCREMENT,
                        `bod_group` int(11) DEFAULT NULL COMMENT '글 그룹번호',
                        `bod_level` tinyint(4) DEFAULT NULL COMMENT '글 깊이',
                        `bod_sort` tinyint(4) DEFAULT NULL COMMENT '글 출력 순서',
                        `bod_mem_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '작성자 회원 아이디',
                        `bod_origin_mem_idx` int(11) DEFAULT '0' COMMENT '원본글 작성자 회원 고유번호',
                        `bod_writer_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '작성자명',
                        `bod_password` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '글 비밀번호',
                        `bod_secret` tinyint(1) DEFAULT '0' COMMENT '비밀글 여부',
                        `bod_category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '글 분류',
                        `bod_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '글 제목',
                        `bod_use_editor` tinyint(1) DEFAULT '0' COMMENT '에디터 사용여부',
                        `bod_content` text COLLATE utf8mb4_unicode_ci COMMENT '글 내용',
                        `bod_read` tinyint(4) DEFAULT '0' COMMENT '글 조회 수',
                        `bod_movie_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '영상주소',
                        `bod_is_notice` tinyint(1) DEFAULT '0' COMMENT '공지여부',
                        `bod_created_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_created_ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_created_at` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_updated_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_updated_ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_updated_at` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_deleted_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_deleted_ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `bod_deleted_at` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        PRIMARY KEY (`bod_idx`)
            ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

            $this->query($sql);
        }

    }

}
