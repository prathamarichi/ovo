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
  | Author: Tuğrul Topuz <tugrultopuz@gmail.com>                           |
  +------------------------------------------------------------------------+
*/
namespace Phalcon\Libraries\Http\Client\Provider;

use Phalcon\Libraries\Http\Client\Exception as HttpException;
use Phalcon\Libraries\Http\Client\Provider\Exception as ProviderException;
use Phalcon\Libraries\Http\Client\Request;
use Phalcon\Libraries\Http\Client\Response;

class Curl extends Request
{
    private $handle = null;

    public static function isAvailable()
    {
        return extension_loaded('curl');
    }

    public function __construct()
    {
        if (!self::isAvailable()) {
            throw new ProviderException('CURL extension is not loaded');
        }

        $this->handle = curl_init();
        $this->initOptions();
        parent::__construct();
    }

    public function __destruct()
    {
        curl_close($this->handle);
    }

    public function __clone()
    {
        $request = new self;
        $request->handle = curl_copy_handle($this->handle);

        return $request;
    }

    private function initOptions()
    {
        $this->setOptions(array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 20,
            CURLOPT_HEADER => true,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_USERAGENT => 'Phalcon HTTP/' . self::VERSION . ' (Curl)',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 30
        ));
    }

    public function setOption($option, $value)
    {
        if ($option == CURLOPT_URL && strpos($value, '@')) {
            $parsed = parse_url($value);
            if (!empty($url['user'])) {
                //set auth here
                curl_setopt($this->handle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
                curl_setopt($this->handle, CURLOPT_USERPWD, $parsed['user'] . ':' . $parsed['pass']);

                unset($parsed['user'], $parsed['pass']);
                $value = static::unparse_url($parsed);
            }

            $options[$option] = $value;
        }
        return curl_setopt($this->handle, $option, $value);
    }

    public function setOptions($options)
    {
        foreach ($options as $key => $option) {
            if ($key == CURLOPT_URL) {

                if (!strpos($option, '@')) break;
                $parsed = parse_url($option);
                if (!empty($parsed['user'])) {
                    //set auth here
                    $options[CURLOPT_HTTPAUTH] = CURLAUTH_DIGEST;
                    $options[CURLOPT_USERPWD] = $parsed['user'] . ':' . $parsed['pass'];
                    unset($parsed['user'], $parsed['pass']);
                    $option = static::unparse_url($parsed);
                    $options[$key] = $option;
                }

                break;
            }
        }
        return curl_setopt_array($this->handle, $options);
    }

    public function setTimeout($timeout)
    {
        $this->setOption(CURLOPT_TIMEOUT, $timeout);
    }

    public function setConnectTimeout($timeout)
    {
        $this->setOption(CURLOPT_CONNECTTIMEOUT, $timeout);
    }

    private function send($customHeader = array(), $fullResponse = false)
    {
        if (!empty($customHeader)) {
            $header = $customHeader;
        } else {
            $header = array();
            if (count($this->header) > 0) {
                $header = $this->header->build();
            }
            $header[] = 'Expect:';
        }

        array_walk($header, function (&$item1, $key) {
            if (!is_numeric($key)) $item1 = $key . ': ' . $item1;
        });
        $this->setOption(CURLOPT_HTTPHEADER, $header);
        $this->setOption(CURLOPT_DNS_CACHE_TIMEOUT, 43200);
        $this->setOption(CURLINFO_HEADER_OUT, TRUE);
        $this->setOption(CURLOPT_FOLLOWLOCATION, TRUE);
        $this->setOption(CURLOPT_MAXREDIRS, 5);
        $content = curl_exec($this->handle);

        if ($errno = curl_errno($this->handle)) {
            throw new HttpException(curl_error($this->handle), $errno);
        }

        $headerSize = curl_getinfo($this->handle, CURLINFO_HEADER_SIZE);

        $response = new Response();
        $response->header->parse(substr($content, 0, $headerSize));

        if ($fullResponse) {
            $response->body = $content;
        } else {
            $response->body = substr($content, $headerSize);
        }

        return $response;
    }

    /**
     * Prepare data for a cURL post.
     *
     * @param mixed $params Data to send.
     * @param boolean $useEncoding Whether to url-encode params. Defaults to true.
     *
     * @return void
     */
    private function initPostFields($params, $useEncoding = true)
    {
        if (is_array($params)) {
            foreach ($params as $param) {
                if (is_string($param) && preg_match('/^@/', $param)) {
                    $useEncoding = false;
                    break;
                }
            }

            if ($useEncoding) {
                $params = http_build_query($params);
            }
        }

        if (!empty($params)) {
            $this->setOption(CURLOPT_POSTFIELDS, $params);
        }
    }

    public function setProxy($host, $port = 8080, $user = null, $pass = null)
    {
        $this->setOptions(array(
            CURLOPT_PROXY => $host,
            CURLOPT_PROXYPORT => $port
        ));

        if (!empty($user) && is_string($user)) {
            $pair = $user;
            if (!empty($pass) && is_string($pass)) {
                $pair .= ':' . $pass;
            }
            $this->setOption(CURLOPT_PROXYUSERPWD, $pair);
        }
    }

    public function get($uri, $params = array(), $customHeader = array(), $fullResponse = false)
    {
        $uri = $this->resolveUri($uri);
        if (!empty($params)) {
            $uri->extendQuery($params);
        }
        //var_dump($uri->build());
        //if(!strpos((string)$uri->build(),'customer'))die();
        $this->setOptions(array(
            CURLOPT_URL => $uri->build(),
            CURLOPT_HTTPGET => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));

        return $this->send($customHeader, $fullResponse);
    }

    public function head($uri, $params = array(), $customHeader = array(), $fullResponse = false)
    {
        $uri = $this->resolveUri($uri);

        if (!empty($params)) {
            $uri->extendQuery($params);
        }

        $this->setOptions(array(
            CURLOPT_URL => $uri->build(),
            CURLOPT_HTTPGET => true,
            CURLOPT_CUSTOMREQUEST => 'HEAD'
        ));

        return $this->send($customHeader, $fullResponse);
    }

    public function delete($uri, $params = array(), $customHeader = array(), $fullResponse = false)
    {
        $uri = $this->resolveUri($uri);

        if (!empty($params)) {
            $uri->extendQuery($params);
        }

        $this->setOptions(array(
            CURLOPT_URL => $uri->build(),
            CURLOPT_HTTPGET => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ));

        return $this->send($customHeader, $fullResponse);
    }

    public function post($uri, $params = array(), $customHeader = array(), $fullResponse = false, $useEncoding = false)
    {
        $this->setOptions(array(
            CURLOPT_URL => $this->resolveUri($uri),
            CURLOPT_POST => $useEncoding,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));

        $this->initPostFields($params, $useEncoding);

        return $this->send($customHeader, $fullResponse);
    }

    public function put($uri, $params = array(), $customHeader = array(), $fullResponse = false, $useEncoding = true)
    {
        $this->setOptions(array(
            CURLOPT_URL => $this->resolveUri($uri),
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'PUT'
        ));

        $this->initPostFields($params, $useEncoding, $customHeader);

        return $this->send($customHeader, $fullResponse);
    }

    public static function unparse_url($parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) && $parsed_url['port'] != 80 ? ':' . $parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }

}
