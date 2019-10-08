<?php

class DatetimeTask extends \Phalcon\Cli\Task
{

    public function mainAction(array $params=array())
    {   
        $string = \date("Y-m-d H:i:s");
        echo "Datetime: ".$string."\n";

        return true;
    }
}
