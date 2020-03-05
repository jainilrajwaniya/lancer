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
    $selectSql = "SELECT * FROM prior_reports WHERE id = $id";
    $result = $conn->query($selectSql);
    $priorData = [];
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $temp = [];
            $temp['id'] = $row['id'];
            $temp['ins_id'] = $row['ins_id'];
            $temp['report_type'] = $row['report_type'];
            $temp['year'] = $row['year'];
            $temp['quarter'] = $row['quarter'];
            $temp['start_date'] = $row['start_date'];
            $temp['end_date'] = $row['end_date'];
            $temp['total_miles'] = $row['total_miles'];
            $temp['units'] = $row['units'];
            $temp['miles_per_gallon'] = $row['miles_per_gallon'];
            $temp['state_miles'] = json_decode($row['state_miles'], 1);
            $priorData = $temp;
        }
        $response = [
            'status' => 1,
            'message' => "Prior record entries!",
            'data' => $priorData
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => "No record found!!"
        ];
    }
}


echo json_encode($response);
die;
