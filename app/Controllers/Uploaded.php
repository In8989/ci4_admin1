<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Uploaded extends BaseController
{
    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

    }

    public function file($uploaded_path)
    {
        echoDev($uploaded_path);
        exit;
        $filePath = WRITEPATH . 'uploads/' . $uploaded_path;

        $file = new \CodeIgniter\Files\File($filePath);
        if(($image = file_get_contents($filePath)) === FALSE)
            show_404();

        $mimeType = $file->getMimeType();
        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();

    }

    public function download($uploaded_path)
    {
        $filePath = WRITEPATH . 'uploads/' . $uploaded_path;

        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filePath));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            ob_clean();
            flush();
            readfile($filePath);
            exit;
        }

    }
}
