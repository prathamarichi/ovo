<?php

use System\Libraries\General\User as UserLibrary;
use System\Libraries\General\Reward as RewardLibrary;
use System\Libraries\General\Format as FormatLibrary;

class RewardTask extends \Phalcon\Cli\Task
{

    protected $_maxDailyLimit = 200000;

    public function mainAction(array $params=array())
    {   
        echo "List of Command:\n- Type 'reward clear [date(opt)]' to remove all reward list within the date\n- Type 'reward record' to display reward list\n- Type 'reward left [date(opt)]' to check reward amount left\n- Type 'reward input [user_id] [reward_amount] [date(opt)]' to input new reward (e.g.: reward input 1 10000 2019-01-01)\n";

        return true;
    }

    public function recordAction(array $params=array())
    {
        $date = \date("Y-m-d");
        if(isset($params[0])){
            $date = \date("Y-m-d", \strtotime($params[0]));
        }

        $format = new FormatLibrary();
        $rewardLib = new RewardLibrary();
        $rewards = $rewardLib->getDailyRewards($date);

        echo "List of reward ".$format->date($date).":\n";
        if(count($rewards) == 0){
            echo "No reward exist \n";
        }else{
            echo "Reward ID | Name | Reward | Actual Reward | Transaction Time \n";
            foreach($rewards as $reward){
                echo $reward->getId()." | ".$reward->getName()." | ".$format->money($reward->getRewardAmount())." | ".$format->money($reward->getRewardRealAmount())." | ".$format->datetime($reward->getTransactionTime())." \n";
            }
        }

        return true;
    }

    public function clearAction(array $params=array())
    {
        $date = \date("Y-m-d");
        if(isset($params[0])){
            $date = \date("Y-m-d", \strtotime($params[0]));
        }

        $format = new FormatLibrary();
        $rewardLib = new RewardLibrary();
        $rewardLib->clearUserDailyUsage($date);

        echo "Clear all reward at ".$format->date($date).":\n";

        return true;
    }

    public function leftAction(array $params=array())
    {
        $date = \date("Y-m-d");
        if(isset($params[0])){
            $date = \date("Y-m-d", \strtotime($params[0]));
        }

        $format = new FormatLibrary();
        $rewardLib = new RewardLibrary();
        $rewardUsage = $rewardLib->getDailyUsage($date);

        echo "Reward left: ".$format->money($this->_maxDailyLimit - $rewardUsage)."\n";

        return true;
    }

    public function inputAction(array $params=array())
    {
        if(!isset($params[0])){
            echo "Invalid User ID\n";

            return false;
        }

        if(!isset($params[1])){
            echo "Invalid Reward Amount\n";

            return false;
        }

        $userId = intval($params[0]);
        $rewardAmount = floatval($params[1]);

        //user_id] [reward_amount] [date
        $date = \date("Y-m-d");
        if(isset($params[2])){
            $date = \date("Y-m-d", \strtotime($params[2]));
        }

        $format = new FormatLibrary();
        $rewardLib = new RewardLibrary();

        $data = array();
        try{
            $data = $rewardLib->insertUserDailyReward($this->_maxDailyLimit, $userId, $date, $rewardAmount);
        }catch (\Exception $e) {
            echo $e->getMessage()."\n";

            return false;
        }

        if(isset($data["reward_left"])){
            echo "Reward left: ".$format->money($data["reward_left"])."\n";
        }else{
            echo "Reward left: [undefined]\n";
        }

        return true;
    }
}
