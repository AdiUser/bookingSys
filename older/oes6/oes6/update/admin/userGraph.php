<?php
error_reporting(0);
session_start();

if(isset($_SESSION['admname']) && isset($_GET['sid']))
{
	$sid=$_GET['sid'];
}
else
{
	$sid=$_SESSION['stdid'];
}
include_once '../oesdb.php';
$marks_query="select stdname from student where stdid=$sid";
$r=executeQuery($marks_query);
$row8=mysql_fetch_array($r);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OES: <?php echo "$row8[0]";?> Graph</title>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
         
        <script type="text/javascript" src="../lib/gettheme.js"></script>
        <link rel="stylesheet" href="../lib/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link rel="stylesheet" href="../lib/jqwidgets/styles/jqx.office.css" type="text/css" />
        <script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="../lib/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="../lib/jqwidgets/jqxdata.js"></script>
        <script type="text/javascript" src="../lib/jqwidgets/jqxchart.js"></script>
        <script type="text/javascript" src="../lib/jqwidgets/jqxcheckbox.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var theme = "office";
            // prepare chart data as an array
            var sampleData = [
            <?php
                
                //$te=$tm=$th=0;
                
                $f=0;
				$cnt=0;
                $r=executeQuery("SELECT s.testid,t.testname FROM studenttest as s inner join test as t on s.testid=t.testid WHERE s.stdid=$sid and s.status='over' order by s.starttime");
                while ($row=  mysql_fetch_array($r))
                {
					$cnt=$cnt+1;
                    $tes=$tms=$ths=0;
                    //$r2=executeQuery("select * from level where testid=$row[0]");
                    //$row2=mysql_fetch_array($r2);
                    //-----Easy Questions---------
                    $r3=executeQuery("select q.testid,q.qnid from subj_question as s inner join question as q on s.qnid_s=q.qnid_s where s.level='level_e' and q.testid=$row[0]");
                    while($row3=  mysql_fetch_array($r3))
                    {
                        $r4=executeQuery("select marks from studentquestion where testid=$row3[0] and qnid=$row3[1] and stdid=$sid");
                        if(mysql_num_rows($r4) > 0)
                        {
                            $row4=mysql_fetch_array($r4);
                            $tes+=$row4[0];
                        }
                        //$te+=$row2['level_e'];
                    }
                    //------Medium Questions-------
                    $r3=executeQuery("select q.testid,q.qnid from subj_question as s inner join question as q on s.qnid_s=q.qnid_s where s.level='level_m' and q.testid=$row[0]");
                    while($row3=  mysql_fetch_array($r3))
                    {
                        $r4=executeQuery("select marks from studentquestion where testid=$row3[0] and qnid=$row3[1] and stdid=$sid");
                        if(mysql_num_rows($r4) > 0)
                        {
                            $row4=mysql_fetch_array($r4);
                            $tms+=$row4[0];
                        }
                        //$tm+=$row2['level_m'];
                    }
                    //----------Hard Questions-----------
                    $r3=executeQuery("select q.testid,q.qnid from subj_question as s inner join question as q on s.qnid_s=q.qnid_s where s.level='level_h' and q.testid=$row[0]");
                    while($row3=  mysql_fetch_array($r3))
                    {
                        $r4=executeQuery("select marks from studentquestion where testid=$row3[0] and qnid=$row3[1] and stdid=$sid");
                        if(mysql_num_rows($r4) > 0)
                        {
                            $row4=mysql_fetch_array($r4);
                            $ths+=$row4[0];
                        }
                        //$th+=$row2['level_h'];
                    }
                    $r5=executeQuery("select total from test where testid=$row[0]");
                    $row5=mysql_fetch_array($r5);
                    
                    $score=$tes+$tms+$ths;
                    $tot=round(($score/$row5[0])*100,2);
                    
                    $a1=round(($tes/$row5[0])*100,2);
                    $a2=round(($tms/$row5[0])*100,2);
                    $a3=round(($ths/$row5[0])*100,2);
                    
                    if($f == 0)
                    {
                        echo "{ Test: '$row[1]', Easy: $a1, Medium: $a2, Hard: $a3, Total: $tot }";
                    }
                    else
                    {
                        echo ",{ Test: '$row[1]', Easy: $a1, Medium: $a2, Hard: $a3, Total: $tot }";
                    }
                    $f=$f+1;
                }
                
            ?>
            
                ];

            // prepare jqxChart settings
            var settings = {
                title: "Performance Scorecard",
                description: "Score in various Test by <?php echo $row8[0] ?>",
                enableAnimations: true,
                showLegend: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: sampleData,
                categoryAxis:
                    {
                        text: 'Category Axis',
                        textRotationAngle: 0,
                        dataField: 'Test',
                        showTickMarks: true,
                        tickMarksInterval: 1,
                        tickMarksColor: '#888888',
                        unitInterval: 1,
                        showGridLines: false,
                        gridLinesInterval: 1,
                        gridLinesColor: '#888888',
                        axisSize: 'auto'
                    },
                colorScheme: 'scheme05',
                seriesGroups:
                    [
                        {
                            type: 'splinearea',
                            valueAxis:
                            {
                                unitInterval: 10,
                                minValue: 0,
                                maxValue: 100,
                                displayValueAxis: false,
                                description: 'Goal in minutes',
                                axisSize: 'auto',
                                tickMarksColor: '#888888'
                            },
                            series: [
                                    { greyScale: false, dataField: 'Total', displayText: 'Total %', opacity: 0.7 }
                                ]
                        },
                        {
                            type: 'stackedcolumn',
                            columnsGapPercent: 100,
                            seriesGapPercent: 5,
                            valueAxis:
                            {
                                unitInterval: 10,
                                minValue: 0,
                                maxValue: 100,
                                displayValueAxis: true,
                                description: 'Scores',
                                axisSize: 'auto',
                                tickMarksColor: '#888888',
                                gridLinesColor: '#777777'
                            },
                            series: [
                                    { greyScale: true, dataField: 'Easy', displayText: 'Easy %' },
                                    { greyScale: true, dataField: 'Medium', displayText: 'Medium %' },
                                    { greyScale: true, dataField: 'Hard', displayText: 'Hard %' }
                                ]
                        }
                    ]
            };

            // setup the chart
            $('#jqxChart').jqxChart(settings);
            $("#Running").jqxCheckBox({ width: 120, theme: theme, checked: false });
            $("#Swimming").jqxCheckBox({ width: 120, theme: theme, checked: false });
            $("#Cycling").jqxCheckBox({ width: 120, theme: theme, checked: false });
            $("#Goal").jqxCheckBox({ width: 120, theme: theme, checked: true });
            var groups = $('#jqxChart').jqxChart('seriesGroups');
            var refreshChart = function () {
                $('#jqxChart').jqxChart({ enableAnimations: false });
                $('#jqxChart').jqxChart('refresh');
            }
            // update greyScale values.
            $("#Running").on('change', function (event) {
                groups[1].series[0].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Cycling").on('change', function (event) {
                groups[1].series[2].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Swimming").on('change', function (event) {
                groups[1].series[1].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Goal").on('change', function (event) {
                groups[0].series[0].greyScale = !event.args.checked;
                refreshChart();
            });
        });
    </script>
