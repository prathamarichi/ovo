<?php

class MainTask extends \Phalcon\Cli\Task
{

    public function mainAction(array $params=array())
    {   
        echo "List of Command:\n- Type 'datetime' to display current datetime\n- Type 'user show' to show list of user\n- Type 'reward' to display list of reward command\n";

        return true;
    }
}
