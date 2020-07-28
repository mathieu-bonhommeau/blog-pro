<?php

class Controller
{

    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        return $twig = new Twig\Environment($loader, ['cache' => false]); //'/tmp'
    }
}