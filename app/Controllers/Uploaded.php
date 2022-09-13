<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Uploaded extends BaseController
{
    private $uploaded_path;

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

        $filePath = str_replace(array('uploaded/file/', 'uploaded/download/'), '', uri_string());
        $this->uploaded_path = WRITEPATH . 'uploads/' . $filePath;
    }

    public function file()
    {
        $file = new \CodeIgniter\Files\File($this->uploaded_path);
        if (($image = file_get_contents($this->uploaded_path)) === FALSE)
            show_404();

        //$mimeType = $file->getMimeType();
        $mimeType = pathinfo($this->uploaded_path);
        $mimeType = $mimeType['extension'];

        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();

    }

    public function download()
    {
        return $this->response->download($this->uploaded_path, null);
    }
}
