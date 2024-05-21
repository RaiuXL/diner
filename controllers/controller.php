<?php
/**
 * My controller class for the Diner project
 * 328/diner/controllers/controller.php
 *
 */
class Controller
{
    private $_F3; // Fat-Free Router

    /**
     * @param $_F3
     */
    public function __construct($_F3)
    {
        $this->_F3 = $_F3;
    }

    function home(){
        $view=new Template();
        echo $view->render('view/home.html');
    }

    function summary(){
        $view=new Template();
        echo $view->render('view/summary.html');
    }

    function viewBreakfast()
    {
        $view=new Template();
        echo $view->render('view/breakfast-menu.html');
    }
    function viewLunch()
    {
        $view=new Template();
        echo $view->render('view/lunch-menu.html');
    }
    function viewDinner()
    {
        $view=new Template();
        echo $view->render('view/dinner-menu.html');
    }

    function order1()
    {
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
                $this->_F3->set('errors["food"]', 'Please enter a food');
            }

            // Check if the value for 'meal' is valid, if not then set a message in errors[]
            if (isset($_POST['meal']) and validate::validMeal($_POST['meal'])) {
                $meal = $_POST['meal'];
            }
            else {
                $this->_F3->set('errors["meal"]', 'Please select a meal');
            }

            // Add the data to the session array after it's validated
            $order = new Order($food,$meal);
            $this->_F3->set('SESSION.order', $order);


            // If there are no elements in errors[], proceed to next page
            if(empty($this->_F3->get('errors'))) {
                $this->_F3->reroute('order2');
            }
        }

        // Getting data for Radio Buttons
        $meals = DataLayer::getMeals();
        $this->_F3->set('meals', $meals);

        // Render a view page
        $view = new Template();
        echo $view->render('view/order1.html');
    }

    function order2()
    {
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
                $this->_F3->get('SESSION.order')->setCondiments($condiments);

                // Send the user to the next form
                $this->_F3->reroute('summary');
            }
            else {
                echo "<p>Validation errors</p>";
            }
        }

        // Get the data from the model for Check Box Data
        $condiments = DataLayer::getCondiments();
        $this->_F3->set('condiments', $condiments);

        // Render a view page
        $view = new Template();
        echo $view->render('view/order2.html');
    }


}