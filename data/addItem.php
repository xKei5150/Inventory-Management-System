<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once('../class/Item.php');
require '../vendor/autoload.php';  // If you're using Composer

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
if(isset($_POST['data'])){
	$data = json_decode($_POST['data'], true);

	$iN = ucwords($data[0]);
	$sN = $data[1];
	$mN = $data[2];
	$b = ucwords($data[3]);
	$a = $data[4];
	$pD = $data[5];
	$eID = $data[6];
	$cID = $data[7];
	$coID = $data[8];


	// $result = $item->insert_item($iN, $sN, $mN, $b, $a, $pD, $eID, $cID, $coID);
	$result['valid'] = $item->insert_item($iN, $sN, $mN, $b, $a, $pD, $eID, $cID, $coID);
    if($result['valid']){
        // Generate the QR code for the serial number
$options = new QROptions([
    'version'    => 7, // increased version to accommodate more data
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel'   => QRCode::ECC_M, // increased ECC level for better error resilience
    'scale'      => 5, // optional: this will make the QR code larger
    'color'      => [0, 0, 0], // optional: set QR color to black
    'backgroundColor' => [255, 255, 255], // optional: set background color to white
    'margin'     => 5, // optional: set a margin around the QR code
]);
$qrcode = new QRCode($options);


        $qrPath = "../qrcodes/{$sN}.png";
        $qrcode->render($sN, $qrPath);


        $item->storeQRPath($sN, $qrPath);

        $result['msg'] = "Item Added Successfully!";
        $result['action'] = "Add Data";
        echo json_encode($result);
    }
}

$item->Disconnect();
 ?>

