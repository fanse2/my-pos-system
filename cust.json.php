<?php
header("Content-Type: application/json; charset=UTF-8");

require_once('dave.php');

$q = trim($_GET['q']);

$arrUser=array();

if(!is_numeric($q))
    $sql = "SELECT * FROM `customer` WHERE f_name LIKE '%".$q."%' or l_name LIKE '%".$q."%'";
else
    $sql = "SELECT * FROM `customer` WHERE c_phone like '%".$q."%'";

$result = $con->query($sql);

while($row=$result->fetch_assoc()){

    array_push($arrUser,sprintf('{"no": %d, "name": "%s", "phone": "%s"}',$row['c_no'], $row["f_name"]." ".$row["l_name"], $row["c_phone"]));

}

$json='['.implode(",",$arrUser).']';

echo $json;

$con->close();

?>