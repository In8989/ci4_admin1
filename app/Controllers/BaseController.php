<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common', 'alert'];
    protected $models = [];

    protected $search_obj, $search_count = 10;

    // 첫번째 모델용 공통 변수
    protected $model;

    // 첫번째 모델의 주키 공통 변수
    protected $primaryKey = "";

    // 기타 라이브러리 객체
    protected $session; //-- 세션 객체

    // 레이아웃 사용여부 체크 - 미사용시 header 와 view 페이지를 배열로 리턴함
    protected $useLayout = true;

    // 현재 컨트롤러 URL
    protected $cont_url;

    protected $mem_session; //-- 세션 변수
    protected $isLogin = false; //-- 로그인 관련 변수

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
    }

    public function __construct()
    {
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();

        // 공통 사용 라이브러리 생성
        $this->session = \Config\Services::session();

        //  Load Model
        foreach ($this->models as $key => $model) {
            $this->$model = model("App\Models\master\\{$model}");
            if ($key == 0) {
                $this->model = $this->$model;   // 0 번째 기번 모듈로 (컨트롤러에서 첫 번째 models 배열에 넣은 데이터
                $this->primaryKey = $this->model->primaryKey;
            }
        }

        //  검색요소 변수 추가
        for ($i = 1; $i < $this->search_count; $i++) {
            if (isset($_GET["search_obj{$i}"])) $this->search_obj[$i] = $_GET["search_obj{$i}"];
            else $this->search_obj[$i] = "";
        }

        $this->cont_url = $this->getControllerUrl();

        $this->mem_session['MIDX'] = $this->session->get("MIDX");
        $this->mem_session['MID'] = $this->session->get("MID");
        $this->mem_session['Mname'] = $this->session->get("Mname");
        $this->mem_session['Mpass'] = $this->session->get("Mpass");

        if ($this->mem_session['MIDX']) $this->isLogin = true;

    }

    public function run($path, $params = array())
    {
        $this->addCommonData($params);

        $data['head'] = view('master/layout/head');
        if (!$this->useLayout) { //  레이아웃 미사용 시 출력
            return view($path, $data);
        }
        $data['aside'] = view('master/layout/aside');
        $data['footer'] = view('master/layout/footer');
        $data['content'] = view($path, $params);

        return view("master/layout/layout", $data);
    }

    /**
     * 게시판 현재 작동중인 컨트롤러 주소 구하기 ( View 에서 URL 이동을 위함 )
     * @return string
     */
    private function getControllerUrl()
    {
        $router = service('router');
        $method = str_replace("\App\Controllers", "", $router->controllerName());
        $method = str_replace("\\", "/", $method);
        $method = strtolower($method);
        return $method;
    }

    public function delete()
    {
        $idx = $this->request->getGet('idx');

        $this->model->del($idx);

        return redirect()->to($this->viewPath);
    }

    // 데이터에 추가하기 설명 추가하기
    public function addCommonData(&$data)
    {
        $data['currentURL'] = $this->getControllerUrl();
        $data['primaryKey'] = $this->primaryKey;
        //  검색요소 변수 추가
        for ($i = 1; $i < $this->search_count; $i++) {
            if (isset($_GET["search_obj{$i}"])) $data["search_obj{$i}"] = $_GET["search_obj{$i}"];
            else $data["search_obj{$i}"] = "";
        }

    }

}
