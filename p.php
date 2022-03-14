<?php
//require __DIR__ . '/../../vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


//$connector = new FilePrintConnector("/dev/usb/lp0");
$tm_ip_addr="denmark";
$device_name="POS-58";
$connector = new WindowsPrintConnector('smb://'. $tm_ip_addr .'/'.$device_name);

$printer = new Printer($connector);

/* Text */
$printer -> text("Hello world\n");
$printer -> cut();
$printer -> close();




/*
$print_data="teeeest";
$fp=pfsockopen("localhost",9100);
fputs($fp,$print_data);
fclose($fp);


/*
// start printer
$handle = printer_open("POS-58");
printer_start_doc($handle, "My Document");
printer_start_page($handle);


printer_draw_text($handle, 'the text that will be printed', 100, 100);


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);
*/
?>