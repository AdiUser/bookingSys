<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once 'oesdb.php';
//if(!isset($_GET['testid']))
//{echo "Access Denied"; exit();}
if(!isset($_SESSION['stdname'])) {
    echo "Session Timeout";
}
// ---------------Main Question setter and answere marker code!------------------------
if(isset($_GET['getTest']))
{
 
    $query="select q.qnid,s.question,s.figure,s.optiona,s.optionb,s.optionc,s.optiond,s.optione,s.level,s.type from question as q inner join subj_question as s on q.qnid_s=s.qnid_s  where q.testid=$_GET[getTest] order by q.qnid";
    $r=executeQuery($query);
    
    while($row=mysql_fetch_array($r))
    {
        
		$marks_query="select $row[8], n_$row[8] from level where testid=$_GET[getTest]";
		$r3=executeQuery($marks_query);
        $row3=mysql_fetch_array($r3);
        ?>
    
            <div id="<?php echo $row[0]; ?>qs">
                <form id='form-0' style="width:100%;" >
                    <p style='text-align:left;font-size:100%;color:black;padding:20px 10px;background-color:#f5f9f4; font-family:Verdana,Arial; '> <?php echo nl2br($row[1]); ?> </p>
                    <?php if($row[2]) {echo "<p style='text-align:center; overflow:auto;' ><img src='image_data/$row[2]' /></p>";} ?>
                    <?php
					if($row[9] == "MC")
					{
					?>
					<table border='0' width='100%' class='ntab'>
                        <tr><td >A. <input type='radio' <?php  echo "id='$row[0]opta'"; ?>  name='answer' value='optiona' onclick='<?php echo "answer_q(".$_SESSION['stdid'].",".$_GET['getTest'].",".$row[0].",this.id);"; ?>' /><?php echo $row[3]; ?></td></tr> 
                        <tr><td >B. <input type='radio' <?php  echo "id='$row[0]optb'"; ?>  name='answer' value='optionb' onclick='<?php echo "answer_q(".$_SESSION['stdid'].",".$_GET['getTest'].",".$row[0].",this.id);"; ?>' /><?php echo $row[4]; ?> </td></tr>
                       <tr><td >C. <input type='radio' <?php  echo "id='$row[0]optc'"; ?>  name='answer' value='optionc' onclick='<?php echo "answer_q(".$_SESSION['stdid'].",".$_GET['getTest'].",".$row[0].",this.id);"; ?>' /><?php echo $row[5]; ?> </td></tr>
                       <tr><td >D. <input type='radio' <?php  echo "id='$row[0]optd'"; ?>  name='answer' value='optiond' onclick='<?php echo "answer_q(".$_SESSION['stdid'].",".$_GET['getTest'].",".$row[0].",this.id);"; ?>' /><?php echo $row[6]; ?> </td></tr>
                      <?php 
                      if(trim($row[7])){
                            echo "<tr><td >E. <input type='radio'";
                            echo " name='answer' value='optione' id='$row[0]opte' name='answer' onclick='answer_q(".$_SESSION['stdid'].",".$_GET['getTest'].",".$row[0].",this.id);' /> $row[7] </td></tr>";
                        }
                        
                        
                        ?>
                       
                    </table>
					<?php
					}
					else
					{
						echo "<div style='margin-left:5%;margin-top:3%;' id='dispInp$row[0]' ></div>";
						echo "<script>$('#dispInp$row[0]').html($('#inpBoxStore').html());</script>";
					}
					?>
					<div id="marks<?php echo $row[0]; ?>" style="opacity:0;" ><span style='color:green;'>Positive Marks:<?php echo $row3[0]; ?>&nbsp;&nbsp;&nbsp;</span><span style='color:red;'>Negative Marks:<?php if($row[9] == "NT"){ echo "0"; }else {echo $row3[1];} ?></span></div>
                </form>
            </div>
	<?php
	}		
	
	echo "<div id='full_paper_retrieve'>";
	echo "<h1 style='text-align:center; color:white; background-color:black;'>Full Paper Preview</h1>";
	mysql_data_seek( $r, 0 );
	while($row=mysql_fetch_array($r))
    {
	$marks_query="select $row[8], n_$row[8] from level where testid=$_GET[getTest]";
	$r3=executeQuery($marks_query);
    $row3=mysql_fetch_array($r3);
        
    ?>
    
            
			<br/>
			<div >
                    <table border='0' class='ntab' width="90%">
					<tr><td ><p style='text-align:left;font-size:100%;color:black;padding:20px 10px;background-color:#f5f9f4; font-family:Verdana,Arial; '> <?php echo 'Q'.$row[0].'. '.nl2br($row[1]); ?> </p></tr></td >
                    <tr><td ><?php if($row[2]) {echo "<p style='text-align:center; overflow:auto;' ><img src='image_data/$row[2]' /></p>";} ?></tr></td >
                    		<?php 
							if($row[9] == "MC")
							{
							?>
								<tr><td >A. <?php echo $row[3]; ?></td></tr> 
								<tr><td >B. <?php echo $row[4]; ?> </td></tr>
								<tr><td >C. <?php echo $row[5]; ?> </td></tr>
								<tr><td >D. <?php echo $row[6]; ?> </td></tr>
								<?php 
									if(trim($row[7])){
										echo "<tr><td >E. $row[7] </td></tr>";
									}
							}
						   ?>
                       <tr><td><div style="text-align:center; font-size:14px;"><span style='color:green;'>Positive Marks:<?php echo $row3[0]; ?>&nbsp;&nbsp;&nbsp;</span><span style='color:red;'>Negative Marks:<?php if($row[9] == "NT"){ echo "0"; }else { echo $row3[1]; } ?></span></div>
                </td></tr>
                    </table>
            </div>
			<br/>
			<hr/>

                <?php     
				
    }
	echo "</div>";
    mysql_data_seek( $r, 0 );
        echo "<form action='' method='' id='ansForm' >";
		echo "<input type='text' name='qAns' value='$_GET[getTest]' />";    
		echo "<input type='text' name='sid' value='$_SESSION[stdid]' />";
    while($row3=mysql_fetch_array($r))
    {
        echo "<input type='text' name='$row3[0]anss' value='' />";
    }
        echo "</form>";
    
}
else if(isset($_POST['qAns']))
{
	$correct=0;
    $score=0.0;
    $attpt=0;
	$neg=0.0;
	$pos=0.0;
	$r4=executeQuery("select flag from sett where `key`='Error_Allowed'");
	$row4=mysql_fetch_array($r4);
    foreach ($_POST as $key => $value) 
    {
        
        if($key == "qAns" || $key == "sid" )
        { }
        else
        {
                if(!empty($value))
                {
                    $mat=preg_replace("/[^0-9]/","",$key);
                    
                    $r2=executeQuery("select level,correct,type from subj_question where qnid_s=(select qnid_s from question where testid=$_POST[qAns] and qnid=$mat) ");
                    $row=mysql_fetch_array($r2);
                    $r3=executeQuery("select * from level where testid=$_POST[qAns]");
                    $row2=mysql_fetch_array($r3);
					
					$value=trim($value);
					
					if($row[2] == "MC")
					{
						if($value == $row[1])
						{
							$mks=$row2[$row[0]];
							$correct+=1;
							$score=$score+$mks;
							$pos+=$mks;
						}
						else
						{
							$mks=-$row2['n_'.$row[0]];
							$score=$score+$mks;
							$neg+=$mks;
						}
					}
					else
					{
						if( $value >= ($row[1]-$row4[0]) && $value <= ($row[1]+$row4[0]) )
						{
							$mks=$row2[$row[0]];
							$correct+=1;
							$score=$score+$mks;
							$pos+=$mks;
						}
						else
						{
							$mks=0;
						}
                    }
                    // echo "$key <br/> $mat <br/>";
                    $query="INSERT INTO `studentquestion`(`stdid`, `testid`, `qnid`, `marks`, `stdanswer`) VALUES ($_POST[sid],$_POST[qAns],$mat,$mks,'$value')";
                    $r=executeQuery($query);
                    $attpt+=1;
                }
            
        }
    }
    
    

    $r=executeQuery("select testname,totalquestions,total from test where testid=$_POST[qAns]");
    $row=  mysql_fetch_array($r);
    
    $p=($score/$row[2])*100;
    
	$rr2=executeQuery("select status from studenttest where testid=$_POST[qAns] and stdid=$_POST[sid]");
	if(mysql_num_rows($rr2) > 0 )
	{
		executeQuery("update studenttest set correctlyanswered=$correct , score=$score, status='over' where testid=$_POST[qAns] and stdid=$_POST[sid]");
	}
	else
	{
		executeQuery("insert into studenttest values($_POST[sid], $_POST[qAns], DEFAULT, $correct ,$score, 'over', DEFAULT)");
	}
	?>
    <table>
        <tr>
            <th> Test </th>
            <td><?php echo $row[0]; ?></td>
        </tr>
        <tr>
            <th> Total Questions </th>
            <td><?php echo $row[1]; ?></td>
        </tr>
        <tr>
            <th> Total Attempted </th>
            <td><?php echo $attpt; ?></td>
        </tr>
        <tr>
            <th> Total Correct </th>
            <td><?php echo $correct; ?></td>
        </tr>
		<tr>
            <th> Total Positive Score</th>
            <td><?php echo "<span style='color:green;' >$pos</span>"; ?></td>
        </tr>
		<tr>
            <th> Total Negative Score</th>
            <td><?php echo "<span style='color:red;' >$neg</span>"; ?></td>
        </tr>
        <tr>
            <th> Total Score </th>
            <td style="color:brown;font-weight:bold;"><?php echo "$score / $row[2]"; ?></td>
        </tr>
        <tr>
            <th> Percentage </th>
            <td style="color:blue;font-weight:bold;"><?php echo round($p,2)." %"; ?></td>
        </tr>
        <tr>
            <th>Correct Answers </th> <td> <a href="creatPdf.php?testid=<?php echo $_POST['qAns']."&ssid=".$_POST['sid']; ?>" >Download</a> </td>
            
        </tr>
        <tr>
            <th colspan="2"> <a href="logout.php" >Logout</a> </th>
            
        </tr>
    </table>
    <?php
    $_SESSION['test']="off";
}
else if(isset($_POST['qAns_re']))
{
	$correct=0;
    $score=0.0;
    $attpt=0;
	$neg=0.0;
	$pos=0.0;
	
	$contt=array();
	$cont_c=0;
	
	foreach ($_POST as $key => $value) 
    {
        
        if($key == "qAns_re" || $key == "sid" )
        { }
        else
        {
                if(!empty($value))
                {
                    $mat=preg_replace("/[^0-9]/","",$key);
                    
                    $r2=executeQuery("select level,correct from subj_question where qnid_s=(select qnid_s from question where testid=$_POST[qAns_re] and qnid=$mat) ");
                    $row=mysql_fetch_array($r2);
                    $r3=executeQuery("select * from level where testid=$_POST[qAns_re]");
                    $row2=mysql_fetch_array($r3);

                    if($value == $row[1])
					{
                        $mks=$row2[$row[0]];
						$correct+=1;
						$score=$score+$mks;
						$pos+=$mks;
					}
                    else
					{
                        $mks=-$row2['n_'.$row[0]];
						$score=$score+$mks;
						$neg+=$mks;
						$contt[$cont_c]="<tr> <td style='font-size:18px;text-align:center;' >$mat</td> <td style='color:red;font-size:18px;text-align:center;' >".substr($value,6,6)."</td> <td style='color:green;font-size:18px;text-align:center;' >".substr($row[1],6,6)."</td> </tr>";
						$cont_c+=1;
					}
					$attpt+=1;
                }
				
            
        }
    }
    
    

    $r=executeQuery("select testname,totalquestions,total from test where testid=$_POST[qAns_re]");
    $row=  mysql_fetch_array($r);
   
    $p=($score/$row[2])*100;
    
	?>
    <table>
        <tr>
            <th> Test </th>
            <td><?php echo $row[0]; ?></td>
        </tr>
        <tr>
            <th> Total Questions </th>
            <td><?php echo $row[1]; ?></td>
        </tr>
        <tr>
            <th> Total Attempted </th>
            <td><?php echo $attpt; ?></td>
        </tr>
        <tr>
            <th> Total Correct </th>
            <td><?php echo $correct; ?></td>
        </tr>
		<tr>
            <th> Total Positive Score</th>
            <td><?php echo "<span style='color:green;' >$pos</span>"; ?></td>
        </tr>
		<tr>
            <th> Total Negative Score</th>
            <td><?php echo "<span style='color:red;' >$neg</span>"; ?></td>
        </tr>
        <tr>
            <th> Total Score </th>
            <td style="color:brown;font-weight:bold;"><?php echo "$score / $row[2]"; ?></td>
        </tr>
        <tr>
            <th> Percentage </th>
            <td style="color:blue;font-weight:bold;"><?php echo round($p,2)." %"; ?></td>
        </tr>
        <tr>
			<td colspan="2" >
			<div style="width:100%;height:300px;padding:2px;background-color:white;overflow:auto;" >
			<strong>Wrong Attempts:</strong><br/>
			<table>
				<tr>
					<th style="font-size:18px;" >Q No</th> <th style="font-size:18px;" >Your Answer</th> <th style="font-size:18px;" >Correct Answer</th>
 				</tr>
				<?php
					foreach($contt as $v)
					{
						echo $v;
					}
				?>
			</table>
			</div>
			</td>
		</tr>
        <tr>
            <th colspan="2"> <a href="logout.php" >Logout</a> </th>
            
        </tr>
    </table>
    <?php
	$_SESSION['test']="off";
}
else if(isset($_GET['unAns']))
{
    $query="delete from studentquestion where stdid=$_GET[stdid] and testid=$_GET[unAns] and qnid=$_GET[qno]";
        $r=executeQuery($query);
        if($r)
            echo '1';
        else
            echo '-1';
}
else if(isset($_GET['start']))
{
	$rr2=executeQuery("select status from studenttest where testid=$_POST[start] and stdid=$_SESSION[stdid]");
	if(mysql_num_rows($rr2) == 0 )
	{
    
		if (executeQuery("insert into studenttest values($_SESSION[stdid], $_GET[start], DEFAULT, 0,DEFAULT, 'inprogress', DEFAULT)"))
		{
			echo 'Test Started';
		}
	}
	echo 'Re-appear';
	
}
else if(isset($_GET['over']))
{
    if (executeQuery("update studenttest set status='over' where stdid=$_GET[ssid] and testid=$_GET[over]"))
    {
        echo 'Test Over';
    }
}
else if(isset($_GET['result']))
{
    $correct=0;
    $score=0.0;
    $attpt=0;
    
    $r=executeQuery("select testname,totalquestions from test where testid=$_GET[result]");
    $row=  mysql_fetch_array($r);
    
    $r2=executeQuery("select marks from studentquestion where testid=$_GET[result] and stdid=$_SESSION[stdid]");
    while($row2=mysql_fetch_array($r2))
    {
        $score+=$row2[0];
        if($row2[0] > 0)
            $correct++;
        $attpt++;
    }
    $r4=executeQuery("select total from test where testid=$_GET[result]");
    $row4=  mysql_fetch_array($r4);
    $p=($score/$row4[0])*100;
    
    executeQuery("update studenttest set correctlyanswered=$correct , score=$score, status='over' where testid=$_GET[result] and stdid=$_SESSION[stdid]");
    ?>
    <table>
        <tr>
            <th> Test </th>
            <td><?php echo $row[0]; ?></td>
        </tr>
        <tr>
            <th> Total Questions </th>
            <td><?php echo $row[1]; ?></td>
        </tr>
        <tr>
            <th> Total Attempted </th>
            <td><?php echo $attpt; ?></td>
        </tr>
        <tr>
            <th> Total Correct </th>
            <td><?php echo $correct; ?></td>
        </tr>
        <tr>
            <th> Total Score </th>
            <td style="color:red;"><?php echo "$score / $row4[0]"; ?></td>
        </tr>
        <tr>
            <th> Percentage </th>
            <td style="color:blue;"><?php echo round($p,2)." %"; ?></td>
        </tr>
        <tr>
            <th>Correct Answers </th> <td> <a href="creatPdf.php?testid=<?php echo $_GET['result']; ?>" >Download</a> </td>
            
        </tr>
        <tr>
            <th colspan="2"> <a href="logout.php" >Logout</a> </th>
            
        </tr>
    </table>
    <?php
}
else if(isset($_GET['resume']))
{
    if(isset($_GET['resume']) && $_GET['resume']== "on")
    {
        $_SESSION['resume']='on';
    }
    $t=$_GET['testid'];
    $query="select duration,totalquestions from test where testid=$t";
    $r=executeQuery($query);
    $row=mysql_fetch_array($r);
    echo "<script> window.location='runTest.php?testid=$_GET[testid]&dur=$row[0]&tot=$row[1]' </script>";

}
else
{
	echo "<h1>Access Denied!</h1>";
}
closedb();
?>
