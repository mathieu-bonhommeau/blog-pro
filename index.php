<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
$autoloader = new Autoloader;



//Rendu template
$loader = new Twig\Loader\FilesystemLoader('view');
$twig = new Twig\Environment(
    $loader, [
    'cache' => false //'/tmp'
    ]
);


if (isset($_GET['p']) && $_GET['p']=='home')
{
    echo $twig->render('frontView/homeView.twig');
}
elseif (isset($_GET['p']) && $_GET['p']=='listposts')
{
    echo $twig -> render('frontView/listPostView.twig');
}
else {
    echo $twig->render('frontView/homeView.twig');
}

?>


