<?php

include("db_connect.php");

//ins data
$id = isset($_POST['id']) ? $_POST['id'] : "";
$ins_number = isset($_POST['ins_number']) ? $_POST['ins_number'] : "";
$pol_number = isset($_POST['policy_number']) ? $_POST['policy_number'] : "";
$ins_name = isset($_POST['ins_name']) ? $_POST['ins_name'] : "";
$ins_state = isset($_POST['ins_state']) ? $_POST['ins_state'] : "";
$dot_number = isset($_POST['dot_number']) ? $_POST['dot_number'] : "";
$ins_city = isset($_POST['ins_city']) ? $_POST['ins_city'] : "";

//prior data
$prior_record_id = isset($_POST['prior_record_id']) ? $_POST['prior_record_id'] : "";
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
$quarter = isset($_POST['quarter']) ? $_POST['quarter'] : "";
if($report_type == 'Specified') {
   $year = $quarter = null; 
}
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : "";
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : "";
$units = isset($_POST['units']) ? $_POST['units'] : null;
$miles_per_gallon = isset($_POST['miles_per_gallon']) ? $_POST['miles_per_gallon'] : 0;
$total_miles = isset($_POST['total_miles']) ? str_replace(',', '', $_POST['total_miles']) : 0;
$miles_arr = $_POST['miles'];
$miles_state_arr = $_POST['miles_state'];

$msg = $error = '';
//validate ins data

if (isset($_POST['id']) && $_POST['id'] > 0) {
    
} else {
    //if ($ins_number == "" ) {
//    $error = 'Insured # mandatory';
//}
//if ($pol_number == "" && $error == '') {
//    $error = 'Policy # is mandatory';
//}
    
    if ($ins_number == "" && $pol_number != "") {
        $error = 'Insured # mandatory';
    }
    
    if (!(strlen($ins_number) == 7) && $error == '') {
        $error = 'Insurance number length must be 7 digit';
    }
    
    if ($ins_number != "" && $pol_number == "") {
        $error = 'Policy # is mandatory';
    }
    
    if ($ins_name == "" && $error == '') {
        $error = 'Insured name is mandatory';
    }
    if ($ins_city == "" && $error == '') {
        $error = 'Insured city is mandatory';
    }
    if ($ins_state == "" && $error == '') {
        $error = 'Insured state is mandatory';
    }
    if ($error == '' && $dot_number == "") {
        $error = 'Dot # is mandatory';
    }

    

    if (strlen($ins_name) > 80 && $error == '') {
        $error = 'Insurance name length must be less than equal to 80 char';
    }

    if (strlen($dot_number) > 12 && $error == '') {
        $error = 'Dot # length must be less than equal to 12 digit';
    }
}

if ($error == '' && $start_date == "") {
    $error = 'Start date is mandatory';
}
if ($error == '' && $end_date == "") {
    $error = 'End date is mandatory';
}

if($error == '' && $units != null) {
    if($units < 1 || $units > 9999) {
        $error = 'Power units value must be greater than 0 and less than 10000';
    }
}

//validate prior data
//if (!($total_miles > 0) && $error == '') {
//    $error = 'Total miles value must be more than 0';
//}

if($error == '') {
    $state_miles_sum = 0;
    foreach ($miles_arr as $miles) {
        $miles = str_replace(',','',$miles);
        if($miles != "") {
            $state_miles_sum += $miles;
        }
    }
    if ($total_miles != $state_miles_sum) {
        $error = 'Sum of all state miles must be equal to Total miles';
    }
}


if ($error != '') {
    $response = [
        'status' => 0,
        'message' => $error
    ];
    echo json_encode($response);
    die;
}


//converting data format m-d-y to y-m-d
if($start_date != "" && $end_date != "") {
    $start_date_arr = explode('/', $start_date);
    $start_date = $start_date_arr[2].'-'.$start_date_arr[0].'-'.$start_date_arr[1];
    $end_date_arr = explode('/', $end_date);
    $end_date = $end_date_arr[2].'-'.$end_date_arr[0].'-'.$end_date_arr[1];
}

