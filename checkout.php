<?php
//header("Content-Type: application/json; charset=UTF-8");
require_once('dave.php');

////////////////////////////////////
//  GET Data
$cNo = trim($_GET['cNo']);
$paid = $_GET['paid'];
$it = json_decode($_GET['items']);
//echo JSON.stringify($items);

$t="";
$ti_sql=array();
$total=0;
$str_chk_paid="";
if($paid=='true'){
     $chk_paid='y';
     $str_chk_paid="-[[ PAID ]]-";
} else $chk_paid='';

$sql = "select * from customer where c_no={$cNo}";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$str_name=$row["f_name"]." ".$row["l_name"];
$str_no=$row["c_phone"];

$dtz = new DateTimeZone("America/Los_Angeles");
$dt = new DateTime("now", $dtz);
$str_drop=$dt->format("m/d/Y h:ia");
//$str_drop= date("m/d/Y h:i:sa");

////////////////////////////////////
//  insert trans,trans_item SQL

foreach($it as $v){//price total
    $total += $v->price * $v->cnt;
}

$str_tatal=$total;
$str_cnt=0;
$str_list="";

$sql = "insert into trans (c_no, chk_paid, t_amount, drop_date, pickup_date, r_pickup_date) values ({$cNo}, '{$chk_paid}', {$total}, now(), now() + interval 3 day, now() + interval 3 day)";
$con->query($sql);

$last_id = $con->insert_id;

foreach($it as $v){
    $ti_sql= "insert into trans_item (t_no, svc_id, cnt, svc_memo, unit_price) values ({$last_id}, {$v->id}, {$v->cnt}, '{$v->memo}', {$v->price})";
    
    $str_list.= "{$v->cnt} * ".substr($v->name."                 ",0,18)." $ {$v->price}\n";
    $str_cnt+=$v->cnt;
    if($v->memo!="")
        $str_list.= "    - ".$v->memo."\n";
    $con->query($ti_sql);
}

$str_list=trim($str_list);

////////////////////////////////////
//  print receipt

$cmd="print /D:\"\\\\denmark\\POS\" \"".__DIR__."\\printprint\\order".$last_id.".txt\"";

$rct = <<<RECEIPT


Super Choi's Tailors & Computers

        3400 S. Jones Blvd. #14
            Las Vegas, NV 89146
                  (702)474-9200

          {$str_chk_paid}

INV# : {$last_id}
Name : {$str_name}
Phone : {$str_no}
Drop Off : 	{$str_drop}
Pick Up  : 	Texting

================================
{$str_list}
================================
    Total :           $ {$str_tatal}
    Items :         {$str_cnt} item(s)

No Responsibility after 14 days




RECEIPT;

///print
$file4print = __DIR__."\printprint\order{$last_id}.txt";

$myfile = fopen($file4print, "w") or die("Unable to open file!");

fwrite($myfile, $rct);
fclose($myfile);

$output = exec($cmd);
//$output = exec($cmd);



/*$myfile = fopen(__DIR__."\printprint\order{$last_id}.txt", "w") or die("Unable to open file!");

foreach($it as $v){
    $ti_sql= "insert into trans_item (t_no, svc_id, cnt, svc_memo, unit_price) values ({$last_id}, {$v->id}, {$v->cnt}, '{$v->memo}', {$v->price})\n";
    fwrite($myfile, $ti_sql);
}

fwrite($myfile, $sql);
fclose($myfile);
*/
////////////////////////////////////
//  answer


//$last_id = $con->insert_id;
$json='{"last_id":"'.$last_id.'"}';
echo $json;
?>