<?php

use System\Libraries\General\User as UserLibrary;

class UserTask extends \Phalcon\Cli\Task
{

    public function showAction(array $params=array())
    {   
        $userLib = new UserLibrary();
        $users = $userLib->getUserList();
        
        echo "List of user:\n";
        foreach($users as $user){
            echo "ID (Name): ".$user->getId()." (".$user->getName().")\n";
        }

        return true;
    }
}
