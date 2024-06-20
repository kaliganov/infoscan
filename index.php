<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$choice = $_GET['link'];
//var_dump($choice);

require_once 'head.php';
require_once 'header.php';
require_once 'menu.php'; // там начало тега body

if ($choice == NULL) {
	//var_dump($choice);
	require_once 'pages/start.php';
}

/*switch ($choice) {
	case 'measuring':
		require_once 'pages/measuring.php';
		break;
	case 'loading':
		require_once 'pages/loading.php';
		break;
}*/

require_once 'footer.php';