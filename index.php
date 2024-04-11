<?php
//328/diner
ini_set('display_errors',1);
error_reporting(E_ALL);

require('vendor/autoload.php');

$F3 = Base::instance();

$F3->route('GET /', function(){
    $view=new Template();
    echo $view->render('view/home.html');
});

$F3->run();