<?php
//header("Content-Type: application/json; charset=UTF-8");
require_once('dave.php');

////////////////////////////////////
//  GET Data
$tNo = trim($_GET['tNo']);






$sql = "delete FROM `trans` where t_no=".$tNo;
$con->query($sql);

$sql = "delete from `trans_item` where t_no=".$tNo;
$con->query($sql);

echo "$sql";
?>
