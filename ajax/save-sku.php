<?php

// Коннектим базу данных STAFF
require_once ("connect_mysql_cards.php");
$link = db_connect();

//var_dump($link);
//exit;

$session_id = '';
$sku = '';
$palet = 0;
$master_box = 0;
$master_box_height = 0;
$master_box_length = 0;
$master_box_width = 0;
$master_box_weight = 0;

if(!empty($_POST["session_id"]) AND !empty($_POST["sku"])){ // Принимаем данные

	$session_id = $_POST["session_id"];
	$sku = $_POST["sku"];
	$palet = (int) $_POST["palet"];
	$master_box = (int) $_POST["master_box"];
	$master_box_height = (int) $_POST["master_box_height"];
	$master_box_length = (int) $_POST["master_box_length"];
	$master_box_width = (int) $_POST["master_box_width"];
	$master_box_weight = (int) $_POST["master_box_weight"];

//var_dump($session_id, $sku, $palet, $master_box, $master_box_height, $master_box_lenght, $master_box_width, $master_box_weight);
//exit;

	$query_update = "
UPDATE `infoscan_measurements` 
SET `palet` = '" . $palet . "', 
`master_box` = '" . $master_box . "', 
`master_box_height` = '" . $master_box_height . "', 
`master_box_length` = '" . $master_box_length . "', 
`master_box_width` = '" . $master_box_width . "', 
`master_box_weight` = '" . $master_box_weight . "' 
WHERE `session_id` = '" . $session_id . "' AND `sku` = '" . $sku . "'";
	$result_update = mysqli_query($link, $query_update);

	var_dump($result_update);
} else {
	$flag = 0;
	echo $flag;
}
