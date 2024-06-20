<?php

// Коннектим базу данных STAFF
//require_once ("connect_mysql_cards.php");
//$link = db_connect();
echo "<p>work-1</p>";
var_dump($link);
exit;


if(!empty($_POST["sessionId"])){ // Принимаем данные
	$file_exists = file_exists('lastfroze.txt');
	$session_id = $_POST["sessionId"];
	$sku = $_POST["sku"];
	echo "<p>work-1</p>";

	$file_get = file_get_contents('lastfroze.txt');
	$file_decode = json_decode($file_get, true);
	var_dump($file_decode);
	exit;
	$ean = Barcode

	if ($file_exists) {
		$query  = "INSERT INTO `infoscan_measurements` (`session_id`, `sku`, `ean`, `height`, `length`, `width`, `weight`) VALUES ('', '', '', '', '', '', '',)";
		$result = mysqli_query($link, $query);


	}
}


	