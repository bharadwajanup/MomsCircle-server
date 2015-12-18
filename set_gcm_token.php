<?php
include('connection.php');
include('functions.php');

if(!isset($_GET['user_id']))
{
 echo "Error in user_id";
 return;
}

$user_id = $_GET['user_id'];
$token = $_GET['token'];

$sql = "update situation_aware_db.user set gcm_token = '$token' where user_id=$user_id";

$connection->query($sql);

echo "success";
?>