<?php

//echo "<ul><li>RLM-3760.6-128.BK</li></ul>";

// Коннектим базу данных STAFF
require ("connect_mysql_cards.php");
$link = db_connect();

var_dump($link);
exit;

if(!empty($_POST["referal"])){ // Принимаем данные
  $sku = $_POST["referal"];
  $query  = "SELECT * FROM `new_product` WHERE `squ` LIKE '$sku%' LIMIT 5";
  $result = mysqli_query($link, $query);

  $product_id = 0;
  while ($row = mysqli_fetch_array($result)) {
    $product_id = (int) $row["id"];
  }

  if ($product_id != 0) {
    $query_attr  = "SELECT * FROM `new_product_attr` WHERE `product_id` = $product_id";
    $result_attr = mysqli_query($link, $query_attr);

    $html = '<ul>';
    while ($row_attr = mysqli_fetch_array($result_attr)) {
      if ($row_attr["attr_id"] == '560') $html =. "<li>Название: $row_attr[attr_value]</li>";
    }
    $html =. '</ul>';
    echo $html;
  }
}

$link = mysqli_close();
