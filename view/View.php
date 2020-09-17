<?php

/**
 * This file contains Controller class
 */
namespace view;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for init Twig, send email and control session
 * 
 * PHP version 7.3.12
 * 
 * @category  View
 * @package   \view
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class View
{
    protected $twig;

    /**
     * Init twig
     * 
     * @return void
     */
    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment(
            $loader, ['cache' => false, 'debug' => true]
        ); 
    }

    /**
     * This method retrieves data and page adress from the controller
     * 
     * @param array $data Data from the database
     * @param string $path Path of the twig file for the view
     * 
     * @return void
     */
    public function displayPage($data, $path)
    {
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text());

        echo $this->twig->render($path, $data);
    }
}