<?php
include('connection.php');
include('functions.php');

if(!isset($_GET['user_id']))
{
 echo "Error in user_id";
 return;
}

$user_id = $_GET['user_id'];
$query = "select * from user where user_id in (select support_id from user_support where user_id= $user_id)";
echo_results_as_json($query,$connection);

?>