<?php
include('connection.php');
include('functions.php');
if(!isset($_GET['user_id']) || !isset($_GET['chore_activity_track_id']))
{
 echo "Insufficient query paramters";
 return;
}

$user_id = $_GET['user_id'];
$chore_activity_track_id = $_GET['chore_activity_track_id'];

$query = "select assigned_to from chore_activity_track where chore_activity_track_id = $chore_activity_track_id";

$stmt = $connection->prepare($query);
$res = $stmt->execute();
$count = $stmt->rowCount();

if($count == 0)
{
 echo "Error in input\n";
 return;
}

$result = $stmt->fetch();

if($result[0]!=0)
{
	echo "Task already assigned";
	return;
}
try
{
//$query = "update chore_activity_track set assigned_to = $user_id where $chore_activity_track_id=$chore_activity_track_id";

$query = "update chore_activity_track set assigned_to=$user_id where chore_activity_track_id= $chore_activity_track_id";

$connection->query($query);

$sql = "select user_id from user_support where support_id=$user_id";

$stmt = $connection->prepare($sql);

$res = $stmt->execute();

$count = $stmt->rowCount();

if($count == 0)
{
 echo "Error in server";
 return;
}

$result = $stmt->fetch();

$mom_id = $result[0];

$sql = "select user_name from user where user_id=$user_id";

$stmt = $connection->prepare($sql);

$res = $stmt->execute();

$count = $stmt->rowCount();

if($count == 0)
{
 echo "Error in server";
 return;
}

$result = $stmt->fetch();

$user_name = $result[0];



$sql = "select ch.chore_name, cha.options, cha.message, cht.assigned_to, cht.chore_activity_track_id from chore ch, chore_activity cha, chore_activity_track cht WHERE ch.chore_id = cha.chore_id AND cha.chore_activity_id = cht.chore_activity_id AND cha.user_id = $mom_id AND cht.assigned_to in ($user_id,0) ORDER BY cht.assigned_to ASC";
	
	
echo_results_as_json($sql,$connection);

//Send a notification to the mom...

$query = "select gcm_token from situation_aware_db.user where user_id = $mom_id";

$tokens = array();
	
	foreach($connection->query($query) as $v)
	{
		$tokens[] = $v[0];
	}
	send_notification($tokens,"$user_name accepted a task.","M");
	
	
	$query = "select gcm_token from situation_aware_db.user where user_id in (select support_id from user_support where user_id = $mom_id and support_id != $user_id) and gcm_token is NOT NULL";
	
	$tokens = array();
	
	foreach($connection->query($query) as $v)
	{
		$tokens[] = $v[0];
	}
	send_notification($tokens,"$user_name accepted a task.","H");
	
	
	

//Send updated date to all the other helpers...

/*$query = "select gcm_token,user_id from situation_aware_db.user where user_id in (select support_id from user_support where user_id = $mom_id and support_id != $user_id) and gcm_token is NOT NULL";


	
	foreach($connection->query($query) as $v)
	{
		$tokens_helpers = array($v[0]);
		$user_to_update = $v[1];
		$sql = "select ch.chore_name, cha.options, cha.message, cht.assigned_to, cht.chore_activity_track_id from chore ch, chore_activity cha, chore_activity_track cht 				WHERE ch.chore_id = cha.chore_id AND cha.chore_activity_id = cht.chore_activity_id AND cha.user_id = $mom_id AND cht.assigned_to in ($user_to_update,0) ORDER BY cht.assigned_to ASC";
	
	
		send_notification($tokens_helpers, echo_results_as_json($sql,$connection),"U");

		
	}*/

}catch(Exception $e)
{
	echo "Update Failed!";
}



?>