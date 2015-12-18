<?php
include('connection.php');
include('functions.php');

if(!isset($_GET['user_id']) || !isset($_GET['type']))
{
 echo "Error in TYPE";
 return;
}

$user_id = $_GET['user_id'];
$type = $_GET['type'];
if($type != "A" && $type != "W")
{
	echo "Invalid type $type";//TODO: echo failures as JSON
	return;
}
$query = "";
if($type == "W")
{
	$query = "SELECT chore.chore_name, chore.chore_description , chore_activity.options, chore_activity.message, chore_activity.timestamp from chore, chore_activity where chore.chore_id = chore_activity.chore_id and chore_activity.user_id = 1 and chore_activity.chore_activity_id in (select chore_activity_id from chore_activity_track where user_id = 1 and assigned_to = 0)";
}
else
{
	$query = "SELECT u.user_name as support_name, u.phone as phone, u.email_id as email, u.image_location as image, chore.chore_name, chore.chore_description , chore_activity.options, chore_activity.message, chore_activity.timestamp from chore, chore_activity,chore_activity_track,situation_aware_db.user u where chore.chore_id = chore_activity.chore_id and chore_activity.user_id = 1 and chore_activity.chore_activity_id = chore_activity_track.chore_activity_id and chore_activity_track.assigned_to != 0 and u.user_id = chore_activity_track.assigned_to";
}

echo_results_as_json($query,$connection);

?>