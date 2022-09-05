<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class MasterController extends BaseController
{
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

        // 로그인 여부 체크 후 로그인 페이지로 보내기
        if (!$this->isLogin) {
            if ($this->cont_url != "/master/login") {
                //helper('alert');
                alert('로그인하세요.','/master/login');
            }
        }
    }

}
