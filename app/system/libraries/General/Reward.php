<?php

namespace System\Libraries\General;

use System\Models\DailyRewardUsage;

use System\Libraries\General\User as UserLibrary;

class Reward
{
    public function clearUserDailyUsage($date=false)
    {
        if(!$date){
            $date = \date("Y-m-d");
        }else{
            $date = \date("Y-m-d", \strtotime($date));
        }

        $rewards = DailyRewardUsage::find(
            array(
                'date = :date:',
                'bind' => array(
                    'date' => $date
                ),
                "order" => "transaction_time asc"
            )
        );

        $rewards->delete();
        
        return true;
    }

    public function getDailyRewards($date=false)
    {
        if(!$date){
            $date = \date("Y-m-d");
        }else{
            $date = \date("Y-m-d", \strtotime($date));
        }

        //later you can store the total reward record and list reward record at redis, make it expired like 1 hour or so
        //check the total reward record at db, if still same then display the list from redis/other cached management
        $rewards = DailyRewardUsage::find(
            array(
                'date = :date:',
                'bind' => array(
                    'date' => $date
                ),
                "order" => "transaction_time asc"
            )
        );

        return $rewards;
    }

    public function getUserDailyReward($userId=false, $date=false)
    {
        if(!$userId || !$date){
            throw new \Exception('invalid input');
        }

        $userReward = DailyRewardUsage::findFirst(
            array(
                'user = :user: and date = :date:',
                'bind' => array(
                    'user' => $userId,
                    'date' => $date
                )
            )
        );

        return $userReward;
    }

    public function insertUserDailyReward($maxDailyLimit, $userId=false, $date=false, $rewardAmount=0)
    {
        $data = array();

        $userLib = new UserLibrary();

        $user = false;
        if(!$userId){
            throw new \Exception('Invalid User ID');
        }else{
            $userId = intval($userId);

            //check if user is valid
            $user = $userLib->getById($userId);
            if(!$user){
                throw new \Exception('Invalid User ID');
            }
        }

        $rewardAmount = floatval($rewardAmount);
        if($rewardAmount == 0){
            throw new \Exception('Invalid Reward Amount');
        }

        if(!$date){
            $date = \date("Y-m-d");
        }else{
            $date = \date("Y-m-d", \strtotime($date));
        }

        $rewardUsage = $this->getDailyUsage($date);

        $rewardLeft = $maxDailyLimit - $rewardUsage;
        if($rewardLeft <= 0){
            throw new \Exception('no reward left');
        }

        $realRewardValue = $rewardAmount;
        if($rewardAmount > $rewardLeft){
            $realRewardValue = $rewardLeft;

            //calc reward left after data inserted
            $rewardLeft = 0;
        }else{
            //calc reward left after data inserted
            $rewardLeft = $rewardLeft - $rewardAmount;
        }

        //check if user already use the reward
        $userDailyReward = $this->getUserDailyReward($user->getId(), $date);
        if($userDailyReward){
            throw new \Exception('user already claim reward');
        }

        //log real trans time
        $transactionTime = \date("Y-m-d H:i:s");

        try{
            //insert reward
            $userReward = new DailyRewardUsage();
            $userReward->setUser($user->getId());
            $userReward->setDate($date);
            $userReward->setName($user->getName());
            $userReward->setRewardAmount($rewardAmount);
            $userReward->setRewardRealAmount($realRewardValue);
            $userReward->setTransactionTime($transactionTime);
            $userReward->save();


            $data["user_reward"] = $userReward;
            $data["reward_left"] = $rewardLeft;
        }catch (\Exception $e) {
            throw new \Exception('error occur, contact us');
        }

        return $data;
    }

    public function getDailyUsage($date=false)
    {
        if(!$date){
            $date = \date("Y-m-d");
        }else{
            $date = \date("Y-m-d", \strtotime($date));
        }

        $summaries = DailyRewardUsage::query()
            ->columns(
                [
                    "reward_usage" => "SUM(reward_real_amount)",
                ]
            )
            ->where("date = :date:")
            ->bind(array(
                'date' => $date
            ))
            ->execute();

        $rewardUsage = 0;
        foreach($summaries as $summary){
            $rewardUsage = $summary->reward_usage;
        }

        return $rewardUsage;
    }
}
