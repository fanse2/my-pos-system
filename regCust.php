<?php
header("Content-Type: application/json; charset=UTF-8");

require_once('dave.php');

$fName = trim($_GET['fName']);
$lName = trim($_GET['lName']);
$pNo = trim($_GET['pNo']);



$sql = "insert into customer (f_name,l_name,c_phone) values ('{$fName}','{$lName}','{$pNo}')";

//echo $sql;
$con->query($sql);

$last_id = $con->insert_id;
$json='{"lastId":'.$last_id.'}';
echo $json;
?>