</head>
<body class='default' style="height:100%; margin-top:-30px;">
    <div id="container">
      <div class="header">
	  	<img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="../images/logo.gif" alt="OES"/>
		<div>
				<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
		</div>
	  </div>
	</div>
        
            <div class="menubar">
			<?php
			if($_GLOBALS['message']) 
					{
						echo "<span class=\"message\" style='float:left;width:50%;overflow:auto;'>" . $_GLOBALS['message'] . "</span>";
					}
			?>

                <form name="stdwelcome" action="stdwelcome.php" method="post">
                    <ul id="menu">
                     <?php if(isset($_SESSION['admname'])){ ?>
                        <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
                        <li><a href="usermng.php"><input type="button" value="Back" name="action" class="subbtn" /></a></li>
                        <li><a href="admwelcome.php"><input type="button" value="Dashboard" name="action" class="subbtn" /></a></li>
                       <?php } ?>
                    </ul>
                </form>
            </div>
    <div class="page" style="width:100%;">
        
        <div style='margin-top:margin-right: 20px; background: inherit;'>
            <span style="font-size:24px;width:50%;">Statistics of <?php echo $row8[0] ?></span>
			<div style='float: left; margin-top:5px;'>
                <div style='width:15%;float: right;' id='Goal'>Total</div>
                <div style='width:10%;float: right;'id='Cycling'>Hard</div>
                <div style='width:10%;float: right;' id='Swimming'>Medium</div>
                <div style='float: left;width:10%;' id='Running'>Easy</div>
            </div>
        </div>
		
		
		<div style="width:'100%'; overflow:auto;">    
			<div id='jqxChart' style="<?php if($cnt <= 3) echo "width: 500px;"; else if($cnt > 3 && $cnt <=8) echo "width: 1000px;"; else echo "width: 1500px;"; ?> height: 400px;text-align: center;padding:15px;"></div>
		</div>
		<div id="performance">
			<?php
			$tq=$w=$c=$s=$a=0;
				$query=executeQuery("select testid,testname,totalquestions from test where testid in (select distinct(testid) from studenttest where stdid=$_REQUEST[sid] order by starttime)");
				if($query)
				{
				echo "<table class='datatable'>
					<tr>
						<th>Subject</th>
						<th>Total Questions</th>
						<th>Attempted</th>
						<th>Correct</th>
						<th>Wrong</th>
						<th>Score</th>
					</tr>";
					while($resu=mysql_fetch_array($query))
					{	
						$correct=0;
						$attempted=0;
						$wrong=0;						
						$count_query=executeQuery("SELECT * FROM `studentquestion` where stdid=$_REQUEST[sid] and testid=$resu[0]");
						if($count_query)
						{
							while($count=mysql_fetch_array($count_query))
								{
									$attempted++;
									if($count[3]>0)
										$correct++;
									else
										$wrong++;
								}
							$score_query=executeQuery("SELECT score FROM `studenttest` where stdid=$_REQUEST[sid] and testid=$resu[0]");
							$score=mysql_fetch_array($score_query);
							echo "<tr>
									<td><b>".$resu[1]."</b></td>
									<td>".$resu[2]."</td>
									<td>".$attempted."</td>
									<td>".$correct."</td>
									<td>".$wrong."</td>
									<td>".$score[0]."</td>							
							</tr>";
							$tq=$tq+$resu[2];
							$a+=$attempted;
							$c+=$correct;
							$w+=$wrong;
							$s+=$score[0];
						}
					}
					
					echo "<tr style='background-color:#a272cf;'><td><b>TOTAL STATS</b></td><td>$tq</td><td>$a</td><td>$c</td><td>$w</td><td>$s</td></tr></table>";
				}
				?>
		</div>
	
	
    </div>
</body>
</html>
<?php
	closedb();
?>