<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate Homepage object
include_once '../objects/homepage.php';


$database = new Database();
$db = $database->getConnection();
 
$Homepage = new Homepage($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set Homepage property values
$Homepage->name = $data->name;
$Homepage->price = $data->price;
$Homepage->description = $data->description;
$Homepage->category_id = $data->category_id;
$Homepage->created = date('Y-m-d H:i:s');
 
// create the Homepage
if($Homepage->create_booking()){
    $response = [
        'success' => true,
        'message' => 'Booking successfully',
   
    ];
}
 
// if unable to create the Homepage, tell the user
else{
    $response = [
        'success' => true,
        'message' => 'Failed to Book',
     
    ];
}
} else {
    // Invalid request method
    $response = [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}
$data=json_encode($response);
echo $data;
return $data;
?>