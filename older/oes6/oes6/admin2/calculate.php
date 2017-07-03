<?php
include_once '../oesdb.php';
ini_set('max_execution_time', 180);

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OES: Calculate Average Marks Script</title>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
		
	</head>
	
<body>
<div id='over' hidden='hidden' style='position:fixed;top:0px;bottom:0px;left:0px;right:0px; background-color:black; opacity:0.8; z-index:995px; padding:20% 48%;'><img src='../images/loading.gif' /></div>
<script>
			$('#over').slideDown(1000);
</script>	

<?php
$count=0;
$std=executeQuery("select stdid from student order by stdid");
echo "<table border ='1'>";
while($stdid=mysql_fetch_array($std))
{
	if($query=executeQuery("select t.testid,st.score,t.total,t.mean,t.standard_deviation from test as t INNER JOIN studenttest as st on t.testid=st.testid where stdid=$stdid[0]"))
	{
		$count++;
		$test_count=0;
		$average_marks=0;
		echo "<tr style='background-color:#728FCE;'><th colspan='4' style='text-align:center;'>Student ID $stdid[0] information Updation</th></tr><tr style='background-color:#ffcccc;'><th>Test ID</th><th>Normalized Percentage</th><th>Normalized Percentage 2</th><th>Success/Failure</th></tr>";
		while($row=mysql_fetch_array($query))
		{
			 $normalized_percentage=round((abs($row[1]-$row[3])/$row[4])*50 ,2);
			 
			 $normalized_percentage2=round(abs($row[1]-$row[3])/(($row[2]/2))*100,6);
			 
			 $average_marks=$average_marks+$row[1];
			 
			 //$average_marks=$average_marks+$normalized_percentage;
			 $test_count++;
			 echo "<tr><td>".$row[0]."</td><td>".$normalized_percentage."</td><td>".$normalized_percentage2."</td><td>";
				 if($q=executeQuery("update studenttest set normalized_percentage=$normalized_percentage where stdid=$stdid[0] and testid=$row[0]"))
					{
							echo "Success</td></tr>";
					}
				 else
					{
							echo "Failure</td></tr>";
					}		
		}
		if($test_count!=0)
			$average_marks=round($average_marks/$test_count ,2);
		else
			$average_marks=0;
			
			
		echo "<tr><th colspan='2' style='background-color:#a272cf;'>Average Marks--></th><td>$average_marks</td><td>";
		if($q=executeQuery("update student set average_percentage=$average_marks where stdid=$stdid[0]"))
				{
						echo "Success";
				}
			 else
				{
						echo "Failure";
				}
		echo "</td></tr>";
		
	}
	else
		echo "Error";	
		
echo "<tr height='50px'><td colspan='4'></td></tr>";		
}
?>
<script>

$('#over').slideUp(1000);
alert(<?php echo $count;?> +" student Information Updated.."); 


</script>

</body>
</html>