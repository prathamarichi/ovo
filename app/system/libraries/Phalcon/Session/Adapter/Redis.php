<?php
/*
  +------------------------------------------------------------------------+
  | Phalcon Framework                                                      |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2012 Phalcon Team (http://www.phalconphp.com)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file docs/LICENSE.txt.                        |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: kenjikobe <kenji.minamoto@gmail.com>                          |
  +------------------------------------------------------------------------+
*/
namespace Phalcon\Libraries\Session\Adapter;

use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter;
//use Phalcon\Session\AdapterInterface;
use Phalcon\Session\Exception;

/**
 * Phalcon\Session\Adapter\Redis
 * Database adapter for Phalcon\Session
 */
class Redis extends Adapter// implements AdapterInterface
{
    /**
     * Class constructor.
     *
     * @param  array $options
     * @throws \Phalcon\Session\Exception
     */
    public function __construct($options = null)
    {
        if (!isset($options['path'])) {
            throw new Exception("The parameter 'save_path' is required");
        }
        ini_set('session.save_handler', 'redis');
        ini_set('session.save_path', $options['path']);
        if (isset($options['name'])) {
            ini_set('session.name', $options['name']);
        }
        if (isset($options['cookie_lifetime'])) {
            ini_set('session.cookie_lifetime', $options['cookie_lifetime']);
        }
        if (isset($options['cookie_secure'])) {
            ini_set('session.cookie_secure', $options['cookie_secure']);
        }
        parent::__construct($options);
        if (!$this->isStarted()) {
            $this->start();
        }

        if ($this->has('lifetime')) {
            ini_set('session.gc_maxlifetime', $this->get('lifetime'));
        } elseif (isset($options['lifetime'])) {
            $this->set('lifetime', $options['lifetime']);
            ini_set('session.gc_maxlifetime', $options['lifetime']);
        } else {
            $this->set('lifetime', ini_get('session.gc_maxlifetime'));
        }
    }

    public function change_session_timeout($ttl)
    {
        $this->set('lifetime', $ttl);
        ini_set('session.gc_maxlifetime', $ttl);
    }

    public function change_cookie_timeout($ttl)
    {
        //if (isset($options['lifetime'])) {
        ini_set('session.cookie_lifetime', $ttl);
        //}
    }
}