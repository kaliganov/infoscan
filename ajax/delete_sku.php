<?php

// Коннектим базу данных STAFF
require_once ("connect_mysql_cards.php");
$link = db_connect();

$session_id = '';
$sku = '';

if(!empty($_POST["session_id"])){ // Принимаем данные
	$session_id = $_POST["session_id"];
	$sku = $_POST["sku"];

	$query_delete = "DELETE FROM `infoscan_measurements` WHERE `session_id` = '$session_id' AND `sku` = '$sku'";
	$result_delete = mysqli_query($link, $query_delete);

	var_dump($result_update);
} else {
	$flag = 0;
	echo $flag;
}

