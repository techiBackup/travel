<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/destination.php';

// Function to retrieve homepage data
function getTopDestination() {
    // instantiate database object
    $database = new Database();
    $db = $database->getConnection();

    // initialize homepage object
    $destination = new Destination($db);
    $id=$_GET['id'];
    // query navbar
    $destination = $destination->read_destination($id);
    $destination_num = $destination->rowCount();
    $description_arr=array();

    if($destination_num > 0) {
        // navbar array
        $homepage_arr["destination"]=array();

        // retrieve navbar contents
        while ($row = $destination->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $destination_item=array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
            );

            array_push($homepage_arr["destination"], $destination_item);
        }
    } else {
        // No navbar data found
        $homepage_arr["destination"] = [];
    }

    // Return the homepage data
    return $homepage_arr;
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = [
        'success' => true,
        'message' => 'Data retrieved successfully',
        'data' => getHomepageData() // Call the function to retrieve homepage data
    ];
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
