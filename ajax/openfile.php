<?php

// Коннектим базу данных STAFF
require_once ("connect_mysql_cards.php");
$link = db_connect();

$file_name = 'lastfroze.xml';

$session_id = '';
$sku = '';
$ean = '';
$height = '';
$length = '';
$width = '';
$weight = '';


function object2array($object) {
	return json_decode(json_encode($object), TRUE); 
}

if(!empty($_POST["session_id"])){ // Принимаем данные

	//$file_exists = file_exists('lastfroze.xml');
	$flag = 1;

	while ($flag) {
		sleep(3);
		$file_exists = file_exists('lastfroze.xml');
		if ($file_exists) {
			$flag = 0;
		}
	}

	$session_id = $_POST["session_id"];
	$sku = $_POST["sku"];

	if ($file_exists) {
		$file_open = fopen('lastfroze.xml', 'r');
		$file_read = fread($file_open, filesize($file_name));

		$document = new SimpleXMLElement($file_read);
		$array = object2array($document);

		$ean = $array['Barcode'];
		$height = $array['Height'];
		$length = $array['Length'];
		$width = $array['Width'];
		$weight = $array['Weight'];

		// Пишем полученые данные в базу данных
		$query_insert  = "INSERT INTO `infoscan_measurements` (`session_id`, `sku`, `ean`, `height`, `length`, `width`, `weight`) VALUES ('" . $session_id . "', '" . $sku . "', '" . $ean . "', '" . $height ."', '" . $length . "', '" . $width . "', '" . $weight . "')";
		$result_insert = mysqli_query($link, $query_insert);


		$query_select = "SELECT * FROM `infoscan_measurements` WHERE `session_id` = '" . $session_id . "'";
		$result_select = mysqli_query($link, $query_select);

		$html = '
		<table id="mytable" class="table measurement_table">
			<thead>
				<tr>
					<th scope="col">EAN</th>
					<th scope="col">EAN mbox</th>
					<th scope="col">Артикул</th>
					<th scope="col">Ширина<br>(мм)</th>
					<th scope="col">Высота<br>(мм)</th>
					<th scope="col">Глубина<br>(мм)</th>
					<th scope="col">Вес<br>(грамм)</th>
					<th scope="col">Палет<br>(шт)</th>
					<th scope="col">Мастербокс<br>(шт)</th>
					<th scope="col">Мастербокс<br>(вес)</th>
					<th scope="col">Мастербокс<br>(ширина)</th>
					<th scope="col">Мастербокс<br>(высота)</th>
					<th scope="col">Мастербокс<br>(глубина)</th>
					<th scope="col">Действие</th>
				</tr>
			</thead>
			<tbody>';
		$count = 1;
		while ($row = mysqli_fetch_array($result_select)) {
			$html .=  "<tr >";
			$html .=  "	<td>" . $row["ean"] . "</td>";
			$html .=  "	<td>" . $row["ean_mbox"] . "</td>";
			$html .=  "	<td class='sku'>" . $row["sku"] . "</td>";
			$html .=  "	<td class='sku_width'>" . $row["width"] . "</td>";
			$html .=  "	<td class='sku_height'>" . $row["height"] . "</td>";
			$html .=  "	<td class='sku_length'>" . $row["length"] . "</td>";
			$html .=  "	<td class='sku_weight'>" . $row["weight"] . "</td>";
			$html .=  "	<td class='palet_input'><input name='palet_" . $count . "' value='" . $row["palet"] . "'></td>";
			$html .=  "	<td class='master_box_input'><input name='master_box_" . $count . "' value='" . $row["master_box"] . "'></td>";
			$html .=  "	<td class='master_box_weight_input'><input name='master_box_weight_" . $count . "' value='" . $row["master_box_weight"] . "'></td>";
			$html .=  "	<td class='master_box_width_input'><input name='master_box_width_" . $count . "' value='" . $row["master_box_width"] . "'></td>";
			$html .=  "	<td class='master_box_height_input'><input name='master_box_height_" . $count . "' value='" . $row["master_box_height"] . "'></td>";
			$html .=  "	<td class='master_box_length_input'><input name='master_box_length_" . $count . "' value='" . $row["master_box_length"] . "'></td>";
			$html .=  "	<td>
										<span id='sku_number_" . $count . "' class='save_sku' title='Сохранить данные'>
											<button id='save_data' data-bs-toggle='modal' data-bs-target='#saveData'>&#9989;</button>
										</span>
										<span class='delete_sku' title='Удалить артикул'>
											&#10060;
										</span>
										<span class='zamer_masterboxa hidden' title='Измерить мастербок'>
											<button id='start_measuring_master_box' data-bs-toggle='modal' data-bs-target='#startMeasuringMasterBox'><img src='../images/scale.png' title='Измерить мастербок'></button>
										</span>
									</td>";
			$html .=  "</tr>";
			$count++;
		}
		$html .= '
			</tbody>
		</table>';

		unlink('lastfroze.xml');

		echo $html;
	} else {
		$flag = 0;
		echo $flag;
	}
}

?>

<img src="" alt="">