<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';

if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
	}
	
if(!isset($_GET['id']))
{
?>
<html>
    <head>
        <title>OES-User Activity</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
		<script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" >
			function find()
			{				if($('#skey').val() != "")				{					$('#din').html("<center><img src='../images/loading.gif' alt='Loading..' /></center>");
										$.ajax({url:"user_activity.php?id=1&data="+escape($('#skey').val())+"&data2="+escape($('select#bat option:selected').val()),success:function(result){									
									$('#din').html(result);
									}
								});												}				else				{					$('#din').html("");					$('#disp').html("");				}
			}
			function show_act(k)
			{				$('#disp').html("<center><img src='../images/loading.gif' alt='Loading..' /></center>");				
				$.ajax({url:"user_activity.php?id=2&data="+k,success:function(result){
						
						$('#disp').html(result);
					}
				});					
			}
			function resetPass(k)
			{				$('#disp').html("<center><img src='../images/loading.gif' alt='Loading..' /></center>");				
				$.ajax({url:"user_activity.php?id=3&data="+k,success:function(result){
						
						$('#disp').html(result);
					}
				});	
			}
			function delTest(a,k)
			{				$('#disp').html("<center><img src='../images/loading.gif' alt='Loading..' /></center>");				
				$.ajax({url:"user_activity.php?id=4&data1="+a+"&data2="+k,success:function(result){
						
						$('#disp').html(result);
					}
				});	
			
			}
		</script>
    </head>
    <body>
        <div id="container">
            <div class="header">
               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="../images/logo.gif" alt="OES"/>
				<div>
						<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
				</div>
            </div>		<div class="menubar">				<?php				if(isset($_GLOBALS['message'])) {					echo "<div class=\"message\">".$_GLOBALS['message']."</div>";				}				?>				                <form name="admwelcome" action="admwelcome.php" method="post">                    <ul id="menu">                        <?php if(isset($_SESSION['admname'])){ ?>                        <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>                        <li><a href="admwelcome.php"><input type="button" value="Home" name="action" class="subbtn" /></a></li>                        <?php } ?>                    </ul>                </form>            </div>
		<div style="width:70%;margin:auto;height:500px;background-color:white;margin-top:0.2%;padding:10px;" >
			Search: <input type='text' onkeyup='find();' id='skey' placeholder="username" /> &nbsp;&nbsp;&nbsp;						Batch: <select id='bat'>			<?php				$r=executeQuery("select distinct(batch) from student order by batch DESC");								while($row=mysql_fetch_array($r))				{					echo "<option value='$row[0]' >$row[0]</option>";				}			?>			</select>			<br/>
			<div id="din" style="margin-top:1%;width:30%;border:1px solid;height:450px;float:left;overflow:auto;font-size:14px;" >
			
			</div>
			<div id="disp" style="margin-left:32%; border:1px solid;margin-right:1%;height:450px;margin-top:1%;padding:10px;" >
			
			</div>
		</div>
		</div>
		<div id="footer">
                
        </div>
    </body>
</html>
<?php
}
else
{
include_once '../oesdb.php';
	switch($_GET['id'])
	{
		case 1:
		echo "<table width='100%' >";
		$r=executeQuery("select stdid,stdname from student where stdname like '$_GET[data]%' and batch='$_GET[data2]'");
		while($row=mysql_fetch_array($r))
		{
			?>
					<tr style='cursor:pointer;' id="<?php echo $row[0]; ?>" onclick='show_act(<?php echo $row[0]; ?>);' >
						<th><?php echo $row[1]; ?></th>
					</tr>
			<?php
		}
		echo "</table>";
		break;
		case 2:
		$r=executeQuery("select stdid,stdname from student where stdid=$_GET[data]");
		$row=mysql_fetch_array($r);
		echo "<h2>Username: $row[1] </h2><br/>";
		echo "<input type='button' value='Reset Password' onclick='resetPass($row[0]);' />";
		$r=executeQuery("SELECT * FROM `studenttest` WHERE `status`='inprogress' and `stdid`=$_GET[data]");
		if(mysql_num_rows($r)>0)
		{
			echo "<table>";
			echo "<tr>
						<th>Test Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>";
				while($row=mysql_fetch_array($r))
				{
					$r2=executeQuery("select testname from test where testid=$row[1]");
					$row2=mysql_fetch_array($r2);
					echo "<tr>
						<td>$row2[0]</td>
						<td>$row[status]</td>
						<td><input type='button' value='Delete' onclick='delTest($row[testid],$row[stdid]);' />
					</tr>";
				}
			echo "</table>";
		}
		
		break;
		case 3:
		
		$r=executeQuery("UPDATE `student` SET `stdpassword`=md5('1234') WHERE `stdid`=$_GET[data]");
		echo "<h2 style='color:green;' >Password Reset Successful</h2>";
		break;
		case 4:
			$r=executeQuery("DELETE FROM `studenttest` WHERE `stdid`=$_GET[data2] and `testid`=$_GET[data1]");						echo "<h2 style='color:green;' >Test Deleted Successfuly</h2>";
		break;
	}	
	closedb();
}

?>