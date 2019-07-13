<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With');

include_once '../../config/config.php';
include_once '../../models/Product.php';


$product = new Product();

$data = json_decode(file_get_contents('php://input'));

$product->id = $data->id;


$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->category_id = $data->category_id;


if ($product->update()) {
    http_response_code(200);
    echo json_encode(array(
        'message' => 'product updated'
    ));
} else {
    http_response_code(400);
    echo json_encode(array(
        'message' => 'product not updated'
    ));
}
