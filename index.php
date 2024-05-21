<?php

// 328/diner (Kinda like my notes)
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');

//static methods do not access instant data
//var_dump(DataLayer::getMeals());


$F3 = Base::instance();

// Default Route
$F3->route('GET /', function(){
    $view=new Template();
    echo $view->render('view/home.html');
});

// Summary Route
$F3->route('GET|POST /summary', function($F3){
    $view=new Template();
    echo $view->render('view/summary.html');
});

// Meal Menu - They don't do anything really
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
$F3->route('GET|POST /order1', function($F3) {
    // Placeholder
    $food = "";
    $meal = "";

    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       // Check is the value for 'food' is valid, if not then set a message in errors[]
        if (validate::validFood($_POST['food'])) {
            $food = $_POST['food'];
        }
        else {
            $F3->set('errors["food"]', 'Please enter a food');
        }

        // Check if the value for 'meal' is valid, if not then set a message in errors[]
        if (isset($_POST['meal']) and validate::validMeal($_POST['meal'])) {
            $meal = $_POST['meal'];
        }
        else {
            $F3->set('errors["meal"]', 'Please select a meal');
        }

        // Add the data to the session array after it's validated
        $order = new Order($food,$meal);
        $F3->set('SESSION.order', $order);


        // If there are no elements in errors[], proceed to next page
        if(empty($F3->get('errors'))) {
            $F3->reroute('order2');
        }
    }

    // Getting data for Radio Buttons
    $meals = DataLayer::getMeals();
    $F3->set('meals', $meals);

    // Render a view page
    $view = new Template();
    echo $view->render('view/order1.html');
});

// Order Form part two
$F3->route('GET|POST /order2', function($F3) {

    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Not checking validation since it's check boxes
        if (isset($_POST['conds'])) {
            $condiments = implode(", ", $_POST['conds']);
        }
        else{
            $condiments = "None selected";
        }

        // If the data valid and everything checks out
        if (true) {
            // Add the data to the session array
            $F3->get('SESSION.order')->setCondiments($condiments);

            // Send the user to the next form
            $F3->reroute('summary');
        }
        else {
            echo "<p>Validation errors</p>";
        }
    }

    // Get the data from the model for Check Box Data
    $condiments = DataLayer::getCondiments();
    $F3->set('condiments', $condiments);

    // Render a view page
    $view = new Template();
    echo $view->render('view/order2.html');
});



$F3->run();