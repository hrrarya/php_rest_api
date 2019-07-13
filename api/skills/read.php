<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/config.php';
include_once '../../models/Skills.php';

$skills = new Skills();

$result = $skills->read();

$num = $result->rowCount();

if ($num > 0) {
    $skills_arr = array();
    $skills_arr['data'] = array();

    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);

   $skills_item = array(
			'id' => $id,
			'skill_name' => $skill_name,
			'skill' => $skill
		);
    array_push($skills_arr['data'], $skills_item);

    // set http response code
    http_response_code(200);
    echo json_encode($skills_arr);
} else {
    http_response_code(404);
    echo json_encode(array(
        'message' => 'No product found'
    ));
}
