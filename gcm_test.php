

<?php
// API access key from Google API's Console
//define( 'API_ACCESS_KEY', 'AIzaSyC7enqxiX-zG5RHH2z9m59nz-zCRGVqMLk' );
include ('functions.php');
$registrationIds = array( "etTOytTrHFI:APA91bFbeVnRNAc5Om0phyqIMWcF7OeRFTXkYHfoY77phHn-bipKMRZrYtt_b0B978SGNTBZ_kDk9CX3Z0E1xHLyhgvVYQ4mSffQDXRjDQkTPHrPVK6V8nnQ4FAsHxEsM4XgzBLq30VB");




$message = "Sample message";

send_notification($registrationIds,$message);
return;
// prep the bundle
$msg = array
(
	'message' 	=> 'This is a sample message',
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;