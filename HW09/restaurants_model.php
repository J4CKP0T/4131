<?php
class RestaurantModel{
    public $text;
    private $db;
    private $htmlTableEntries;
    
    public function __construct(){
        include 'database.php';
        $this->db = $conn;
        $this->htmlTableEntries = '<tr>
                                        <td>#res_id</td>
                                        <td><a href="#res_url">#res_name</a></td>
                                        <td>#res_type</td>
                                        <td>#res_address</td>
                                        <td>#res_phone</td>
                                        <td>#res_phone</td>
                                        <td>#res_ratings</td>
                                        <td>#res_hours</td>
                                   </tr>';
    }
    
    public function getTableEntries(){
        $result = $this->db->query('SELECT * FROM tbl_restaurants');
        if(empty($result)){
            die("No entries retrieved. Check if databse is empty.");
        }
        $entries = '';
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $entries .= $this->formatEntryToHTML($row);
        }
        return $entries;
    }
    
    public function formatEntryToHTML($row){
        $values = array_keys($row);
        $html = $this->htmlTableEntries;
        foreach($values as $key){
            $columnEntry = "/#" . $key . "/";
            if(strpos($row[$key], ',')){
                $row[$key] = preg_replace("/,/", '<br>', $row[$key]);
            }
            $html = preg_replace($columnEntry, $row[$key], $html);
        }
        return html;
    }
}
?>