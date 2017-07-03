
<?php

error_reporting(0);
session_start();
include_once '../oesdb.php';

if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
	} 
 else if (isset($_REQUEST['logout'])) {
    header('Location: logout.php');
} 
else if(isset($_REQUEST['dashboard'])) {
            header('Location: admwelcome.php');
        }
else if(isset($_REQUEST['back'])) {
                header('Location: rsltmng.php');
        }

?>
<html>
    <head>
        <title>OES-Manage Results</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
		<script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
		
    </head>
    <body>
     <div id="container">
      <div class="header">
	  	<img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="../images/logo.gif" alt="OES"/>
		<div>
				<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
		</div>
	  </div>
	</div>
            <form name="rsltmng" action="rsltmng.php" method="post">
                <div class="menubar">
					<?php
					if($_GLOBALS['message']) 
					{
						echo "<span class=\"message\" style='float:left;width:50%;overflow:auto;'>" . $_GLOBALS['message'] . "</span>";
					}
					?>
                    <ul id="menu">
                        <?php if(isset($_SESSION['admname'])) 
						{
                        ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                            <?php  if(isset($_REQUEST['testid'])) { ?>
						<li ><input type="button" id="calc"  class="subbtn" onClick="updatemean();"  title="Calculate Mean & Standard Deviation" value="Calculate Mean & SD"/></li>	
                        <li><input type="submit" value="Back" name="back" class="subbtn"  title="Manage Results"/></li>
                            <?php }else { ?>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
                            <?php } ?>
                    </ul>
                </div>
                <div class="page">
                        
						<?php
                        if(isset($_REQUEST['testid'])) 
			{	
                            $raw=executeQuery("select total from test where testid=$_REQUEST[testid]");
                            $gg=mysql_fetch_array($raw);
                            $total=$gg[0];
                        	
                            $result=executeQuery("select t.testname,sub.subname from test as t, subject as sub where sub.subid=t.subid and t.testid=".$_REQUEST['testid'].";") ;
                         if(mysql_num_rows($result)!=0) 
                             {
                                $r=mysql_fetch_array($result);
                                ?>
								
                                   <table cellpadding="" cellspacing="" align="center" style="text-align:center; font-size:20px; width:100%; padding:10px 80px;" >
                                                                <tr>
                                                                  <th colspan="3" align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Test Summary</th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" ><hr style="color:#ff0000;border-width:3px;"/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Test Name : <?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>

                                                                    <td>Subject Name : <?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>

                                                                   <td>Total Marks : <?php echo $total; ?></td>
																</tr>
																<tr id="mean_row" hidden="hidden">
																	<td>Mean : <span id="mean"></span></td>
																	<td>Variance : <span id="variance"></span></td>
																	<td>Standard Deviation : <span id="stand_dev"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"><hr style="color:#ff0000;border-width:3px;"/></td>
                                                                </tr>
                                                                <tr>
																	<th colspan="3" align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Students Attempted</th>
                                                                </tr>
                                                    </table>
		<div id="resultview" style="width:100%;height:100%; overflow:auto;">
										
		<?php
	//Students who attempted test 		
                                             $res=executeQuery("select totalquestions from test where testid=".$_REQUEST['testid'].";" );
                                                if(mysql_num_rows($res)==0) 
												{
                                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">This Test is not valid..</h3>";
                                                }
                                                else 
                                                {
                                                    ?>
                                                    <table cellpadding="" cellspacing="" class="datatable" >
                                                        <thead><tr><th>Rank</th>
                                                            <th>Student Name</th>
															<th>Marks Obtained</th>
                                                            <th>Result(%)</th>

															<?php
															$i=1;
															$r=mysql_fetch_array($res);
															while($i<=$r['totalquestions'])
															{
                                                            	echo "<th style='text-align:center;font-size:12px;' >".$i."</th>";
                                                            	$i=$i+1;
															}	
															echo "</tr>";
															
															$i=1;
															echo "<tr>";
															echo "<td colspan='4' style='text-align:center; background:#00CCFF; font-size:20px'><b>CORRECT ANSWERS &#x21d2;</b></td>";
                                                            	
															while($i<=$r['totalquestions'])
															{
																$correct_option=executeQuery("select correct from subj_question where qnid_s=(select qnid_s from question where qnid=$i AND testid=".$_REQUEST['testid'].");" );
																$cor=mysql_fetch_array($correct_option);
																$string=$cor['correct'];
																$string=$string[strlen($string)-1];
																					   
                                                            	echo "<td style='text-align:center; background:#ccc4f4;color:#684bff;'><b>".$string."</b></td>";
                                                            	$i=$i+1;
															}
															echo "</tr></thead><tbody>";
															
																					   
															$result1=executeQuery("select * from studenttest as st INNER JOIN student as s ON s.stdid=st.stdid where st.testid=".$_REQUEST['testid']." order by st.score desc" );
															if(mysql_num_rows($result1)==0) 
															{
																echo"<h3 style=\"color:#0000cc;text-align:center;\">No Students Yet Attempted this Test!</h3>";
															}
															else        
															{
                                                                $road=executeQuery("select total from test where testid=$_REQUEST[testid]");
                                                                $road_r=mysql_fetch_array($road);
																$rank=0;
																$marks_sum=0;
																	while($r1=mysql_fetch_array($result1)) 
																		 {
																			?>
																			<tr>
																				<td><?php 
																					$rank++;
																					echo $rank;?></td><td style='cursor:pointer;' onmouseout="$(this).css('color','black');$(this).css('font-weight','normal');$(this).css('background-color','inherit');" onmouseover="$(this).css('color','white');$(this).css('font-weight','bold');$(this).css('background-color','#a272cf');" onclick="window.location='userGraph.php?sid=<?php echo $r1['stdid']; ?>'" ><?php echo htmlspecialchars_decode($r1['stdname'],ENT_QUOTES); ?></td>
																				<?php
																				$marks_sum=$marks_sum+$r1['score'];																
																				//$marks=executeQuery("select score from studenttest where stdid=$r1[stdid] and testid=".$_REQUEST['testid'].";" );
																				//$m=mysql_fetch_array($marks);
																					?>
																						<td><?php echo "<span id='score".$rank."'>$r1[score]</span>";?></td>
																						<td><?php echo round((($r1['score']/$road_r[0])*100),2)." %"; ?></td>
																					
																					
																				<?php
																				
																				$i=1;
																				while($i<=$r['totalquestions'])
																				{
																				   $std_answers=executeQuery("select * from studentquestion where qnid=$i AND stdid=$r1[stdid] AND testid=".$_REQUEST['testid'].";" );
																				   if(mysql_num_rows($std_answers)==0)
																				   {
																					   echo "<td style='text-align:center;background:#FFFFFF;' '></td>";
																				   }		
																				   else
																				   {																		   
																					   $correct=mysql_fetch_array($std_answers);
																					   $string=$correct['stdanswer'];
																					   $string=$string[strlen($string)-1];
																					   $correct_option=executeQuery("select correct from subj_question where qnid_s=(select qnid_s from question where qnid=$i AND testid=".$_REQUEST['testid'].");" );
																					   $cor=mysql_fetch_array($correct_option);
                                                                                                                                                                           if($cor['correct']==$correct['stdanswer'])
																					   		echo "<td style='text-align:center;background:#aff99e;'>".$string."</td>";
																					   else	
																					  		echo "<td style='text-align:center;background:#f99eaa;'>".$string."</td>";
																					  
																				   }
																				   $i=$i+1;
																				}
																				?>
																				
																			</tr></tbody>
																			<?php
																			}
																			
																			$mean=$marks_sum/$rank;
																			
																		}
															 }
											   }				 
							?>
                                                        <tr><td></td></tr>
							</table>
							
        </div>
		<div hidden="hidden">
			<span id='mean_show'>
				<?php echo round($mean,2);?>
			</span>
			<span id="total_students">
				<?php echo $rank;?>
			</span>
		</div>
		
					<?php 
                        }
                        else 
						{
							$result=executeQuery("select t.testid,t.testname,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid;");
                            if(mysql_num_rows($result)==0) 
							{
                                echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                            }
                            else 
							{
                                $i=0;

                                ?>
										<table  cellspacing="10" class="datatable">
											<tr height="40px" align="center">
												<th>Test Name</th>
												<th>Subject Name</th>
												<th>Attempted Students</th>
												<th>Update Scores</th>
												<th>Statistics</th>
												<th>Details</th>
											</tr>
											<?php
														while($r=mysql_fetch_array($result)) {
															if($r['attemptedstudents']!=0)
															{
																$i=$i+1;
																if($i%2==0) {
																	echo "<tr class=\"alt\">";
																}
																else { echo "<tr>";}
																
																echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".htmlspecialchars_decode($r['subname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>
																
																	<td class=\"tddata\"><img src=\"../images/recalculate.png\" height=\"40\" width=\"40\" title=\"Re-Calculate\" onClick='confirmation($r[testid]);' style='cursor:pointer;' /></td>
																	<td class=\"tddata\"><a title=\"Statistics\" href=\"testGraph.php?testid=".$r['testid']."\"><img src=\"../images/statistics.png\" height=\"30\" width=\"40\" alt=\"Statistics\" /> </a></td>
																	<td class=\"tddata\"><a title=\"Details\" href=\"rsltmng.php?testid=".$r['testid']."\"><img src=\"../images/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td>
																	</tr>";
															}
														}
											?>
										</table>
        				<?php
                            }
                        }
                        closedb();
                    }

                    ?>

                </div>
            </form>

      </div>
  </body>
