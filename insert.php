<?php 
include('../includes/connection.php');
$table = $_GET['table'];
$q = "select * from $table";
$result = $connection->query($q);
$i=0;
$insert_statement_part1 = "insert into $table(";
$insert_statement_part2=") values (";
while($meta = $result->getColumnMeta($i))
{
	if($meta['name'] == 'timestamp' || $meta['name'] == 'ID' ||$meta['name'] == 'serialized_link')
	{
		
	}
	else if($meta['name'] == 'Number_of_days')
	{
		$insert_statement_part1.="`".$meta['name']."`,";
		$insert_statement_part2.="'".$_POST[$meta['name']]."',";
		$days = $_POST[$meta['name']];
		$itinerary_info = array();
		$j=1;
	while($j <= $days)
	{
		$temp = $_POST['day'.$j];
		array_push($itinerary_info,$temp);
		$j+=1;
	}
	$s = serialize($itinerary_info);
	$path = $_POST['description'];
	file_put_contents($path, $s);
	$insert_statement_part1.="`serialized_link`,";
	$insert_statement_part2.="'$path',";
	}
	else
	{
	$insert_statement_part1.="`".$meta['name']."`,";
	$insert_statement_part2.="'".$_POST[$meta['name']]."',";
	}
	$i+=1;
}
$insert_statement_part1 = rtrim($insert_statement_part1, ",");
$insert_statement_part2 = rtrim($insert_statement_part2, ",");
$insert_statement_part2.=")";
$insert = $insert_statement_part1.$insert_statement_part2;

echo $insert;
try
{
$result = $connection->query($insert);
$x = file_get_contents($path);
$y = unserialize($x);
echo $y[1];
//header("location:addnew.php?msg=success&table=$table");
}catch(PDOException $e)
{
	echo $e;
	//header("location:addnew.php?msg=fail&table=$table");
}

?>