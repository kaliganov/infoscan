<?php

function db_connect(){
  define ('MYSQL_SERVER', '0.0.0.0');
  define ('MYSQL_USER', 'infoscan');
  define ('MYSQL_PASSWORD', 'Ej2XFJ63dp75EaJg');
  define ('MYSQL_DB', 'cards');

  define ('PATHSITE', '');   //Относительный путь до катаога со скриптом

  $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die ("Error:".mysqli_error($link));

  if (!mysqli_set_charset($link, "utf8"))
  {
    printf("Error: ".mysqli_error($link));
  }
  return $link;
}

?>