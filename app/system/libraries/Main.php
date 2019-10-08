<?php

namespace System\Libraries;

use System\Models\Publisher;
use System\Models\Whitelabel;

use Phalcon\Di;
use \Phalcon\Mvc\Model\Manager as ModelManager;
use Defuse\Crypto\Key;

class Main
{
    protected $_session = null;
    protected $_config = null;
    protected $_modelsManager = null;

    protected $_applicationName = null;
    protected $_template = null;
    protected $_developmentMode = false;

    protected $_publisher = null;
    protected $_whitelabel = null;
    protected $_keyAscii = "def000009d05420a4036d3e451f6fdc6a44035dcfd2f470354adf4bbeb217b7fe94af006d56eabde9085a3f8f88267ab307233be916f74f1ba55389a09ff6c9600a58c33";

    public function __construct()
    {
        $this->_config = require __DIR__ . '/../../config/config.php';
        $this->_modelsManager = new ModelManager();

        $this->_setApplication();
    }

    protected function _setApplication()
    {
        $this->_session = Di::getDefault()->getSession();
    }

    function loadEncryptionKeyFromConfig()
    {
        $keyAscii = "def000009d05420a4036d3e451f6fdc6a44035dcfd2f470354adf4bbeb217b7fe94af006d56eabde9085a3f8f88267ab307233be916f74f1ba55389a09ff6c9600a58c33";

        return Key::loadFromAsciiSafeString($keyAscii);
    }
}