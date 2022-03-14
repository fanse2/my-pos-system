<?php

$last_id = trim($_GET['last_id']);

$cmd="print /D:\"\\\\denmark\\POS\" \"".__DIR__."\\printprint\\order".$last_id.".txt\"";

$output = exec($cmd);


?>