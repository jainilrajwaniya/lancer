<?php

session_start();
ob_start();
ini_set('memory_limit', '-1');
ini_set('max_input_time', 10000000);
ini_set('max_execution_time', 10000000);
set_time_limit(3600);
ini_set("post_max_size", "128M");
ini_set("upload_max_filesize", "128M");
date_default_timezone_set("Etc/GMT-3");
$images_ext = array('png', 'jpg', 'gif');
error_reporting(1);

//get States
$stateArr1 = ['Alabama' => 'AL',
    'Alaska' => 'AK',
    'Arizona' => 'AZ',
    'Arkansas' => 'AR',
    'California' => 'CA',
    'Colorado' => 'CO',
    'Connecticut' => 'CT',
    'DC' => 'DC',
    'Delaware' => 'DE',
    'Florida' => 'FL',
    'Georgia' => 'GA',
    'Hawaii' => 'HI',
    'Idaho' => 'ID',
    'Illinois' => 'IL',
    'Indiana' => 'IN',
    'Iowa' => 'IA'];

$stateArr2 = [    'Kansas' => 'KS',
    'Kentucky' => 'KY',
    'Louisiana' => 'LA',
    'Maine' => 'ME',
    'Maryland' => 'MD',
'Massachusetts' => 'MA',
    'Michigan' => 'MI',
    'Minnesota' => 'MN',
    'Mississippi' => 'MS',
    'Missouri' => 'MO',
    'Montana' => 'MT',
    'Nebraska' => 'NE',
    'Nevada' => 'NV',
    'New Hampshire' => 'NH',
    'New Jersey' => 'NJ'];

$stateArr3 = ['New Mexico' => 'NM',
    'New York' => 'NY',
    'North Carolina' => 'NC',
    'North Dakota' => 'ND',
    'Ohio' => 'OH',
    'Oklahoma' => 'OK',
    'Oregon' => 'OR',
    'Pennsylvania' => 'PA',
    'Rhode Island' => 'RI',
    'South Carolina' => 'SC',
    'South Dakota' => 'SD',
    'Tennessee' => 'TN',
    'Texas' => 'TX',
    'Utah' => 'UT',
    'Vermont' => 'VT',
    'Virginia' => 'VA',
    'Washington' => 'WA',
    'West Virginia' => 'WV',
    'Wisconsin' => 'WI',
    'Wyoming' => 'WY'];

//used to display in form
$us_miles = [['AL','LA','OK'],
['AK','ME','OR'],
['AZ','MD','PA'],
['AR','MA','RI'],
['CA','MI','SC'],
['CO','MN','SD'],
['CT','MS','TN'],
['DC','MO','TX'],
['DE','MT','UT'],
['FL','NE','VT'],
['GA','NV','VA'],
['HI','NH','WA'],
['ID','NJ','WV'],
['IL','NM','WI'],
['IN','NY','WY'],
['IA','NC'],
['KS','ND'],
['KY','OH']];
//used to display in form
$otherTerrMiles = [['AB','BC','MB'],
    ['NB','NL','NT'],
    ['NS','NU','ON'],
    ['PE','QC','SK'],
    ['YT','Other']];
      


$otherTerArr1 =
    [
    'AB' => 'AB',
    'BC' => 'BC',
    'MB' => 'MB',
    'NB' => 'NB',
    'NL' => 'NL',
    'NT' => 'NT'];

$otherTerArr2 = ['NS' => 'NS',
    'NU' => 'NU',
    'ON' => 'ON',
    'PE' => 'PE',
    'QC' => 'QC',
    'SK' => 'SK',
    'YT' => 'YT',
    'Other' => 'Other'
];

$stateArr = array_merge($stateArr1, $stateArr2, $stateArr3, $otherTerArr1, $otherTerArr2);

//get year, from 2000 to current
$yearArr = [];
$currentYear = date('Y');
for($i = 2000 ; $i <= $currentYear ; $i++) {
    $yearArr[] = $i;
}


//env variables
$baseUrl = "http://localhost/lancer"; // for local
?>