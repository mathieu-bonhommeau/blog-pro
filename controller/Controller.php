<?php

namespace controller;
use Twig;

class Controller
{
    protected $twig;

    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment($loader, ['cache' => false, 'debug' => true]); //'/tmp' 
    }
}