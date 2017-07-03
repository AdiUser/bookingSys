<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';

if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
	}
	
?>
<html>
    <head>
        <title>OES-Merge User</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
		<script type="text/javascript" >
			function conf()
			{
				if(confirm('Are you sure you want to merg?'))
					return true;
				else
					return false;
				
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
            </div>
			
			<div style="width:70%;margin:auto;height:400px;background-color:white;margin-top:2%;text-align:center;padding:10px;" >
			<?php
				if(!isset($_POST['submit']))
				{
			?>
				<h2><u>Merge User</u></h2>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST' onsubmit='return conf();' >
					Merge user : <select name='fromUser' >
									<?php
									$r=executeQuery("select stdid,stdname from student order by stdname");
									while($row=mysql_fetch_array($r))
									{
										echo "<option value='$row[0]'>$row[1]</option>";
									}
									?>
									
								</select>
					to user : <select name='toUser' >
									<?php
									mysql_data_seek( $r, 0 );
									while($row=mysql_fetch_array($r))
									{
										echo "<option value='$row[0]'>$row[1]</option>";
									}
									?>
									
								</select><br/><br/>
								<input type='submit' value='Merge' name='submit' />
				</form>
				<?php
				}
			else
			{
				if($_POST['fromUser'] == $_POST['toUser'])
				{
					echo "<h3 style='color:red' >Same User cannot be merged!</h3><br/><a href='$_SERVER[PHP_SELF]'>Re-Try</a>";
				}
				else
				{
					$r=executeQuery("UPDATE `studenttest` SET `stdid`=$_POST[toUser] WHERE `stdid`=$_POST[fromUser]");
					$r2=executeQuery("UPDATE `studentquestion` SET `stdid`=$_POST[toUser] WHERE `stdid`=$_POST[fromUser]");
					if($r && $r2)
					{
						$r3=executeQuery("DELETE FROM `student` WHERE `stdid`=$_POST[fromUser]");
						if($r3)
							echo "<h3 style='color:green' >User Merged!</h3><br/><a href='$_SERVER[PHP_SELF]'>Merge Another!</a>";
						
					}
				}
			}
			closedb();
			?>
			</div>
			
        </div>
		<div id="footer">
                
        </div>
    </body>
</html>
