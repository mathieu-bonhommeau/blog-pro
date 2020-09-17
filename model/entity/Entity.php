<?php

/**
 * This file contains Entity class
 */
namespace model;

/**
 * Class for entity.
 * 
 * PHP version 7.3.12
 * 
 * @category  Entity
 * @package   \model\entity
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Entity
{
    /**
     * __construct Init object
     *
     * @param array $data Array Array with database data
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this -> hydrate($data);
    }
    
    /**
     * Hydrate
     *
     * @param array $data Array Array with database data
     * 
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $key = ucfirst($key);
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this -> $method($value);
            }
        }
    }
}