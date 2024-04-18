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
$F3->route('GET|POST /order1', function($F3){
    if($_SERVER['REQUEST_METHOD']=="POST"){

        $food = $_POST['food'];
        $meal = $_POST['meal'];
        if(true){

            $F3->set('SESSION.food',$food);
            $F3->set('SESSION.meal',$meal);
            $F3->reroute('order2');
        } else{

            echo "<p>Validation errors</p>";
        }
    }

    $view=new Template();
    echo $view->render('view/order1.html');
});
// Order Form Part Two
$F3->route('GET|POST /order2', function($F3){
    var_dump($F3->get('SESSION'));
    if($_SERVER['REQUEST_METHOD']=="POST"){

    }else{

    }
    $view=new Template();
    echo $view->render('view/order2.html');
});

//summary route thingy
$F3->route('GET|POST /summary', function(){
    $view=new Template();
    echo $view->render('view/summary.html');
});

$F3->run();