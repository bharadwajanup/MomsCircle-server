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



$sql = "select ch.chore_name, cha.options, cha.message, cht.assigned_to, cht.chore_activity_track_id from chore ch, chore_activity cha, chore_activity_track cht WHERE ch.chore_id = cha.chore_id AND cha.chore_activity_id = cht.chore_activity_id AND cha.user_id = $mom_id AND cht.assigned_to in ($user_id,0) ORDER BY cht.assigned_to ASC";
	
	
echo_results_as_json($sql,$connection);

?>