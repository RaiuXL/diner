<?php

// 328/diner (Kinda like my notes)
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');
require_once ('controllers/controller.php');

$F3 = Base::instance();
$con = new Controller($F3);

// Default Route
$F3->route('GET /', function(){
    $GLOBALS['con']->home();
});

// Summary Route
$F3->route('GET|POST /summary', function(){
    $GLOBALS['con']->summary();
});

// Meal Menu - They don't do anything really
$F3->route('GET /menus/breakfast', function(){
    $GLOBALS['con']->viewBreakfast();

});
$F3->route('GET /menus/lunch', function(){
    $GLOBALS['con']->viewLunch();

});
$F3->route('GET /menus/dinner', function(){
    $GLOBALS['con']->viewDinner();
});

// Order Form Part One
$F3->route('GET|POST /order1', function() {
    $GLOBALS['con']->order1();
});

// Order Form part Two
$F3->route('GET|POST /order2', function() {
    $GLOBALS['con']->order2();
});

$F3->run();