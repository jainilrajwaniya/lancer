<?php

include("db_connect.php");

$id = isset($_GET['id']) ? $_GET['id'] : "";

$msg = $error = '' ;
$data = '';
if ($id == "") {
    $error = 'Please enter prior entry id';
}

if ($error != '') {
    $response = [
        'status' => 0,
        'message' => $error
    ];
    echo json_encode($response);
    die;
}

if ($error == '') {
    $deleteSql = "DELETE FROM prior_reports WHERE id = $id";

    if($conn->query($deleteSql) === TRUE) {
        $response = [
            'status' => 1,
            'message' => "Prior entry deleted successfully!!!"
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => "Something went wrong!!!"
        ];
    }
}


echo json_encode($response);
die;
