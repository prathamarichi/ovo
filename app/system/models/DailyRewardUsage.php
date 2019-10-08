<?php

namespace System\Models;

class DailyRewardUsage extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $user;

    /**
     *
     * @var string
     */
    protected $date;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var double
     */
    protected $reward_amount;

    /**
     *
     * @var double
     */
    protected $reward_real_amount;

    /**
     *
     * @var string
     */
    protected $transaction_time;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field user
     *
     * @param integer $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Method to set the value of field date
     *
     * @param string $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field reward_amount
     *
     * @param double $reward_amount
     * @return $this
     */
    public function setRewardAmount($reward_amount)
    {
        $this->reward_amount = $reward_amount;

        return $this;
    }

    /**
     * Method to set the value of field reward_real_amount
     *
     * @param double $reward_real_amount
     * @return $this
     */
    public function setRewardRealAmount($reward_real_amount)
    {
        $this->reward_real_amount = $reward_real_amount;

        return $this;
    }

    /**
     * Method to set the value of field transaction_time
     *
     * @param string $transaction_time
     * @return $this
     */
    public function setTransactionTime($transaction_time)
    {
        $this->transaction_time = $transaction_time;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns the value of field date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field reward_amount
     *
     * @return string
     */
    public function getRewardAmount()
    {
        return $this->reward_amount;
    }

    /**
     * Returns the value of field reward_real_amount
     *
     * @return string
     */
    public function getRewardRealAmount()
    {
        return $this->reward_real_amount;
    }

    /**
     * Returns the value of field transaction_time
     *
     * @return string
     */
    public function getTransactionTime()
    {
        return $this->transaction_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('ovodatabase');
        $this->setSource("daily_reward_usage");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'daily_reward_usage';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DailyRewardUsage[]|DailyRewardUsage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DailyRewardUsage|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
