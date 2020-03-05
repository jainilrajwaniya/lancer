<?php

include("db_connect.php");

$ins_number = isset($_POST['ins_number']) ? $_POST['ins_number'] : "";
$pol_number = isset($_POST['policy_number']) ? $_POST['policy_number'] : "";

$msg = $error = '' ;
$data = '';
if ($ins_number == "" && $pol_number == "") {
    $error = 'Please enter Insured number or Policy number';
}

if ($ins_number != "" && $pol_number != "") {
    $error = 'Please enter either Insured number or Policy number';
}

if ($error != '') {
    $response = [
        'status' => 0,
        'message' => $error
    ];
    echo json_encode($response);
    die;
}


if ($pol_number != "") {
    $where = " policy_number = $pol_number ";
} else {
    $where = " ins_number = $ins_number";
}

if ($error == '') {
    //create new insured number
    $selectSql = "SELECT * FROM insurance WHERE $where LIMIT 1";
    $result = $conn->query($selectSql);
    if (isset($result->num_rows) && $result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $data = $row;
        
        $response = [
            'status' => 1,
            'message' => "Record found!!",
            'data' => $data
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => "No record found!!",
            'data' => $data
        ];
    }
}


echo json_encode($response);
die;
