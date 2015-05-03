<?php
class RestaurantView{
    private $model;
    private $controller;
    
    public function __construct(RestaurantController $controller, RestaurantModel $model){
        $this->controller = $controller;
        $this->model = $model;
    }
    
    public function outputTableDiv(){
        $html = '<link rel="stylesheet" type="text/css" href="style.css">
                 <div>
                    <table id="restaurants">
                    <caption><strong>My Favourite Restaurants</strong></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Rating</th>
                            <th>Hours</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    #tableEntries
                    </tbody>
                    </table>
                 </div>';
        $tableEntries = $this->model->getTableEntries();
        $html = preg_replace("/#tableEntries/", $tableEntries, $html);
        echo $html;
    }
    
    public function outputAddRestaurantDiv(){
        $html = '<br><div id="divForm">
                 <h1>Add New Restaurant</h1>
                 <form action="RestaurantController.php" method="POST">
                    Name: <input type="text" name="name"><br>
                    Phone: <input type="text" name="phone"><br>
                    Type: <input type="text" name="type"><br>
                    Rating: <input type="text" name="rating"><br>
                    URL: <input type="text" name="url"><br>
                    Hours: <textarea rows="5" cols="50" name="comment"></textarea><br>
                    Address: <textarea rows="4" cols="50" name="comment"></textarea><br><br>
                    <input type="submit" value="Add" class="button">
                 </form>
                 </div>';
        echo $html;
    }
}
?>