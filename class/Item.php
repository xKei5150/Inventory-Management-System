<?php
require_once('../database/Database.php');
require_once('../interface/iItem.php');
require_once '../vendor/autoload.php';  // Ensure you've included the autoloader from Composer.

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Item extends Database implements iItem{
	public function __construct()
	{
		parent:: __construct();
	}

	public function insert_item($iN, $sN, $mN, $b, $a, $pD, $eID, $cID, $coID)
	{
		$sql = "INSERT INTO tbl_item(item_name, item_serno, item_modno, item_brand, item_amount, item_purdate, emp_id, cat_id, con_id)
				VALUES(?,?,?,?,?,?,?,?,?);
		";
		$result = $this->insertRow($sql, [$iN, $sN, $mN, $b, $a, $pD, $eID, $cID, 1]);
		return $result;
	}

	public function update_item($iN, $sN, $mN, $b, $a, $pD, $eID, $cID, $coID, $iID)
	{	
		$sql="UPDATE tbl_item
			  SET 
			  item_name = ?, 
			  item_serno = ?, 
			  item_modno = ?, 
			  item_brand = ?, 
			  item_amount = ?, 
			  item_purdate = ?, 	
			  emp_id = ?, 
			  cat_id = ?, 
			  con_id = ?
			  WHERE item_id = ?
		";
		$result = $this->updateRow($sql, [$iN, $sN, $mN, $b, $a, $pD, $eID, $cID, $coID, $iID]);
		return $result;
	}

	public function get_item($id)
	{
		$sql="SELECT *
			  FROM tbl_item i
			  INNER JOIN tbl_employee e
			  ON i.emp_id = e.emp_id
			  INNER JOIN tbl_off o
			  ON e.off_id = o.off_id
			  INNER JOIN tbl_con c 
			  ON c.con_id = i.con_id
			  INNER JOIN tbl_cat ca
			  ON ca.cat_id = i.cat_id
			  WHERE i.item_id = ?
		";
		$result = $this->getRow($sql, [$id]);
		return $result;
	}

	public function get_item_by_serial($serialNumber)
    {
        $sql = "SELECT i.item_name, i.item_brand, i.item_serno, i.item_modno, i.item_amount, i.item_purdate,
                       CONCAT(e.emp_fname, ' ', e.emp_mname, ' ', e.emp_lname) AS item_owner,
                       ca.cat_desc, c.con_desc
                FROM tbl_item i
                INNER JOIN tbl_employee e ON i.emp_id = e.emp_id
                INNER JOIN tbl_cat ca ON ca.cat_id = i.cat_id
                INNER JOIN tbl_con c ON c.con_id = i.con_id
                WHERE i.item_serno = ?
        ";
        $result = $this->getRow($sql, [$serialNumber]);
        return $result;
    }


	public function get_all_items()
	{

		$sql = "SELECT *
				FROM tbl_item i
				INNER JOIN tbl_employee e
				ON i.emp_id = e.emp_id
				INNER JOIN tbl_off o
				ON e.off_id = o.off_id
				INNER JOIN tbl_con c
				ON c.con_id = i.con_id
				INNER JOIN tbl_cat ca
				ON ca.cat_id = i.cat_id
				ORDER by i.item_name
		";
		$result = $this->getRows($sql);

		return $result;
	}

	public function item_categories()
	{
		$sql = "SELECT * FROM tbl_cat";
		return $this->getRows($sql);
	}

	public function item_conditions()
	{
		$sql = "SELECT * FROM tbl_con";
		return $this->getRows($sql);
	}


	public function item_report($choice)
	{
		$sql = "";
		if($choice == 'all'){
			$sql = "SELECT *
					FROM tbl_item i 
					INNER JOIN tbl_employee e 
					ON i.emp_id = e.emp_id
					INNER JOIN tbl_cat c 
					ON i.cat_id = c.cat_id
					INNER JOIN tbl_con co 
					ON i.con_id = co.con_id
					INNER JOIN tbl_off o 
					ON o.off_id = e.off_id";
			return $this->getRows($sql);
		}else if($choice == 'working'){
			$sql = "SELECT *
					FROM tbl_item i 
					INNER JOIN tbl_employee e 
					ON i.emp_id = e.emp_id
					INNER JOIN tbl_cat c 
					ON i.cat_id = c.cat_id
					INNER JOIN tbl_con co 
					ON i.con_id = co.con_id
					INNER JOIN tbl_off o 
					ON o.off_id = e.off_id
					WHERE i.con_id = ?";
			return $this->getRows($sql, [1]);
		}else{
			
			$sql = "SELECT *
					FROM tbl_item i 
					INNER JOIN tbl_employee e 
					ON i.emp_id = e.emp_id
					INNER JOIN tbl_cat c 
					ON i.cat_id = c.cat_id
					INNER JOIN tbl_con co 
					ON i.con_id = co.con_id
					INNER JOIN tbl_off o 
					ON o.off_id = e.off_id
					WHERE i.con_id = ?
					ORDER BY i.item_name ASC";
			return $this->getRows($sql, [2]);
		}

	}

public function storeQRPath($serialNumber, $qrPath){
    $sql = "UPDATE tbl_item
            SET qr_path = ?
            WHERE item_serno = ?";
    return $this->updateRow($sql, [$qrPath, $serialNumber]);

}

public function getQRPath($serialNumber){
    $sql = "SELECT qr_path
            FROM tbl_item
            WHERE item_serno = ?";
    return $this->getRow($sql, [$serialNumber]);
}


public function generateQRCode($serialNumber){
$options = new QROptions([
    'version'    => 7,
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel'   => QRCode::ECC_M,
    'scale'      => 5,
    'color'      => [0, 0, 0],
    'backgroundColor' => [255, 255, 255],
    'margin'     => 5,
]);
$qrcode = new QRCode($options);

    $qrPath = '../qrcodes/' . $serialNumber . '.png';
    $qrcode->render('Your data to encode', $qrPath);

    return $qrPath;  // Return the path where the QR code was saved.
}

public function deleteQRCode($serialNumber) {
    $qrPath = '../qrcodes/' . $serialNumber . '.png';
    if (file_exists($qrPath)) {
        unlink($qrPath);  // Delete the file
    }
}


}

$item = new Item();
