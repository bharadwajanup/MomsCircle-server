<?php include('header.php');
if($_GET['table'] == 'itinerary')
{
	if(isset($_GET['msg']))
	{
	header("location:addnewItinerary.php?table=itinerary&msg=".$_GET['msg']);
	}
	else
	{
		header("location:addnewItinerary.php?table=itinerary");
	}
}
if(isset($_GET['msg']))
{
	if($_GET['msg'] == 'success')
	{
		echo "<div class=\"alert alert-success alert-dismissable\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
  <strong>Success!</strong> New Entry was successfully inserted!
</div>";
	}
	else
	{
		echo "<div class=\"alert alert-danger alert-dismissable\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
  <strong>Oops!Insert Fail!</strong> Please check whether your data is proper or not.
</div>";
	}
} 
$table = $_GET['table'];
$query = "select * from $table";
$select = $connection->query($query);
$i=0;
?>
<div class="container">
<div class="page-header">
  <h1>Add New Entry to <?php echo $table;?></h1>
</div>
<div class="col-md-10">
<form role="form" action="insert.php?table=<?php echo $table?>" method="post">
<?php
while(($meta = $select->getColumnMeta($i)))
{
	$temp = $select->getColumnMeta($i);
	if($temp['name'] == 'timestamp' || $temp['name'] == 'ID' )
	{
		
	}
	else if($temp['name'] == 'name')
	{
		echo "<div class=\"form-group\">
    <label>".$temp['name']."</label>
    <input type=\"text\" class=\"form-control\" name=\"".$temp['name']."\" id=\"".$temp['name']."\" list=\"".$temp['name']."list\">
  </div>";
  echo "<datalist id=\"".$temp['name']."list\">";
  $query="select name from navigation";
  foreach($connection->query($query) as $v)
  {
	  echo "<option value=\"$v[0]\">";
  }
  echo "</datalist>";
		
	}
	else
	{
	echo "<div class=\"form-group\">
    <label>".$temp['name']."</label>
    <input type=\"text\" class=\"form-control\" name=\"".$temp['name']."\" id=\"".$temp['name']."\">
  </div>";
	}
  $i+=1;
}

?>
<button type="submit" class="btn btn-primary btn-lg">Submit</button>
</form> 
</div>
</div>
<?php include('../footer.php');?>