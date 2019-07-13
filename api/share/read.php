<?php 


header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");


include_once '../../config/config.php';
include_once '../../models/Share.php';

$share = new Share();

$result = $share->read();

$num = $result->rowCount();

if($num>0){
	$share_arr = array();
	$share_arr['data'] =array();

	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		extract($row);

		$share_item = array(
			'id' => $id,
			'project_id' => $project_id,
			'host_name' => $host_name,
			'link' => $link
		);

		array_push($share_arr['data'], $share_item);
	}
	http_response_code(200);
	echo json_encode($share_arr);
}else{
	http_response_code(400);
	echo json_encode(array(
		'message' => 'No data found'
	));
}