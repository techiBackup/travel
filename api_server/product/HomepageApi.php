<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/homepage.php';

// Function to retrieve homepage data
function getHomepageData() {
    // instantiate database object
    $database = new Database();
    $db = $database->getConnection();

    // initialize homepage object
    $homepage = new Homepage($db);

    // query navbar
    $destination = $homepage->read_destination();
    $destination_num = $destination->rowCount();
    $homepage_arr=array();

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

    // query banner
    $banner = $homepage->read_banner();
    $banner_num = $banner->rowCount();

    if($banner_num > 0) {
        // banner array
        $homepage_arr["banner"]=array();

        // retrieve banner contents
        while ($row = $banner->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $banner_item=array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
            );

            array_push($homepage_arr["banner"], $banner_item);
        }
    } else {
        // No banner data found
        $homepage_arr["banner"] = [];
    }

// packages
    $package = $homepage->read_package();
    $package_num = $package->rowCount();

    if($package_num > 0) {
        // banner array
        $homepage_arr["package"]=array();

        // retrieve banner contents
        while ($row = $package->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $banner_item=array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
            );

            array_push($homepage_arr["package"], $banner_item);
        }
    } else {
        // No banner data found
        $homepage_arr["package"] = [];
    }

    // Blog

    $blog = $homepage->read_package();
    $blog_num = $blog->rowCount();

    if($blog_num > 0) {
        // banner array
        $homepage_arr["blog"]=array();

        // retrieve banner contents
        while ($row = $blog->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $blog_item=array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
            );

            array_push($homepage_arr["blog"], $blog_item);
        }
    } else {
        // No banner data found
        $homepage_arr["blog"] = [];
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
