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
    protected $table      = 'board_file';
    protected $prefix     = 'bof';
    protected $allowedFields = ['bof_bod_code','bof_bod_idx','bof_num','bof_file_name','bof_file_save',
                                'bof_file_size','bof_down_count',
                                'bof_created_id', 'bof_created_ip', 'bof_created_at',
                                'bof_updated_id', 'bof_updated_ip', 'bof_updated_at',
                                'bof_deleted_id', 'bof_deleted_ip', 'bof_deleted_at'];

    /**
     * 게시판 첨부파일 DB 기록하기
     * @param $info
     * @throws \ReflectionException
     */
    public function edit($info){

        foreach($info["fup"] as $key=>$f){
            $f_num = str_replace("bod_file","",$key);
            $this->where("bof_deleted_at","");
            $this->where("bof_bod_code",$info["bod_code"]);
            $this->where("bof_bod_idx",$info["bod_idx"]);
            $this->where("bof_num",$f_num);
            $rs = $this->get()->getRowArray();

            // 기본 경로 삭제 (보류)
            //$f["upload"] = str_replace("/board/".$info["bod_code"]."/","",$f["upload"]);

            if($f["result"]=="success") {
                if ($rs) {   // db 수정
                    $data = array(
                        "bof_file_name" => $f["name"],
                        "bof_file_save" => $f["upload"],
                        "bof_file_size" => $f["size"],
                    );
                    $this->update($rs["bof_idx"], $data);

                } else {  // db 입력
                    $data = array(
                        "bof_bod_code" => $info["bod_code"],
                        "bof_bod_idx" => $info["bod_idx"],
                        "bof_num" => $f_num,
                        "bof_file_name" => $f["name"],
                        "bof_file_save" => $f["upload"],
                        "bof_file_size" => $f["size"],
                        "bof_down_count" => 0,
                        "bof_created_ip" => $_SERVER["REMOTE_ADDR"],
                    );
                    $this->insert($data);
                }
            }else if($f["result"]=="deleted") {
                if ($rs) {   // db 수정
                    $this->where("bof_bod_code",$info["bod_code"]);
                    $this->where("bof_idx",$rs["bof_idx"]);
                    $this->delete();
                }
            }else{  // 일단 생각해보자.

            }
        }

    }

    /**
     * 기존 업로드된 파일 정보 리턴하기
     * @param $info
     * @return array
     */
    public function getFileList($option){

        if(!$option["bod_idx"])return array();

        $this->where("bof_bod_code",$option["bod_code"]);
        if(is_array($option["bod_idx"])){
            $this->wherein("bof_bod_idx", $option["bod_idx"]);
        }else {
            $this->where("bof_bod_idx", $option["bod_idx"]);
        }
        $this->where(" ( bof_deleted_at is null or bof_deleted_at='' ) ");
        $this->orderBy("bof_num");
        $result = $this->get()->getResultArray();

        // 키 구조 변경
        $list = array();

        if(is_array($option["bod_idx"])){
            foreach ($result as $rs) {
                if(isset($option["only_image"])){
                    if($option["only_image"] && !is_image_file($rs["bof_file_name"]))continue;
                }

                $list[$rs["bof_bod_idx"]][$rs["bof_num"]] = $rs;
            }
        }else {
            foreach ($result as $rs) {
                $list[$rs["bof_num"]] = $rs;
            }
        }
        return $list;
    }

    public function downloadCount($info){
        $this->where("bof_bod_code",$info["bod_code"]);
        $this->where("bof_bod_idx",$info["bod_idx"]);
        $this->where("bof_idx",$info["bof_idx"]);
        $this->where("bof_deleted_at","");
        $this->set("bof_down_count","bof_down_count+1",false);
        $this->update();
    }

}






