<?php	
//$host 	  = 'healthhublive.cfs0uq2gm8ep.us-east-2.rds.amazonaws.com'; 
//$dbname   = 'healthhub_db';
//$username = 'root';
//$password = 'healthhub_2019';
$host 	  = 'localhost';
$dbname   = 'lancer';
$username = 'root';
$password = '';
$charset  = 'utf8';
$collate  = 'utf8_unicode_ci';
//$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password,
//	array(
//		PDO::ATTR_ERRMODE 				=> PDO::ERRMODE_EXCEPTION,
//		PDO::ATTR_PERSISTENT 			=> false,
//		PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
//		PDO::MYSQL_ATTR_INIT_COMMAND 	=> "SET NAMES $charset COLLATE $collate"
//	)
//);


// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>