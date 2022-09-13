<?php
/**
 * 공통 파일 업로드 처리 라이브러리
 */

namespace App\Libraries;

class Uploader
{

    protected $request; // request 객체
    protected $ready_to_del = array();    // 신규파일이 업로드되고 삭제 대기 상태의 파일
    protected $allow_type = array('jpg', 'jpeg', 'gif', 'png', 'hwp', 'pdf', 'zip', 'txt', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx'); // 업로드 가능한 확장자 지정

    public function __construct()
    {
        $this->request = \Config\Services::request();
    }

    public function upload($path)
    {
        // 이미지 업로드
        $path .= '/' . date("Y/m");

        $files = $this->request->getFiles();    //  파일 정보를 가지고 오기   명칭에 대한 규칙 정하기
        print_array($files);
        exit;
        $fileInfo = array();
        $fileInfo['hasError'] = false;  //  오류 플래그
        if ($file->hasMoved() === false) {  // 파일이 임시 디렉토리에서 실제 저장 디렉토리로 이동했는지 알아보려면 ->hasMoved()를 사용합니다.

            if (!array_search($file->guessExtension(), $this->allow_type)) { //  허용한 타입의 확장자인지 확인

                $fileInfo['hasError'] = true;
                $fileInfo['errorString'] = '파일 유효성 검사 실패';

            } else {

                $fileInfo['clientName'] = $file->getClientName(); // 사용자가 입력한 파일 이름
                $fileInfo['name'] = $file->getName(); // 저장된 이름을 반환
                $fileInfo['guessExtention'] = $file->guessExtension(); // 실제 확장자
                //$fileInfo['mimeType'] = $file->getMimeType();  //  첨부한 파일은 확장자 알아내기 (임시디렉토리에 있을 때만 사용 가능)
                //$fileInfo['clientMimeType'] = $file->getClientMimeType(); // 웹 브라우저가 보낸 mimeType
                //$fileInfo['clientExtention'] = $file->getClientExtension(); // 웹브라우저가 보낸 확장자

                $savedPath = $file->store($path); //  임시 디렉토리에서 저장 디렉토리로 이동
                $fileInfo['savedPath'] = $savedPath;
            }

        }

        return $fileInfo;
    }

    public function multiUpload($path)
    {
        $path .= '/' . date("Y/m");

        $files = $this->request->getFileMultiple('userfile');

        $fileInfo = array();
        foreach ($files as $key => $file) {

            if ($file->getError() != 0) {   //  0 업로드가 성공, 그 외는 실패 (https://www.php.net/manual/en/features.file-upload.errors.php)

                $errorString = $file->getErrorString();
                $errorCode = $file->getError();
                $fileInfo[$key]['hasError'] = true;
                $fileInfo[$key]['errorString'] = $errorString;
                $fileInfo[$key]['errorCode'] = $errorCode;

            } else {

                $fileInfo[$key]['hasError'] = false;
                if ($file->hasMoved() === false) {  //  파일이 임시 디렉토리에서 실제 저장 디렉토리로 이동했는지 확인

                    if (!array_search($file->guessExtension(), $this->allow_type)) { //  허용한 타입의 확장자인지 확인

                        $fileInfo[$key]['hasError'] = true;
                        $fileInfo[$key]['errorString'] = '파일 유효성 검사 실패';

                    } else {

                        $fileInfo[$key]['clientName'] = $file->getClientName();
                        $fileInfo[$key]['name'] = $file->getName();
                        $fileInfo[$key]['guessExtention'] = $file->guessExtension();

                        $savedPath = $file->store($path);
                        $fileInfo[$key]['savedPath'] = $savedPath;

                    }

                }

            }

        }

        return $fileInfo;

    }

    public function file_del($path)
    {
        if (file_exists(WRITEPATH . "uploads/" . $path)) {
            @unlink(WRITEPATH . "uploads/" . $path);
        }
    }


}

