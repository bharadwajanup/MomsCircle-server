<?php
include('connection.php');
include('functions.php');

if(!isset($_GET['user_id']))
{
 echo "Error in user_id";
 return;
}
$user_id = $_GET['user_id'];

$sql = "select user_id from user_support where support_id=$user_id";

$stmt = $connection->prepare($sql);

$res = $stmt->execute();

$count = $stmt->rowCount();

if($count == 0)
{
 echo "Error in server\n";
 return;
}

$result = $stmt->fetch();

$mom_id = $result[0];

$sql = "select * from user where user_id=$mom_id";

echo_results_as_json($sql,$connection);
?>