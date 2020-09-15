<?php

/**
 * This class contains GlobalVar class
 */
namespace config;

/**
 * Class for manage superglobales
 * 
 * PHP version 7.3.12
 * 
 * @category  Config
 * @package   \config
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class GlobalVar
{

    /**
     * Getter $_GET
     * 
     * @return mixed
     */
    public function get($index) 
    {
        return filter_input(INPUT_GET, $index);
    }

    /**
     * If $_GET isset
     * 
     * @param string $index Name of index
     * 
     * @return bool  
     */
    public function issetGet($index)
    {
        $index = htmlspecialchars($index);
        $get = filter_input(INPUT_GET, $index);
        if (isset($get)) {
            return true;
        }
        return false;
    }

    /**
     * Getter $_POST
     * 
     * @return mixed
     */
    public function post($index) 
    {
        return filter_input(INPUT_POST, $index);
    }

    /**
     * Setter $_POST
     * 
     * @param string $index Name of index
     * @param string $value Value of index
     * 
     * @return mixed
     */
    public function setPost($index, $value) 
    {
        return $_POST[$index] = $value;
    }

    /**
     * If $_POST isset
     * 
     * @param string $index Name of index
     * 
     * @return bool  
     */
    public function issetPost($index)
    {
        $index = htmlspecialchars($index);
        $post =  filter_input(INPUT_POST, $index);
        if (isset($post)) {
            return true;
        }
        return false;
    }

    /**
     * If $_POST no empty
     * 
     * @param string $index Name of index
     * 
     * @return bool  
     */
    public function noEmptyPost($index)
    {
        $index = htmlspecialchars($index);
        $post =  filter_input(INPUT_POST, $index);
        if (!empty($post)) {
            return true;
        }
        return false;
    }

    /**
     * If $_POST empty
     * 
     * @param string $index Name of index
     * 
     * @return bool  
     */
    public function emptyPost($index)
    {
        $index = htmlspecialchars($index);
        $post =  filter_input(INPUT_POST, $index);
        if (empty($post)) {
            return true;
        }
        return false;
    }

    /**
     * Getter $_SESSION
     * 
     * @return mixed
     */
    public function session($index)
    {
        if (isset($_SESSION[$index])) {
            return $_SESSION[$index];
        }
    }

    /**
     * Setter $_SESSION
     * 
     * @param string $index Name of index
     * @param string $value Value of index
     * 
     * @return mixed
     */
    public function setSession($index, $value) 
    {
        return $_SESSION[$index] = $value;
    }

    /**
     * If $_SESSION isset
     * 
     * @param string $index Name of index
     * 
     * @return bool  
     */
    public function issetSession($index)
    {
        $index = htmlspecialchars($index);
        if (isset($_SESSION[$index])) {
            return true;
        }
        return false;
    }

    /**
     * Unset $_SESSION
     * 
     * @param string $index Name of index
     * 
     * @return bool
     */
    public function unsetSession($index)
    {
        if (isset($_SESSION[$index])) {
            unset($_SESSION[$index]);
            return true;
        }
        return false;
        
    }
}
   