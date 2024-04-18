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

$F3->route('GET /menus/breakfast', function(){
    $view=new Template();
    echo $view->render('view/breakfast-menu.html');
});
$F3->route('GET /menus/lunch', function(){
    $view=new Template();
    echo $view->render('view/lunch-menu.html');
});
$F3->route('GET /menus/dinner', function(){
    $view=new Template();
    echo $view->render('view/dinner-menu.html');
});


// Order Form Part One
$F3->route('GET /order1', function(){

    $view=new Template();
    echo $view->render('view/order1.html');
});
// Order Form Part Two
$F3->route('GET /order2', function(){

    $view=new Template();
    echo $view->render('view/order2.html');
});
$F3->run();