if ($error == '') {
    if ($id > 0) {
        //validate prior entry
        $dateOverlapWhere = "WHERE ins_id = $id AND (('".$start_date."' BETWEEN start_date AND end_date) || ('".$end_date."' BETWEEN start_date AND end_date)) ";
        if($prior_record_id > 0) {
            $dateOverlapWhere .= " AND id != $prior_record_id";
        }

        $selectSql = "SELECT * FROM prior_reports $dateOverlapWhere";
        $result = $conn->query($selectSql);
        if (isset($result->num_rows) && $result->num_rows > 0) {
            $response = [
                'status' => 0,
                'message' => "Dates are overlapping"
            ];
            echo json_encode($response);
            die;
        }
        //validate prior entry ends
        
        $state_miles = [];
        for ($i = 0; $i < count($miles_arr); $i++) {
            if (isset($miles_arr[$i])) {
//                $state_miles[$miles_state_arr[$i]] = $miles_arr[$i];
                $state_miles[$miles_state_arr[$i]] = str_replace(',','',$miles_arr[$i]);
            }
        }
        
        if ($prior_record_id > 0) {
            $priorUpdateSql = "UPDATE prior_reports "
                    . "SET "
                    . "report_type = '" . $report_type . "',"
                    . "year = '" . $year . "',"
                    . "quarter = '" . $quarter . "',"
                    . "start_date = '" . $start_date . "',"
                    . "end_date = '" . $end_date . "',"
                    . "units = $units,"
                    . "miles_per_gallon = $miles_per_gallon,"
                    . "total_miles = $total_miles,"
                    . "state_miles = '" . json_encode($state_miles) . "',"
                    . "created_at = NOW() "
                    . "WHERE id = $prior_record_id";
//            echo $priorUpdateSql;
//            die;
            $conn->query($priorUpdateSql);
            $msg = "Prior record updated successfully!!!";
        } else {
            $priorInsertSql = "INSERT INTO prior_reports "
                    . "SET "
                    . "ins_id = $id,"
                    . "report_type = '" . $report_type . "',"
                    . "year = '" . $year . "',"
                    . "quarter = '" . $quarter . "',"
                    . "start_date = '" . $start_date . "',"
                    . "end_date = '" . $end_date . "',"
                    . "units = $units,"
                    . "miles_per_gallon = $miles_per_gallon,"
                    . "total_miles = $total_miles,"
                    . "state_miles = '" . json_encode($state_miles) . "',"
                    . "created_at = NOW()";
                    
            $conn->query($priorInsertSql);
            $msg = "Prior record inserted successfully!!!";
        }
        $response = [
            'status' => 1,
            'message' => $msg,
            'data' => ['id' => $id]
        ];
    } else {
        //validate duplicate record on ins # or policy #
        $selectSql = "SELECT * FROM insurance WHERE ins_number = $ins_number OR policy_number = $pol_number ";
        $result = $conn->query($selectSql);
        if (isset($result->num_rows) && $result->num_rows > 0) {

            $response = [
                'status' => 0,
                'message' => "Record already there in Database"
            ];
        } else {
            //create new insured number
            $insInsertSql = "INSERT INTO insurance "
                    . "SET "
                    . "ins_number = $ins_number,"
                    . "policy_number = $pol_number,"
                    . "ins_name = '" . htmlspecialchars($ins_name) . "',"
                    . "ins_state = '" . htmlspecialchars($ins_state) . "',"
                    . "ins_city = '" . htmlspecialchars($ins_city) . "',"
                    . "dot_number = $dot_number,"
                    . "created_at = NOW()";

            if ($conn->query($insInsertSql) === TRUE) {
                $msg = 'Data added successfully';
                $ins_id = $conn->insert_id;

                $state_miles = [];
                for ($i = 0; $i < count($miles_arr); $i++) {
                    if (isset($miles_arr[$i])) {
//                        $state_miles[$miles_state_arr[$i]] = $miles_arr[$i];
                        $state_miles[$miles_state_arr[$i]] = str_replace(',','',$miles_arr[$i]);
                    }
                }
                
                $priorInsertSql = "INSERT INTO prior_reports "
                        . "SET "
                        . "ins_id = $ins_id,"
                        . "report_type = '" . $report_type . "',"
                        . "year = '" . $year . "',"
                        . "quarter = '" . $quarter . "',"
                        . "start_date = '" . $start_date . "',"
                        . "end_date = '" . $end_date . "',"
                        . "units = $units,"
                        . "miles_per_gallon = $miles_per_gallon,"
                        . "total_miles = $total_miles,"
                        . "state_miles = '" . json_encode($state_miles) . "',"
                        . "created_at = NOW()";

                $conn->query($priorInsertSql);

                $response = [
                    'status' => 1,
                    'message' => $msg,
                    'data' => ['id' => $ins_id]
                ];
            }
        }
    }
}


echo json_encode($response);
die;

