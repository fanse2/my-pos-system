<?php
header("Content-Type: application/json; charset=UTF-8");

require_once('dave.php');

$cNo = trim($_GET['cNo']);

$sql = "SELECT t_no, drop_date, t_amount, chk_paid, pickedup FROM `trans` where c_no= {$cNo} ORDER BY `t_no` DESC limit 5";
$result = $con->query($sql);

$arrUser=array();

// output data of each row
//
$i=1;
while($row = $result->fetch_assoc()) {
    
    array_push($arrUser,sprintf('{"cNo": %d, "drop_date": "%s", "t_amount":%6.2f, "chk_paid" : "%s", "pickedup" : "%s"}',$row['t_no'], $row["drop_date"], $row["t_amount"], $row["chk_paid"], $row["pickedup"]));
    
}

$json='['.implode(",",$arrUser).']';

echo $json;

$con->close();

?>