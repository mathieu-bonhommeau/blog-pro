<?php

namespace config;

class GlobalVar
{

    public function get($index) 
    {
        return filter_input(INPUT_GET, $index);
    }

    public function issetGet($index)
    {
        $index = htmlspecialchars($index);
        $get = filter_input(INPUT_GET, $index);
        if (isset($get)) {
            return true;
        }
        return false;
    }

    public function post($index) 
    {
        return filter_input(INPUT_POST, $index);
    }

    public function issetPost($index)
    {
        $index = addslashes($index);
        $post =  filter_input(INPUT_POST, $index);
        if (isset($post)) {
            return true;
        }
        return false;
    }

    public function session($index)
    {
        
    }
}
   