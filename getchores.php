<?php
include('connection.php');
include('functions.php');

$results = array();
$results_json;
if(!isset($_GET['user_id']))
{
 echo "Error in user_id";
 return;
}

$user_id = $_GET['user_id'];
$query = "select chore_id, chore_name, chore_image_name from chore where user_id in (0, $user_id)";


echo_results_as_json($query, $connection);
?>