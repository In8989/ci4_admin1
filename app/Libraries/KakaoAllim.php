<?php
/**
 * 카카오 알림톡 전송하기 ( Used by Direct Send https://directsend.co.kr/ )
 *
 */
namespace App\Libraries;

Class KakaoAllim {

    // API 설정용 변수
    private $api_username = "";
    private $api_key = "";

    // 메세지 전송 정보 변수
    private $receiver = array();
    private $title = "";
    private $message = "";
    private $user_template_no = "";

    private $retry_sms = true; // SMS 대체 발송 설정

    public function __construct()
    {
        /*
        $this->api_username = "directsend id";                //필수입력
        $this->api_key = "directsend 발급 api key";         //필수입력
        $this->api_kakao_plus_id = "directsend에 등록한 발신프로필 @검색용아이디";            //필수입력
        $this->user_template_no = "directsend에 등록한 템플릿 번호";            //필수입력 (하단 API 이용하여 확인)
        */

        // 기본 설정 - 직접 설정
        $this->api_username = "ydct";
        $this->api_key = "1sMrt9fa8v0jHXd";
    }

    /**
     * 수신자 추가하기
     * 형식 : 배열형
     *
     * 아래 Key 명칭 반드시 지킬 것.
     * array(
     * name=>사용자명,
     * mobile=>연락처,
     * note1=>비고1,
     * note2=>비고2,
     * note3=>비고3,
     * note4=>비고4,
     * note5=>비고5,
     * );
     */
    public function add_receiver($receiver){
        $this->receiver[] = $receiver;
    }

    /**
     * 메세지 설정하기
     * 형식 : 배열형
     *
     * 아래 Key 명칭 반드시 지킬 것.
     * array(
     * title=>제목,
     * message=>메세지,
     * sender=>발신자 번호,
     * );
     */
    public function set_message($msg){
        if(isset($msg['title']))$this->title = $msg['title'];
        if(isset($msg['template_no']))$this->user_template_no = $msg['template_no'];

        $temp_list = $this->getTemplate();
        if(isset($temp_list[$this->user_template_no])){
            $this->message = $temp_list[$this->user_template_no]['user_template_content'];
        }else{
            return false; // 지정 템플릿 없으면 전송 불가
        }

    }

    /**
     * 카카오 알림톡 발송하기
     */
    public function send(){

        /*
        echo $this->message . "<Br>";
        echo $this->user_template_no . "<Br>";
        print_r2($this->receiver);
        die("Check");
        */

        // 필수값 체크
        if(!$this->user_template_no)return false;
        if(!sizeof($this->receiver))return false;
        if(!$this->message)return false;

        $response = array();
        foreach($this->receiver as $rec) {

            $receiver = json_encode(array(0=>$rec), JSON_UNESCAPED_UNICODE);

            // 대체문자 정보 추가
            $kakao_faild_type = "1";          // 1 : 대체문자(SMS) / 2 : 대체문자(LMS) / 3 : 대체문자(MMS) 대체문자 사용시 필수 입력

            /*
            $title = "대체문자 MMS/LMS 제목입니다.";
            $message = '[$NAME]님 알림 문자 입니다. 전화번호 : [$MOBILE] 비고1 : [$NOTE1] 비고2 : [$NOTE2] 비고3 : [$NOTE3] 비고4 : [$NOTE4] 비고5 : [$NOTE5]';             //대체문자 사용시 필수입력
            $sender = "발신자번호";                    //대체문자 사용시 필수입력
            */

            // 발신자 지정
            $sender_info = $this->getSenderProfile();
            if (isset($sender_info['uuid'])) {
                $sender = '0547305800'; // 발신자 번호
                $api_kakao_plus_id = $sender_info['uuid'];
            } else {
                return false;   // 발신자 번호 없으면 발송 불가
            }

            // 예약발송 정보 추가
            $reserve_type = 'NORMAL'; // NORMAL - 즉시발송 / ONETIME - 1회예약 / WEEKLY - 매주정기예약 / MONTHLY - 매월정기예약
            $start_reserve_time = date('Y-m-d H:i:s'); //  발송하고자 하는 시간(시,분단위까지만 가능) (동일한 예약 시간으로는 200회 이상 API 호출을 할 수 없습니다.)
            $end_reserve_time = date('Y-m-d H:i:s'); //  발송이 끝나는 시간 1회 예약일 경우 $start_reserve_time = $end_reserve_time
            // WEEKLY | MONTHLY 일 경우에 시작 시간부터 끝나는 시간까지 발송되는 횟수 Ex) type = WEEKLY, start_reserve_time = '2019-08-23 10:00:00', end_reserve_time = '2019-08-30 10:00:00' 이면 remained_count = 2 로 되어야 합니다.
            $remained_count = 1;
            // 예약 수정/취소 API는 소스 하단을 참고 해주시기 바랍니다.

            // 실제 발송성공실패 여부를 받기 원하실 경우 아래 주석을 해제하신 후, 사이트에 등록한 URL 번호를 입력해 주시기 바랍니다.
            $return_url_yn = TRUE;        //return_url 사용시 필수 입력
            $return_url = 0;

            /* 여기까지 수정해주시기 바랍니다. */

            $message = str_replace(' ', ' ', $this->message);  //유니코드 공백문자 치환, 대체문자 발송시 주석 해제

            // 첨부파일이 있을 시 아래 주석을 해제하고 첨부하실 파일의 URL을 입력하여 주시기 바랍니다.
            // jpg파일당 300kb 제한 3개까지 가능합니다.
            //$file[] = array('attc' => 'https://directsend.co.kr/jpgimg1.jpg');
            //$file[] = array('attc' => 'https://directsend.co.kr/jpgimg2.jpg');
            //$file[] = array('attc' => 'https://directsend.co.kr/jpgimg3.jpg');
            //$attaches = json_encode($file);

            $postvars = '"username":"' . $this->api_username . '"';
            $postvars = $postvars . ', "key":"' . $this->api_key . '"';
            $postvars = $postvars . ', "kakao_plus_id":"' . $api_kakao_plus_id . '"';
            $postvars = $postvars . ', "user_template_no":"' . $this->user_template_no . '"';
            $postvars = $postvars . ', "receiver":' . $receiver;
            //$postvars = $postvars.', "address_books":"'.$address_books.'"';       //주소록 사용할 경우 주석 해제 바랍니다.

            if ($this->retry_sms) {
                // 문자 치환
                if(isset($rec['note1']))$message = str_replace("#{비고1}", $rec['note1'], $message);
                if(isset($rec['note2']))$message = str_replace("#{비고2}", $rec['note2'], $message);
                if(isset($rec['note3']))$message = str_replace("#{비고3}", $rec['note3'], $message);
                if(isset($rec['note4']))$message = str_replace("#{비고4}", $rec['note4'], $message);
                if(isset($rec['note5']))$message = str_replace("#{비고5}", $rec['note5'], $message);

                if($this->user_template_no=="10"){  // 템플릿 10번 문자 마지막 강제 URL 붙이기
                    $message.="\n\n티켓확인: " . BASE_URL . "/my/ticket/" .  $rec['note5'];
                }

                $postvars = $postvars . ', "kakao_faild_type":"' . $kakao_faild_type . '"'; //대체문자 사용시 주석해제 바랍니다.
                $postvars = $postvars . ', "title":"' . $this->title . '"';           //대체문자 사용시 주석해제 바랍니다.
                $postvars = $postvars . ', "message":"' . $message . '"';       //대체문자 사용시 주석해제 바랍니다
                $postvars = $postvars . ', "sender":"' . $sender . '"';         //대체문자 사용시 주석해제 바랍니다.
            }

            //$postvars = $postvars.', "reserve_type":"'.$reserve_type.'"';                // 예약 관련 정보 사용할 경우 주석 해제 바랍니다.
            //$postvars = $postvars.', "start_reserve_time":"'.$start_reserve_time.'"';    // 예약 관련 정보 사용할 경우 주석 해제 바랍니다.
            //$postvars = $postvars.', "end_reserve_time":"'.$end_reserve_time.'"';        // 예약 관련 정보 사용할 경우 주석 해제 바랍니다.
            //$postvars = $postvars.', "remained_count":"'.$remained_count.'"';            // 예약 관련 정보 사용할 경우 주석 해제 바랍니다.
            //$postvars = $postvars.', "return_url_yn":'.$return_url_yn;       // return_url이 있는 경우 주석해제 바랍니다.
            //$postvars = $postvars.', "return_url":"'.$return_url.'" ';       // return_url이 있는 경우 주석해제 바랍니다.
            //$postvars = $postvars.', "attaches":'.$attaches;   //첨부파일이 있는 경우 주석해제 바랍니다.
            $postvars = '{' . $postvars . '}';      //JSON 데이터

            $url = "https://directsend.co.kr/index.php/api_v2/kakao_notice";         //URL

            //헤더정보
            $headers = array("cache-control: no-cache", "content-type: application/json; charset=utf-8");

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response[] = curl_exec($ch);
        }

        return $response;   // 결과 리턴. 크게 사용하지는 않음.
    }

    // 템플릿 조회하기
    public function getTemplate(){

        $postvars = '{"username":"'.$this->api_username.'","key":"'.$this->api_key.'","template_type":"3"}';        //JSON 데이터
        $url = "https://directsend.co.kr/index.php/api_kakao/template/get/list";        //URL
        $ch = curl_init();
        $headers = array("cache-control: no-cache","content-type: application/json; charset=utf-8");      //헤더정보
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response,true);
        curl_close ($ch);

        if($res['result']==1) {
            $temp_data = $res['data']['list'];
            $temp_list = array();
            foreach ($temp_data as $temp) {
                $temp_list[$temp['user_template_no']] = $temp;
            }
            return $temp_list;
        }else{
            return array();
        }
    }

    // 발신자 프로파일 조회
    public function getSenderProfile(){

        $postvars = '{"username":"'.$this->api_username.'","key":"'.$this->api_key.'", "profile_type":"1"}';        //JSON 데이터
        $url = "https://directsend.co.kr/index.php/api_kakao/profile/get/list";        //URL
        $ch = curl_init();
        $headers = array("cache-control: no-cache","content-type: application/json; charset=utf-8");      //헤더정보
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $res = json_decode($response,true);
        curl_close ($ch);

        if($res['result']==1){
            return $res['data']['list'][0];
        }else{
            return array();
        }

    }






}


/*
//  컨트롤러에서 사용하는 예제

$kakao_allim = new KakaoAllim();

// 메세지 설정
$msg = array(
    "title" => "영덕문화재단 예매 안내",    // 제목
    "template_no" => "10", // 템플릿 번호
);
$kakao_allim->set_message($msg);

// 수신자 설정
$link_data = encrypt_rrn($dinfo['sbkd_sbk_idx'] . '::' . $dinfo['sbkd_seat_code'] . '::' . $dinfo['sbkd_idx']);
$receiver = array(
    "name" => $info["sbk_mem_name"], // 사용자명
    "mobile" => $info["sbk_mem_tel"],  // 예매자 연락처

    "note1" => $show_info['sho_title'],  // 공연명
    "note2" => $ssch_info['ssch_date'],  // 공연일
    "note3" => $ssch_info['ssch_time'],   // 공연시
    "note4" => $dinfo['sbkd_seat_code'],   // 좌석정보
    "note5" => $link_data,   // 좌석정보
);

$kakao_allim->add_receiver($receiver);

// 카카오 알림톡 발송
$kakao_allim->send();

*/
