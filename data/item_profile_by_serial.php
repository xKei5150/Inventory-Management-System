<?php

require_once '../class/Item.php'; // Adjust the path if needed

$response = array();

if (isset($_POST['serialNumber'])) {
    $serialNumber = $_POST['serialNumber'];

    $item = new Item();
    $result = $item->get_item_by_serial($serialNumber);

    if ($result) {
        $response = $result;
    } else {
        $response['error'] = "No item found with the provided serial number.";
    }
} else {
    $response['error'] = "Serial number not provided.";
}

echo json_encode($response);

?>
