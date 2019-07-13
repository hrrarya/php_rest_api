<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/config.php';
include_once '../../models/Education.php';


$education = new Education();

$result = $education->read();

$num = $result->rowCount();


if($num>0){

	$edu_arr = array();
	$edu_arr['data'] = array();


	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		extract($row);


		$single_item = array(
			'id' => $id,
			'instiute_name' => $instiute_name,
			'description' => $description,
			'start_year' => $start_year,
			'end_year' => $end_year
		);

		array_push($edu_arr['data'], $single_item);
	}

	http_response_code(200);
	echo json_encode($edu_arr);
}else{
	http_response_code(400);
	echo json_encode(array(
		'message' => 'No Data Found'
	));
}