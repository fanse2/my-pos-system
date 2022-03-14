<?php
header("Content-Type: application/json; charset=UTF-8");

require_once('dave.php');

$sql = "SELECT svc_id, svc_name, svc_price, icon FROM `service` where cate_id ='RC' and svc_ver=2 order BY list_order";
$result = $con->query($sql);

$arrUser=array();

// output data of each row
//
$i=1;
while($row = $result->fetch_assoc()) {
    
    array_push($arrUser,sprintf('{"id": %d, "name": "%s", "price":%6.2f, "icon" : "%s"}',$row['svc_id'], $row["svc_name"], $row["svc_price"], $row["icon"]));
    
}

$json='['.implode(",",$arrUser).']';

echo $json;

$con->close();

?>