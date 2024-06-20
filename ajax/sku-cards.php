<?php

// Коннектим базу данных STAFF
require_once ("connect_mysql_cards.php");
$link = db_connect();



if(!empty($_POST["referal"])){ // Принимаем данные
	$sku = $_POST["referal"];
	$query  = "SELECT * FROM `new_product` WHERE `squ` LIKE '%$sku%' OR `product_name` LIKE '%$sku%' LIMIT 5";
	$result = mysqli_query($link, $query);

	//var_dump(mysqli_num_rows($result));

	if (mysqli_num_rows($result) > 0) {
		$html = '<ul>';
		while ($row = mysqli_fetch_array($result)) {
			$html .=  "<li data-sku='$row[squ]'>$row[squ] ($row[product_name])</li>";
		}
		$html .= '</ul>';
		echo $html;
	} else {
		$html = '<div style="color:red">В базе данных нет такого артикула!</div>';
		echo $html;
	}
}



if(!empty($_POST["sku"])){ // Принимаем данные
	$sku = $_POST["sku"];
	$query  = "SELECT * FROM `new_product` WHERE `squ` = '$sku'";
	$result = mysqli_query($link, $query);

	$product_id = 0;
	while ($row = mysqli_fetch_array($result)) {
		$product_id = $row["id"];
	}

	//var_dump($product_id);

	if ($product_id != 0) {
		$query_attr  = "SELECT * FROM `new_product_attr` WHERE `product_id` = '$product_id'";
		$result_attr = mysqli_query($link, $query_attr);

		//var_dump($result_attr);

		$html = '<div class="row">
							<div class="col-2"></div>
							<div class="col-8">
								<div class="row">';
		while ($row_attr = mysqli_fetch_array($result_attr)) {
			if ($row_attr["attr_id"] == '560') $html .= "<div class='col-4'><div class='title_text'>Название: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '95') $html .= "<div class='col-4'><div class='title_text'>Длина: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '94') $html .= "<div class='col-4'><div class='title_text'>Высота: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '564') $html .= "<div class='col-4'><div class='title_text'>Категория: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '98') $html .= "<div class='col-4'><div class='title_text'>Ширина: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '570') $html .= "<div class='col-4'><div class='title_text'>Вес: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
			if ($row_attr["attr_id"] == '574') $html .= "<div class='col-4'><div class='title_text'>EAN: </div><div class='value_text'>$row_attr[attr_value]</div></div>";
		}
		$html .= '
								</div>
							</div>
							<div class="col-2"></div>
						</div>';
		echo $html;
	}
}



//$link = mysqli_close();
