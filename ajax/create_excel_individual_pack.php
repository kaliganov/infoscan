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
$sheet->setCellValue("A".$xlsrow, "MARA-MATNR");
$sheet->setCellValue("B".$xlsrow, "MARA-MEINH");
$sheet->setCellValue("C".$xlsrow, "MARA-BRGEW");
$sheet->setCellValue("D".$xlsrow, "MARA-NTGEW");
$sheet->setCellValue("E".$xlsrow, "MARA-LAENG");
$sheet->setCellValue("F".$xlsrow, "MARA-BREIT");
$sheet->setCellValue("G".$xlsrow, "MARA-HOEHE");
$sheet->setCellValue("H".$xlsrow, "MARA-VOLUM");
$sheet->setCellValue("I".$xlsrow, "EAN");


$iNum = 1;
foreach($total_array as $row) {

	$xlsrow++;
	$sku = $row['sku'];
	$sku_name = $row['sku_name'];
	if ($row['master_box'] == 0) {
		$weight_brutto = 0;
	} else {
		$weight_brutto_original = number_format(($row['master_box_weight'] / $row['master_box']) / 1000, 3); // Получаем килограммы
		$weight_brutto = str_replace(".", ",", $weight_brutto_original);
	}
	$weight = str_replace(".", ",", number_format($row['weight'] / 1000, 3)); // Получаем килограммы
	$length = str_replace(".", ",", number_format($row['length'] / 10, 3)); // Получаем сантиметры
	$width = str_replace(".", ",", number_format($row['width'] / 10, 3)); // Получаем сантиметры
	$height = str_replace(".", ",", number_format($row['height'] / 10, 3)); // Получаем сантиметры
	$voleh_original = number_format($row['length'] * $row['width'] * $row['height'] * 0.000001, 3);
	$voleh = str_replace(".", ",", $voleh_original); // Объем
	$ean = $row['ean'];

	// Заполняем строку данными
	$sheet->setCellValueExplicit("A".$xlsrow, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("B".$xlsrow, $sku_name, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("C".$xlsrow, $weight_brutto, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("D".$xlsrow, $weight, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("E".$xlsrow, $length, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("F".$xlsrow, $width, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("G".$xlsrow, $height, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("H".$xlsrow, $voleh, PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("I".$xlsrow, $ean, PHPExcel_Cell_DataType::TYPE_STRING);

	$iNum++;

} /* END foreach */

$objWriter = new PHPExcel_Writer_Excel2007($xls);
$objWriter->save('php://output');
exit;

?>