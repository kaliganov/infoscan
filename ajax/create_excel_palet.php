<?php

// Коннектим базу данных STAFF
require_once ("connect_mysql_cards.php");
$link = db_connect();

require_once dirname(__DIR__) . '/ajax/PHPExcel-1.8/Classes/PHPExcel.php';
require_once dirname(__DIR__) . '/ajax/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

//var_dump($_POST);
//exit;

$session_id = $_POST['session_id'];
$sku_array = $_POST['array_td'];
$total_array = array();

foreach ($sku_array as $value) {

	$query = "SELECT * FROM `infoscan_measurements` WHERE `session_id` = '" . $session_id . "' AND `sku` = '" . $value . "'";
	$result = mysqli_query($link, $query);

	while ($row = mysqli_fetch_array($result)) {
		$total_array[] = array(
			"ean" => $row["ean"],
			"sku" => $row["sku"],
			"height" => $row["height"],
			"length" => $row["length"],
			"width" => $row["width"],
			"weight" => $row["weight"],
			"palet" => $row["palet"],
			"master_box" => $row["master_box"],
			"master_box_height" => $row["master_box_height"],
			"master_box_length" => $row["master_box_length"],
			"master_box_width" => $row["master_box_width"],
			"master_box_weight" => $row["master_box_weight"],
			"sku_name" => $row["sku_name"],
			"master_box_name" => $row["master_box_name"],
			"palet_name" => $row["palet_name"]
		);
	}

} /* END foreach */

// Создание объекта Excel
$xls = new PHPExcel();
$xls->getProperties()->setTitle("Infoscan");
$xls->getProperties()->setCompany("TFN");
$xls->getProperties()->setCreated(date("d-m-Y"));
$xls->setActiveSheetIndex(0);

// Получаем указатель на текущий лист Excel устанавливаем его название и пишем заголовки столбцов
$sheet = $xls->getActiveSheet();
$sheet->setTitle("Каталог товаров");

$xlsrow = 1;
$sheet->setCellValue("A".$xlsrow, "MARM-MATNR");
$sheet->setCellValue("B".$xlsrow, "MARM-MEINH");
$sheet->setCellValue("C".$xlsrow, "MARM-UMREZ");
$sheet->setCellValue("D".$xlsrow, "MARM-LAENG");
$sheet->setCellValue("E".$xlsrow, "MARM-BREIT");
$sheet->setCellValue("F".$xlsrow, "MARM-HOEHE");


$iNum = 1;
foreach($total_array as $row) {

	$xlsrow++;
	$sku = $row['sku'];
	$palet_name = $row['palet_name'];
	if ($row['palet'] == 0) {
		$palet = 0;
	} else {
		$palet = $row['palet'];
	}
	
	// Заполняем строку данными
	$sheet->setCellValueExplicit("A".$xlsrow, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("B".$xlsrow, $palet_name, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("C".$xlsrow, $palet, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("D".$xlsrow, '0', PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("E".$xlsrow, '0', PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("F".$xlsrow, '0', PHPExcel_Cell_DataType::TYPE_STRING);

	$iNum++;

}/* END foreach */

$objWriter = new PHPExcel_Writer_Excel2007($xls);
$objWriter->save('php://output');
exit;

?>