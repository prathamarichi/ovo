<?php

namespace System\Libraries\Redis;

class General extends \System\Libraries\Main
{
    public function getJsonDataByKey($key){

        $redis = new \Redis();
        $redis->connect($this->_config->redis->host, $this->_config->redis->port);
        $redis->auth($this->_config->redis->auth);

        $data = $redis->get($key);

        $redis->close();

        if($data){
            return json_decode($data);
        }else{
            return false;
        }
    }
    public function setKey($key, $value){

        $redis = new \Redis();
        $redis->connect($this->_config->redis->host, $this->_config->redis->port);
        $redis->auth($this->_config->redis->auth);

        $redis->set($key, $value);

        $redis->close();

        return true;
    }
}
