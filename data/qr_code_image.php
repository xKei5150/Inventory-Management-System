<?php
require_once('../class/Item.php');
$item = new Item(); // Instantiate your Item class

// Check if the serial number is set in the GET request
if (isset($_GET['serial'])) {
    $serialNumber = $_GET['serial'];
    // Retrieve the QR code data which might be an array
    $qrCodeData = $item->getQRPath($serialNumber);

    // Check if $qrCodeData is an array and has the 'qr_path' key
    if (is_array($qrCodeData) && isset($qrCodeData['qr_path'])) {
        $qrPath = $qrCodeData['qr_path']; // Now $qrPath should be a string

        // Now you can check if the file exists
        if (file_exists($qrPath)) {
            header('Content-Type: image/png');
            readfile($qrPath);
            exit;
        }
    }

    // If the QR path isn't set or the file doesn't exist, return a 404 error
    header("HTTP/1.0 404 Not Found");
    echo 'QR Code image not found.';
    exit;
}
?>
