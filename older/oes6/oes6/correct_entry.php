<?php

	if(isset($_GET['tid']) && isset($_GET['sid']))
	{
		include_once 'oesdb.php';
		$correct=0;
		$score=0.0;
    	$attpt=0;
		$r2=executeQuery("select marks from studentquestion where testid=$_GET[tid] and stdid=$_GET[sid]");
		while($row2=mysql_fetch_array($r2))
		{
			$score+=$row2[0];
			if($row2[0] > 0)
				$correct++;
			$attpt++;
		}
		//$marks_sum=$marks_sum+$score;	//TO CALCULATE MEAN
		executeQuery("update studenttest set correctlyanswered=$correct , score=$score , status='over' where testid=$_GET[tid] and stdid=$_GET[sid]");
		echo "Success";
		closedb();
	
	}

?>