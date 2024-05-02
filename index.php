<?php
//328/diner
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validate.php');

$F3 = Base::instance();

// Default Route
$F3->route('GET /', function(){
    $view=new Template();
    echo $view->render('view/home.html');
});

// Breakfast Menu
$F3->route('GET /menus/breakfast', function(){
    $view=new Template();
    echo $view->render('view/breakfast-menu.html');
});

// Lunch Menu
$F3->route('GET /menus/lunch', function(){
    $view=new Template();
    echo $view->render('view/lunch-menu.html');
});

// Dinner Menu
$F3->route('GET /menus/dinner', function(){
    $view=new Template();
    echo $view->render('view/dinner-menu.html');
});

// Summary Route
$F3->route('GET|POST /summary', function($F3){
    var_dump($F3->get('SESSION'));
    $view=new Template();
    echo $view->render('view/summary.html');
});

// Order Form Part One
$F3->route('GET|POST /order1', function($F3) {
    $food = "";
    $meal = "";
    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Get the data from the post array
        //var_dump($_POST);
        if (validFood($_POST['food'])) {
            $food = $_POST['food'];
        }
        else {
            $F3->set('errors["food"]', 'Please enter a food');
        }

        if (isset($_POST['meal']) and validMeal($_POST['meal'])) {
            $meal = $_POST['meal'];
        }
        else {
            $F3->set('errors["meal"]', 'Please select a meal');
        }

        // Add the data to the session array
        $F3->set('SESSION.food', $food);
        $F3->set('SESSION.meal', $meal);

        // If there are no errors,
        // Send the user to the next form
        if(empty($F3->get('errors'))) {
            $F3->reroute('order2');
        }
    }

    // Get the data from the model
    // and add it to the F3 hive
    $meals = getMeals();
    $F3->set('meals', $meals);

    // Render a view page
    $view = new Template();
    echo $view->render('view/order1.html');
});

// Order Form Part II
$F3->route('GET|POST /order2', function($F3) {

    var_dump ( $F3->get('SESSION') );

    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //var_dump($_POST);
        // Get the data from the post array
        if (isset($_POST['conds']))
            $condiments = implode(", ", $_POST['conds']);
        else
            $condiments = "None selected";

        // If the data valid
        if (true) {
            // Add the data to the session array
            $F3->set('SESSION.condiments', $condiments);

            // Send the user to the next form
            $F3->reroute('summary');
        }
        else {
            // Temporary
            echo "<p>Validation errors</p>";
        }
    }

    // Get the data from the model
    $condiments = getCondiments();
    $F3->set('condiments', $condiments);

    // Render a view page
    $view = new Template();
    echo $view->render('view/order2.html');
});



$F3->run();