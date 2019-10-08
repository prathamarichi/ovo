<?php

namespace System\Libraries\General;

class Format
{
    public function money($amount=0)
    {
        return number_format($amount, 2, ',', '.');
    }
    
    public function date($datetime=false)
    {
        if($datetime){
            return \date("m/d/Y", \strtotime($datetime));
        }

        return 'undefined';
    }
    
    public function datetime($datetime=false)
    {
        if($datetime){
            return \date("m/d/Y H:i:s", \strtotime($datetime));
        }

        return 'undefined';
    }
}
