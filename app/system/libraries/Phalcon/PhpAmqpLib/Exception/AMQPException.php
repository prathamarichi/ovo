<?php
namespace Phalcon\Libraries\PhpAmqpLib\Exception;

//TODO refactor usage of static methods
use Phalcon\Libraries\PhpAmqpLib\Channel\AbstractChannel;
use Phalcon\Libraries\PhpAmqpLib\Helper\MiscHelper;

/**
 * @deprecated use AMQPProtocolException instead
 */
class AMQPException extends \Exception
{
    /** @var string */
    public $amqp_reply_code;

    /** @var int */
    public $amqp_reply_text;

    /** @var \Exception */
    public $amqp_method_sig;

    /** @var array */
    public $args;

    /**
     * @param string $reply_code
     * @param int $reply_text
     * @param \Exception $method_sig
     */
    public function __construct($reply_code, $reply_text, $method_sig)
    {
        parent::__construct($reply_text, $reply_code);

        $this->amqp_reply_code = $reply_code; // redundant, but kept for BC
        $this->amqp_reply_text = $reply_text; // redundant, but kept for BC
        $this->amqp_method_sig = $method_sig;

        $ms = MiscHelper::methodSig($method_sig);
        $PROTOCOL_CONSTANTS_CLASS = AbstractChannel::$PROTOCOL_CONSTANTS_CLASS;
        $mn = isset($PROTOCOL_CONSTANTS_CLASS::$GLOBAL_METHOD_NAMES[$ms])
            ? $PROTOCOL_CONSTANTS_CLASS::$GLOBAL_METHOD_NAMES[$ms]
            : $mn = '';

        $this->args = array($reply_code, $reply_text, $method_sig, $mn);
    }
}
