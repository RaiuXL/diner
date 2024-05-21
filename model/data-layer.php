<?php


/* This is my Data Layer.
 * It belongs to the Model.
 */
class DataLayer{
    static function getMeals()
    {
        return array('breakfast', 'brunch', 'lunch', 'dinner', 'dessert');
    }

    static function getCondiments()
    {
        return array('ketchup', 'mustard', 'sriracha', 'kim chi', 'sour cream');
    }
}


