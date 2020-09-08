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
        $index = htmlspecialchars($index);
        $post =  filter_input(INPUT_POST, $index);
        if (isset($post)) {
            return true;
        }
        return false;
    }

    public function noEmptyPost($index)
    {
        $index = htmlspecialchars($index);
        $post =  filter_input(INPUT_POST, $index);
        if (!empty($post)) {
            return true;
        }
        return false;
    }

    public function session($index)
    {
        if (isset($_SESSION[$index])) {
            return $_SESSION[$index];
        }
    }

    public function setSession($index, $value) 
    {
        return $_SESSION[$index] = $value;
    }

    public function issetSession($index)
    {
        $index = htmlspecialchars($index);
        if (isset($_SESSION[$index])) {
            return true;
        }
        return false;
    }

    public function unsetSession($index)
    {
        if (isset($_SESSION[$index])) {
            unset($_SESSION[$index]);
            return true;
        }
        return false;
        
    }
}
   