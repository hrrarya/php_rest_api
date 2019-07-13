<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/config.php';
include_once '../../models/Experience.php';


$experience = new Experience();

$result = $experience->read();

$num = $result->rowCount();


if($num>0){

	$expi_arr = array();
	$expi_arr['data'] = array();


	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		extract($row);


		$single_item = array(
			'id' => $id,
			'skill_name' => $skill_name,
			'description' => $description,
			'start_year' => $start_year,
			'end_year' => $end_year
		);

		array_push($expi_arr['data'], $single_item);
	}

	http_response_code(200);
	echo json_encode($expi_arr);
}else{
	http_response_code(400);
	echo json_encode(array(
		'message' => 'No Data Found'
	));
}