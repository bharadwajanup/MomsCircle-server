<?php
include('connection.php');
include ('functions.php');



if(!isset($_GET['chore_id']) || !isset($_GET['options']) || !isset($_GET['user_id']) || !isset($_GET['message']))
{
	echo "There has been an error in the request\n";
	return;
}
$user_id = $_GET['user_id'];
$options = $_GET['options'];
$chore_id = $_GET['chore_id'];

$message = $_GET['message'];




//$query = "INSERT INTO chore_activity (user_id, options, message) VALUES ('$user_id' , '$options' , '$message')";
$query = "INSERT INTO chore_activity (user_id, chore_id, options, message) VALUES ($user_id, $chore_id, '$options', :col1)";

//echo "\n\n query is $query \n\n";

try
{
	//$dbh->setAttribute($PDO::FETCH_COLUMN, 'chore_activity_id');
	$stmt = $connection->prepare($query);
	$stmt->bindValue(':col1', $message, PDO::PARAM_STR);
	$result = $stmt->execute();
	
	$chore_activity_id = $connection->lastInsertId();
	
	//echo "Chore_activity  $chore_activity_id inserted\n";
	
//	$assigned_to = 0;
	
	$query = "INSERT into chore_activity_track(user_id, chore_activity_id) VALUES ($user_id, $chore_activity_id)";
	
	$result = $connection->query($query);
	
	$chore_activity_track_id = $connection->lastInsertId();
	
		//echo "Chore_activity_track  $chore_activity_track_id inserted\n";
	
	//get registration_ids of the helper mobile nodes
	
	$query = "select gcm_token from situation_aware_db.user where user_id in (select support_id from user_support where user_id = $user_id) and gcm_token is NOT NULL";
	
	$tokens = array();
	
	foreach($connection->query($query) as $v)
	{
		$tokens[] = $v[0];
	}
	send_notification($tokens,"A new task has been added.","H");
	
	echo "The task has been succesfully added";
	
	
	
}catch(PDOException $e)	
{
	echo "Server Error!!!\n";
	echo $e;
}

?>