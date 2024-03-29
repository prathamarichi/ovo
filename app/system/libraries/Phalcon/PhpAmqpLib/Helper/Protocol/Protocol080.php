<?php

/* This file was autogenerated by spec/parser.php - Do not modify */

namespace Phalcon\Libraries\PhpAmqpLib\Helper\Protocol;

use Phalcon\Libraries\PhpAmqpLib\Wire\AMQPWriter;
use Phalcon\Libraries\PhpAmqpLib\Wire\AMQPReader;

class Protocol080
{

    /**
     * @return array
     */
    public function connectionStart($version_major = 0, $version_minor = 8, $server_properties, $mechanisms = 'PLAIN', $locales = 'en_US')
    {
        $args = new AMQPWriter();
        $args->write_octet($version_major);
        $args->write_octet($version_minor);
        $args->write_table(empty($server_properties) ? array() : $server_properties);
        $args->write_longstr($mechanisms);
        $args->write_longstr($locales);
        return array(10, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function connectionStartOk($args)
    {
        $ret = array();
        $ret[] = $args->read_table();
        $ret[] = $args->read_shortstr();
        $ret[] = $args->read_longstr();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function connectionSecure($challenge)
    {
        $args = new AMQPWriter();
        $args->write_longstr($challenge);
        return array(10, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function connectionSecureOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function connectionTune($channel_max = 0, $frame_max = 0, $heartbeat = 0)
    {
        $args = new AMQPWriter();
        $args->write_short($channel_max);
        $args->write_long($frame_max);
        $args->write_short($heartbeat);
        return array(10, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function connectionTuneOk($args)
    {
        $ret = array();
        $ret[] = $args->read_short();
        $ret[] = $args->read_long();
        $ret[] = $args->read_short();
        return $ret;
    }



    /**
     * @return array
     */
    public function connectionOpen($virtual_host = '/', $capabilities = '', $insist = false)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($virtual_host);
        $args->write_shortstr($capabilities);
        $args->write_bits(array($insist));
        return array(10, 40, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function connectionOpenOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function connectionRedirect($host, $known_hosts = '')
    {
        $args = new AMQPWriter();
        $args->write_shortstr($host);
        $args->write_shortstr($known_hosts);
        return array(10, 50, $args);
    }



    /**
     * @return array
     */
    public function connectionClose($reply_code, $reply_text = '', $class_id, $method_id)
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_short($class_id);
        $args->write_short($method_id);
        return array(10, 60, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function connectionCloseOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function channelOpen($out_of_band = '')
    {
        $args = new AMQPWriter();
        $args->write_shortstr($out_of_band);
        return array(20, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function channelOpenOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function channelFlow($active)
    {
        $args = new AMQPWriter();
        $args->write_bits(array($active));
        return array(20, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function channelFlowOk($args)
    {
        $ret = array();
        $ret[] = $args->read_bit();
        return $ret;
    }



    /**
     * @return array
     */
    public function channelAlert($reply_code, $reply_text = '', $details = array())
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_table(empty($details) ? array() : $details);
        return array(20, 30, $args);
    }



    /**
     * @return array
     */
    public function channelClose($reply_code, $reply_text = '', $class_id, $method_id)
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_short($class_id);
        $args->write_short($method_id);
        return array(20, 40, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function channelCloseOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function accessRequest($realm = '/data', $exclusive = false, $passive = true, $active = true, $write = true, $read = true)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($realm);
        $args->write_bits(array($exclusive, $passive, $active, $write, $read));
        return array(30, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function accessRequestOk($args)
    {
        $ret = array();
        $ret[] = $args->read_short();
        return $ret;
    }



    /**
     * @return array
     */
    public function exchangeDeclare($ticket = 1, $exchange, $type = 'direct', $passive = false, $durable = false, $auto_delete = false, $internal = false, $nowait = false, $arguments = array())
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($exchange);
        $args->write_shortstr($type);
        $args->write_bits(array($passive, $durable, $auto_delete, $internal, $nowait));
        $args->write_table(empty($arguments) ? array() : $arguments);
        return array(40, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function exchangeDeclareOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function exchangeDelete($ticket = 1, $exchange, $if_unused = false, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($exchange);
        $args->write_bits(array($if_unused, $nowait));
        return array(40, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function exchangeDeleteOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function queueDeclare($ticket = 1, $queue = '', $passive = false, $durable = false, $exclusive = false, $auto_delete = false, $nowait = false, $arguments = array())
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_bits(array($passive, $durable, $exclusive, $auto_delete, $nowait));
        $args->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function queueDeclareOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        $ret[] = $args->read_long();
        $ret[] = $args->read_long();
        return $ret;
    }



    /**
     * @return array
     */
    public function queueBind($ticket = 1, $queue = '', $exchange, $routing_key = '', $nowait = false, $arguments = array())
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_bits(array($nowait));
        $args->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function queueBindOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function queuePurge($ticket = 1, $queue = '', $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_bits(array($nowait));
        return array(50, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function queuePurgeOk($args)
    {
        $ret = array();
        $ret[] = $args->read_long();
        return $ret;
    }



    /**
     * @return array
     */
    public function queueDelete($ticket = 1, $queue = '', $if_unused = false, $if_empty = false, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_bits(array($if_unused, $if_empty, $nowait));
        return array(50, 40, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function queueDeleteOk($args)
    {
        $ret = array();
        $ret[] = $args->read_long();
        return $ret;
    }



    /**
     * @return array
     */
    public function queueUnbind($ticket = 1, $queue = '', $exchange, $routing_key = '', $arguments = array())
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 50, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function queueUnbindOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function basicQos($prefetch_size = 0, $prefetch_count = 0, $global = false)
    {
        $args = new AMQPWriter();
        $args->write_long($prefetch_size);
        $args->write_short($prefetch_count);
        $args->write_bits(array($global));
        return array(60, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicQosOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function basicConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($no_local, $no_ack, $exclusive, $nowait));
        return array(60, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicConsumeOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function basicCancel($consumer_tag, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($nowait));
        return array(60, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicCancelOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function basicPublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_bits(array($mandatory, $immediate));
        return array(60, 40, $args);
    }



    /**
     * @return array
     */
    public function basicReturn($reply_code, $reply_text = '', $exchange, $routing_key)
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        return array(60, 50, $args);
    }



    /**
     * @return array
     */
    public function basicDeliver($consumer_tag, $delivery_tag, $redelivered = false, $exchange, $routing_key)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($redelivered));
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        return array(60, 60, $args);
    }



    /**
     * @return array
     */
    public function basicGet($ticket = 1, $queue = '', $no_ack = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_bits(array($no_ack));
        return array(60, 70, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicGetOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longlong();
        $ret[] = $args->read_bit();
        $ret[] = $args->read_shortstr();
        $ret[] = $args->read_shortstr();
        $ret[] = $args->read_long();
        return $ret;
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicGetEmpty($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function basicAck($delivery_tag = 0, $multiple = false)
    {
        $args = new AMQPWriter();
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($multiple));
        return array(60, 80, $args);
    }



    /**
     * @return array
     */
    public function basicReject($delivery_tag, $requeue = true)
    {
        $args = new AMQPWriter();
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($requeue));
        return array(60, 90, $args);
    }



    /**
     * @return array
     */
    public function basicRecoverAsync($requeue = false)
    {
        $args = new AMQPWriter();
        $args->write_bits(array($requeue));
        return array(60, 100, $args);
    }



    /**
     * @return array
     */
    public function basicRecover($requeue = false)
    {
        $args = new AMQPWriter();
        $args->write_bits(array($requeue));
        return array(60, 110, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function basicRecoverOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function fileQos($prefetch_size = 0, $prefetch_count = 0, $global = false)
    {
        $args = new AMQPWriter();
        $args->write_long($prefetch_size);
        $args->write_short($prefetch_count);
        $args->write_bits(array($global));
        return array(70, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function fileQosOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function fileConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($no_local, $no_ack, $exclusive, $nowait));
        return array(70, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function fileConsumeOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function fileCancel($consumer_tag, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($nowait));
        return array(70, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function fileCancelOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function fileOpen($identifier, $content_size)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($identifier);
        $args->write_longlong($content_size);
        return array(70, 40, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function fileOpenOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longlong();
        return $ret;
    }



    /**
     * @return array
     */
    public function fileStage()
    {
        $args = new AMQPWriter();
        return array(70, 50, $args);
    }



    /**
     * @return array
     */
    public function filePublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false, $identifier)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_bits(array($mandatory, $immediate));
        $args->write_shortstr($identifier);
        return array(70, 60, $args);
    }



    /**
     * @return array
     */
    public function fileReturn($reply_code = 200, $reply_text = '', $exchange, $routing_key)
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        return array(70, 70, $args);
    }



    /**
     * @return array
     */
    public function fileDeliver($consumer_tag, $delivery_tag, $redelivered = false, $exchange, $routing_key, $identifier)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($redelivered));
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_shortstr($identifier);
        return array(70, 80, $args);
    }



    /**
     * @return array
     */
    public function fileAck($delivery_tag = 0, $multiple = false)
    {
        $args = new AMQPWriter();
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($multiple));
        return array(70, 90, $args);
    }



    /**
     * @return array
     */
    public function fileReject($delivery_tag, $requeue = true)
    {
        $args = new AMQPWriter();
        $args->write_longlong($delivery_tag);
        $args->write_bits(array($requeue));
        return array(70, 100, $args);
    }



    /**
     * @return array
     */
    public function streamQos($prefetch_size = 0, $prefetch_count = 0, $consume_rate = 0, $global = false)
    {
        $args = new AMQPWriter();
        $args->write_long($prefetch_size);
        $args->write_short($prefetch_count);
        $args->write_long($consume_rate);
        $args->write_bits(array($global));
        return array(80, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function streamQosOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function streamConsume($ticket = 1, $queue = '', $consumer_tag = '', $no_local = false, $exclusive = false, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($queue);
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($no_local, $exclusive, $nowait));
        return array(80, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function streamConsumeOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function streamCancel($consumer_tag, $nowait = false)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_bits(array($nowait));
        return array(80, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function streamCancelOk($args)
    {
        $ret = array();
        $ret[] = $args->read_shortstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function streamPublish($ticket = 1, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false)
    {
        $args = new AMQPWriter();
        $args->write_short($ticket);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        $args->write_bits(array($mandatory, $immediate));
        return array(80, 40, $args);
    }



    /**
     * @return array
     */
    public function streamReturn($reply_code = 200, $reply_text = '', $exchange, $routing_key)
    {
        $args = new AMQPWriter();
        $args->write_short($reply_code);
        $args->write_shortstr($reply_text);
        $args->write_shortstr($exchange);
        $args->write_shortstr($routing_key);
        return array(80, 50, $args);
    }



    /**
     * @return array
     */
    public function streamDeliver($consumer_tag, $delivery_tag, $exchange, $queue)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($consumer_tag);
        $args->write_longlong($delivery_tag);
        $args->write_shortstr($exchange);
        $args->write_shortstr($queue);
        return array(80, 60, $args);
    }



    /**
     * @return array
     */
    public function txSelect()
    {
        $args = new AMQPWriter();
        return array(90, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function txSelectOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function txCommit()
    {
        $args = new AMQPWriter();
        return array(90, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function txCommitOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function txRollback()
    {
        $args = new AMQPWriter();
        return array(90, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function txRollbackOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function dtxSelect()
    {
        $args = new AMQPWriter();
        return array(100, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function dtxSelectOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function dtxStart($dtx_identifier)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($dtx_identifier);
        return array(100, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function dtxStartOk($args)
    {
        $ret = array();
        return $ret;
    }



    /**
     * @return array
     */
    public function tunnelRequest($meta_data)
    {
        $args = new AMQPWriter();
        $args->write_table(empty($meta_data) ? array() : $meta_data);
        return array(110, 10, $args);
    }



    /**
     * @return array
     */
    public function testInteger($integer_1, $integer_2, $integer_3, $integer_4, $operation)
    {
        $args = new AMQPWriter();
        $args->write_octet($integer_1);
        $args->write_short($integer_2);
        $args->write_long($integer_3);
        $args->write_longlong($integer_4);
        $args->write_octet($operation);
        return array(120, 10, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function testIntegerOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longlong();
        return $ret;
    }



    /**
     * @return array
     */
    public function testString($string_1, $string_2, $operation)
    {
        $args = new AMQPWriter();
        $args->write_shortstr($string_1);
        $args->write_longstr($string_2);
        $args->write_octet($operation);
        return array(120, 20, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function testStringOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function testTable($table, $integer_op, $string_op)
    {
        $args = new AMQPWriter();
        $args->write_table(empty($table) ? array() : $table);
        $args->write_octet($integer_op);
        $args->write_octet($string_op);
        return array(120, 30, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function testTableOk($args)
    {
        $ret = array();
        $ret[] = $args->read_longlong();
        $ret[] = $args->read_longstr();
        return $ret;
    }



    /**
     * @return array
     */
    public function testContent()
    {
        $args = new AMQPWriter();
        return array(120, 40, $args);
    }



    /**
     * @param AMQPReader $args
     * @return array
     */
    public static function testContentOk($args)
    {
        $ret = array();
        $ret[] = $args->read_long();
        return $ret;
    }

}
