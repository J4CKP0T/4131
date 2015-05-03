<?php

//Autoload other classes when invoked
spl_autoload_register(function ($class) {
    include $class . '.php';
});

class RestaurantController{
    private $model;
    
    public function __construct(RestaurantModel $model){
        $this->model = $model;
    }
    
    public function editRestaurantEntry() {
        // Should re-render view
        return;
    }
    
    public function deleteRestaurantEntry() {
        return;
    }
    
    public function updateRestaurantEntry() {
        return;
    }
    
    public function cancelRestaurantUpdate() {
        return;
    }
    
    public function addRestaurantEntry($id, $name, $type, $address, $phone, $ratings, $URL, $hours) {
        return;
    }
    
}

// Render stuff
$model = new RestaurantModel();
$controller = new RestaurantController($model);
$viewTest = new RestaurantView($controller, $model);
$viewTest->outputTableDiv();
$viewTest->outputAddRestaurantDiv()
?>