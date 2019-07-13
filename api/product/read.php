<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/config.php';
include_once '../../models/Product.php';

$product = new Product();

$result = $product->read();

$num = $result->rowCount();

if ($num > 0) {
    $product_arr = array();
    $product_arr['data'] = array();

    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $product_item = array(
        'id' => $id,
        'name' => $name,
        'tag' => $tag,
        'image'=> $image,
        'description' => $description,
        'phone' => $phone,
        "address" => $address,
        "email" => $email,
        'website' => $website
    );

    array_push($product_arr['data'], $product_item);

    // set http response code
    http_response_code(200);
    echo json_encode($product_arr);
} else {
    http_response_code(404);
    echo json_encode(array(
        'message' => 'No product found'
    ));
}