<script>
	
				function confirmation(k)
				{
					var bool=confirm("It may take a few minutes..Do you really want to Re-Calculate Scores of this Test?");
					if(bool)
					{
					window.location="./correct_script.php?tid="+k;
					}
					else
						alert("Thanks for not forcing Server do so much amount of work...:-)");
					
				}
			
			<?php 
			
			if(isset($_REQUEST['testid']))
			{
			$query=executeQuery("select mean,variance,standard_deviation from test WHERE testid=$_REQUEST[testid]");
			if($query)
			{
				$mean=mysql_fetch_array($query);
                                	
					if($mean[0]==0)
					{
			?>
					$('#calc').removeAttr('hidden');
					$('#mean_row').attr('hidden','hidden');
			<?php		
					}
					else
					{
			?>	
					$('#calc').attr('hidden','hidden');
					$('#mean_row').removeAttr('hidden');
					$('#mean').html('<?php echo htmlspecialchars_decode($mean[0],ENT_QUOTES); ?>');
					$('#variance').html('<?php echo htmlspecialchars_decode($mean[1],ENT_QUOTES); ?>');
					$('#stand_dev').html('<?php echo htmlspecialchars_decode($mean[2],ENT_QUOTES); ?>');
			<?php
					}
			}
			?>
				var mean,variance,standard_deviation;
				function updatemean()
				{
					mean=parseFloat($('#mean_show').html(),10);
					var total=parseInt($('#total_students').html(),10);
					var variance_term=0;
					var student_score;
					var i;
					for(i=1;i<=total;i++)
					{
						student_score=parseFloat($('#score'+i).html(),10);
						variance_term=variance_term+((mean-student_score)*(mean-student_score));
					}
					variance=(variance_term/total).toFixed(2);
					standard_deviation=Math.sqrt(variance).toFixed(2);
					
					$('#mean').html(mean);
					$('#variance').html(variance);
					$('#stand_dev').html(standard_deviation);
					
					$('#calc').attr('hidden','hidden');
					$('#mean_row').removeAttr('hidden');
					var testid=<?php echo $_REQUEST['testid'];?>;
					$.ajax({url:"testajaxhandler.php?request_id=7&testid="+testid+"&mean="+mean+"&variance="+variance+"&sd="+standard_deviation,success:function(result){
								}
							 });
				}
				
				
				
			
			<?php
			}
			?> 
			
		</script>

</html>