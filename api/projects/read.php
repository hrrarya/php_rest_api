<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include_once '../../config/config.php';
include_once '../../models/Project.php';

$project = new Project();

$result = $project->read();

$num = $result->rowCount();

if ($num > 0) {
    $projects_arr = array();
    $projects_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $project = array(
            'id' => $id,
            'title' => $title,
            'cat' => $cat,
            'img' => $img,
            'content' => $content
        );

        array_push($projects_arr['data'], $project);
    }

    //set http response code 200;
    http_response_code(200);
    echo json_encode($projects_arr);
} else {
    http_response_code(400);
    echo json_encode(array(
        'message' => 'No project found'
    ));
}
