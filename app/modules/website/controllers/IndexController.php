<?php

namespace Api\Website\Controllers;

class IndexController extends \Api\Controllers\BaseController
{

    public function indexAction()
    {
        $this->view->disable();

        // return $this->sendMessage();
        return false;
    }
}
