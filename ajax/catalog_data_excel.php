<?php

require_once ("../functions/db-connect.php");
require_once ("../functions/functions.php");

require_once dirname(__DIR__) . '/functions/PHPExcel-1.8/Classes/PHPExcel.php';
require_once dirname(__DIR__) . '/functions/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

if($_POST) {
	if(is_array($_POST['warehouses'])) {
		$warehouseID = FormInput(implode(',', $_POST['warehouses']));
	}
}

$items_id = '';
foreach ($_POST['array_td'] as $value) {
	$items_id .= '<itemId>'.$value.'</itemId>';
}

//$_SESSION['token'] = '$haqVOlE{b@Z$*@%w3n%u$y'; // Буммаркет
//$_SESSION['token'] = 'KN6aJfWaM67ic|YbmDCtBIT';  //Эдванс
//$warehouseID = '87654321';

$getStockReq = '<?xml version="1.0" encoding="UTF-8"?>
<ns1:mt_getStock_req xmlns:ns1="urn://tfnopt.ru">
<token>'.$_SESSION['token'].'</token>
<warehouseID>'.$warehouseID.'</warehouseID>
<packStatus>1</packStatus>
<items>'.$items_id.'</items>
</ns1:mt_getStock_req>';

$headers = array("Content-Type: application/xml");
$Curl = curl_init();
curl_setopt_array($Curl, array(
	CURLOPT_HTTPHEADER => $headers,
	CURLOPT_SSL_VERIFYPEER => FALSE,
	CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
	CURLOPT_USERPWD => 'ulmart:Falbom39',
	CURLOPT_URL => 'https://b2b.tfnopt.ru/webapi/',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $getStockReq));
$responseXml = curl_exec($Curl);
curl_close($Curl);	
$resp = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);

$arr = json_decode(json_encode($resp), true);

// Создание объекта Excel
$xls = new PHPExcel();
$xls->getProperties()->setTitle("Каталог товаров TFN API");
$xls->getProperties()->setCompany("TFN");
$xls->getProperties()->setCreated(date("d-m-Y"));
$xls->setActiveSheetIndex(0);

// Получаем указатель на текущий лист Excel устанавливаем его название и пишем заголовки столбцов
$sheet = $xls->getActiveSheet();
$sheet->setTitle("Каталог товаров");

$xlsrow = 1;
$sheet->setCellValue("A".$xlsrow, "#");
$sheet->setCellValue("B".$xlsrow, "Артикул поставщика");
$sheet->setCellValue("C".$xlsrow, "Артикул клиента");
$sheet->setCellValue("D".$xlsrow, "Цена товара");
$sheet->setCellValue("E".$xlsrow, "РРЦ товара");
$sheet->setCellValue("F".$xlsrow, "Количество товара");
$sheet->setCellValue("G".$xlsrow, "Состояние упаковки");
$sheet->setCellValue("H".$xlsrow, "Название товара");
$sheet->setCellValue("I".$xlsrow, "Маркетинговое название");
$sheet->setCellValue("J".$xlsrow, "Производитель");
$sheet->setCellValue("K".$xlsrow, "EAN штрих-код");
$sheet->setCellValue("L".$xlsrow, "Номер детали производителя");
$sheet->setCellValue("M".$xlsrow, "Описание кода группы материалов");
$sheet->setCellValue("N".$xlsrow, "Описание кода группы материалов");
$sheet->setCellValue("O".$xlsrow, "Длина упаковки");
$sheet->setCellValue("P".$xlsrow, "Ширина упаковки");
$sheet->setCellValue("Q".$xlsrow, "Высота упаковки");
$sheet->setCellValue("R".$xlsrow, "Единица измерений");
$sheet->setCellValue("S".$xlsrow, "Вес брутто");
$sheet->setCellValue("T".$xlsrow, "Вес нетто");
$sheet->setCellValue("U".$xlsrow, "Единица веса");
$sheet->setCellValue("V".$xlsrow, "Объем");
$sheet->setCellValue("W".$xlsrow, "Единица объема");
$sheet->setCellValue("X".$xlsrow, "НДС");


$iNum = 1;
foreach($arr['items'] as $row) {
	$xlsrow++;

	// Заполняем строку данными
	$sheet->setCellValue("A".$xlsrow, $iNum);
	$sheet->setCellValueExplicit("B".$xlsrow, $row['itemId'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("C".$xlsrow, $row['clientItemId'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("D".$xlsrow, $row['priceRUB'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("E".$xlsrow, $row['rrpRUB'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValue("F".$xlsrow, $row['quantityInStock']);
	$sheet->setCellValueExplicit("G".$xlsrow, $row['packStatus'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("H".$xlsrow, $row['name'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("I".$xlsrow, $row['marketingName'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("J".$xlsrow, $row['groupName'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("K".$xlsrow, $row['barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("L".$xlsrow, $row['supplierCode'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("M".$xlsrow, $row['hierGroup2'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("N".$xlsrow, $row['hierGroup3'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("O".$xlsrow, $row['length'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("P".$xlsrow, $row['width'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("Q".$xlsrow, $row['height'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("R".$xlsrow, $row['lenghtUnit'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("S".$xlsrow, $row['weightB'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("T".$xlsrow, $row['weightN'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("U".$xlsrow, $row['weightUnit'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("V".$xlsrow, $row['volume'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("W".$xlsrow, $row['volumeUnit'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueExplicit("X".$xlsrow, $row['vat'], PHPExcel_Cell_DataType::TYPE_STRING);

	$iNum++;
}

$objWriter = new PHPExcel_Writer_Excel2007($xls);
$objWriter->save('php://output');
exit;

?>