<?php
class Destination{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    //read Navbar
    function read_destination($id){
     
        // select all query
        $query = "SELECT
                   id,name,description,price,category_id
                FROM PRODUCTS where id=$id
                ORDER BY
                    created DESC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

}