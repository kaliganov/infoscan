<?php

$data = $HTTP_RAW_POST_DATA;
/*$data = '
<LoadMeasuremtWithPrinting>
	<Barcode>10034242412341342</Barcode>
	<Length>280</Length>
	<Height>88</Height>
	<Width>389</Width>
	<Weight>967</Weight>
</LoadMeasuremtWithPrinting>';*/
//$data = file_get_contents("php://input");

$filename = 'lastfroze.xml';

//file_put_contents($filename, PHP_EOL . $data, FILE_APPEND);
$put_file = file_put_contents($filename, $data);

//var_dump(file_put_contents($filename, $data, FILE_APPEND));
//exit;


if($put_file) {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: text/xml; charset=UTF-8");

	echo '<xml version="1.0" encoding="UTF-8">
		<Detail>
			<code>
				<text>0</text>
			</code>
		</Detail>
	</xml>';
}


/*$headers = array(
'Accept: application/json',
'Content-Length: 16',
'Content-Type: application/json'
);
$session_id = array('SessionID' => '1234567');

$Curl = curl_init();
curl_setopt_array($Curl, array(
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_URL => 'http://192.168.107.79/api/gateway?SessionID=1234567',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_HEADER => false,
));
$response = curl_exec($Curl);
curl_close($Curl);

echo '<pre>';
var_dump(json_decode($response));
echo '</pre>';*/

// http://192.168.107.79/api/data