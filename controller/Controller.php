<?php

namespace controller;
use Twig;

class Controller
{
    protected $twig;
    protected $user;

    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        } else {
            $this->user = null;
        }
    }

    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment($loader, ['cache' => false, 'debug' => true]); //'/tmp' 
    }
}