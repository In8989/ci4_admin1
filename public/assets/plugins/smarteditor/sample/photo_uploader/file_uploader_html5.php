<?php
$sFileInfo = '';
$headers = array();

foreach($_SERVER as $k => $v) {
	if(substr($k, 0, 9) == "HTTP_FILE") {
		$k = substr(strtolower($k), 5);
		$headers[$k] = $v;
	}
}

$file = new stdClass;
$file->name = str_replace("\0", "", rawurldecode($headers['file_name']));
$file->size = $headers['file_size'];
$file->content = file_get_contents("php://input");

//$filename_ext = strtolower(array_pop(explode('.',$file->name)));
$tmp = explode('.', $file->name);
$filename_ext = end($tmp);

$allow_file = array("jpg", "png", "bmp", "gif");

if(!in_array($filename_ext, $allow_file)) {
	echo "NOTALLOW_".$file->name;
} else {

	if($_GET["fPath"]){
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/../writable/uploads/editor/";
		if(!is_dir($uploadDir)){
			@mkdir($uploadDir, 0777);
			@chmod($uploadDir, 0777);
		}
			
		$uploadDir.=$_GET["fPath"] . "/";
		if(!is_dir($uploadDir)){
			@mkdir($uploadDir, 0777);
			@chmod($uploadDir, 0777);
		}
			
		$uploadDir.=date("Ym") ."/";
		if(!is_dir($uploadDir)){
			@mkdir($uploadDir, 0777);
			@chmod($uploadDir, 0777);
		}

        $uploadUrl = "/uploaded/file/editor/" . $_GET["fPath"] . "/" . date("Ym") . "/";
	}else{
		$uploadDir = '../../upload/';
		$uploadUrl = "upload/";
	}

	if(!is_dir($uploadDir)){
		@mkdir($uploadDir, 0777);
		@chmod($uploadDir, 0777);
	}

	//-- 새로운 파일명 지정
	//$newFileName = date("YmdHis") . rand(100,999) . "." .  $filename_ext;
	sleep(1);
	$newFileName = microtime(true) * 10000 . "." . $filename_ext;

	$newPath = $uploadDir.iconv("utf-8", "cp949", $newFileName);

	if(file_put_contents($newPath, $file->content)) {
		$sFileInfo .= "&bNewLine=true";
		$sFileInfo .= "&sFileName=".$newFileName;
		$sFileInfo .= "&sFileURL=".$uploadUrl.$newFileName;
	}

	echo $sFileInfo;
}
?>