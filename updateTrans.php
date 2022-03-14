<?php
//header("Content-Type: application/json; charset=UTF-8");
require_once('dave.php');

////////////////////////////////////
//  GET Data
$tNo = trim($_GET['tNo']);
$act = trim($_GET['act']);

// `pickedup`   `chk_paid`   

switch ($act) {
    case 'uy':
         $subString=" `pickedup` = 'y' ";
        break;
    case 'un':
         $subString=" `pickedup` = '' ";
        break;
    case 'yy':
         $subString=" `chk_paid` = 'y' ";
        break;

    default:
         $subString=" `chk_paid` = '' ";
}

$sql = "update `trans` set {$subString} where t_no=".$tNo;
$con->query($sql);

echo "$sql";
?>