<?php

namespace System\Libraries\General;

use System\Models\User as UserModel;

class User
{
    public function getById($userId=false)
    {
        if(!$userId){
            return false;
        }

        $userId = \intval($userId);

        //later you can store the user by id at redis, make it expired like 1 day or so
        $user = UserModel::findFirst($userId);

        return $user;
    }

    public function getUserList()
    {
        //later you can store the total user and list user at redis, make it expired like 1 hour or so
        //check the total user at db, if still same then display the list from redis/other cached management
        $users = UserModel::find(
            array(
                "order" => "id asc"
            )
        );

        return $users;
    }
}
