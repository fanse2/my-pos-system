<?php
require_once('dave.php');

$q = trim($_GET['q']);
if(!is_numeric($q))
    $sql = "SELECT * FROM `customer` WHERE f_name LIKE '%".$q."%' or l_name LIKE '%".$q."%'";
else
    $sql = "SELECT * FROM `customer` WHERE c_phone like '%".$q."%'";


$result = $con->query($sql);
//c_no f_name l_name c_phone

while($row = $result->fetch_assoc()){
    printf('(%d) %s %s (%s) <br>',$row['c_no'],$row['f_name'],$row['l_name'],$row['c_phone']);
}
?>