<?php
include_once '../oesdb.php';
session_start();
ini_set('max_execution_time', 180);
if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
} 
if(!isset($_GET['tid']))
{
	echo "Invalid Request!";
	exit();
}
if(!isset($_GET['wait']))
{
	echo "<h1 style='text-align:center;margin-top:20%;' >Re-Calculating Score....</h1>";
	echo "<p style='text-align:center;' >Please wait for a moment..., <strong>DO NOT CLOSE</strong> this Window!</p>";
	echo "<script>window.location='correct_script.php?tid=$_GET[tid]&wait=on';</script>";
}
	//---DECLARATION OF MEAN VARIABLES
	$s_count=0;
	$marks_sum=0.0;
	$variance=0.0;
	$standard_deviation=0.0;
	
	$r=executeQuery("select stdid from studenttest where testid=$_GET[tid]");
	while($row=mysql_fetch_array($r))
	{
	
		$r3=executeQuery("select `qnid`,`stdanswer` FROM `studentquestion` WHERE stdid=$row[0] and testid=$_GET[tid]");
		while($row3=mysql_fetch_array($r3))
		{
					$r4=executeQuery("select level,correct from subj_question as sq inner join question as q on sq.qnid_s=q.qnid_s  where q.testid=$_GET[tid] and q.qnid=$row3[0] ");
                    $row4=mysql_fetch_array($r4);
                    $r5=executeQuery("select * from level where testid=$_GET[tid]");
                    $row5=mysql_fetch_array($r5);
					
					if($row3[1] == $row4[1])
                        $mks=$row5[$row4[0]];
                    else
						$mks=-$row5['n_'.$row4[0]];
					
					$query="UPDATE `studentquestion` SET `marks`=$mks WHERE `stdid`=$row[0] and `testid`=$_GET[tid] and `qnid`=$row3[0]";
                    executeQuery($query);
					
		}
		$s_count+=1;
		$correct=0;
		$score=0.0;
    	$attpt=0;

		$r2=executeQuery("select marks from studentquestion where testid=$_GET[tid] and stdid=$row[0]");
		while($row2=mysql_fetch_array($r2))
		{
			$score+=$row2[0];
			if($row2[0] > 0)
				$correct++;
			$attpt++;
		}
		$marks_sum=$marks_sum+$score;	//TO CALCULATE MEAN
		executeQuery("update studenttest set correctlyanswered=$correct , score=$score , status='over' where testid=$_GET[tid] and stdid=$row[0]");
    }
	
	//CALCULATING STANDARD DEVIATION AND VARIANCE
	$mean=$marks_sum/$s_count;
	$var=0;
	$r5=executeQuery("select stdid,score from studenttest where testid=$_GET[tid]");
	while($row5=mysql_fetch_array($r5))
	{
		$var=$mean-$row5[1];
		$variance=$variance+($var*$var);
	}
	$variance=$variance/$s_count;
	$sd=sqrt($variance);
	$variance=round($variance,2);
	$sd=round($sd,2);
	$mean=round($mean,2);
	
	executeQuery("UPDATE test SET mean=$mean,variance=$variance,standard_deviation=$sd WHERE testid=$_REQUEST[tid]");
	
	
	
	
closedb();
echo "<h1 style='text-align:center;margin-top:25%;' >Score Updated Successsfully.</h1>";
echo "<p style='text-align:center;' >Total Updated: $s_count <br><a href='$PATH_ADMIN' >Home</a></p>";
	
?>