<?php
namespace Api\Controllers;

defined('APP_PATH') || define('APP_PATH', realpath('.'));

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

// use System\Libraries\Security\General as GeneralSecurity;

class BaseController extends Controller
{

    public function initialize()
    {
        $this->view->disable();

        // $this->_ip = GeneralSecurity::getIP();

        if ($this->request->getPost()){
            //check secure token
            $this->_requestData = $this->request->getPost();
        }
    }
    
    protected function noticeFlash($message)
    {
        $this->flash->notice($message);
    }

    protected function errorFlash($message)
    {
        $this->flash->error($message);
    }

    protected function successFlash($message)
    {
        $this->flash->success($message);
    }
}
