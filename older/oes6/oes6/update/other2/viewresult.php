<?php

error_reporting(0);
session_start();
include_once 'oesdb.php';
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}

    
        else if(isset($_REQUEST['dashboard'])) {
        //redirect to dashboard

            header('Location: stdwelcome.php');

        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>OES-View Result</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="oes.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    <body class='default' style="height:100%; margin-top:-30px;">
		<div id="container">
            <div class="header">
               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
				<div>
						<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
				</div>
            </div>
            <form id="summary" action="viewresult.php" method="post">
                <div class="menubar">
					<?php
					if($_GLOBALS['message']) {
						echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
					}
					?>
                    <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])) {
                        // Navigations
                        if(isset($_REQUEST['details'])) {
              ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="Back" name="back" class="subbtn" title="View Results"/></li>
                        <?php
                        }
                        else
                        {
                            ?>
                        <li><a href='logout.php' ><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
                        <?php
                        }
                        ?>

                    </ul>


                </div>
                <div class="page">

                        <?php

                      


                            $result=executeQuery("select testid,starttime,score from studenttest where stdid=$_SESSION[stdid] and status='over' order by testid");
                            if(mysql_num_rows($result)==0) {
                                echo"<h3 style=\"color:#0000cc;text-align:center;\">I Think You Haven't Attempted Any Exams Yet..! Please Try Again After Your Attempt.</h3>";
                            }
                            else {
                                
                            //editing components
                                ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Date and Time</th>
                            <th>Test Name</th>
                            <th>Total Marks</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Only Questions</th>
						<!--	<th>With Answer Key</th> -->
                        </tr>
            <?php
            while($r=mysql_fetch_array($result)) 
             {
                $r2=executeQuery("select testname,total from test where testid=$r[0]");
                $row=mysql_fetch_array($r2);
                echo "<tr>";
                echo "<td>$r[1]</td> <td>$row[0]</td> <td>$row[1]</td> <td>$r[2]</td> <td>".round(($r[2]/$row[1])*100,2)."</td> <td><a href='creatPdf.php?testid=$r[0]&ssid=$_SESSION[stdid]&key=on'>PDF</a></td>";
                //echo "<td><a href='creatPdf.php?testid=$r[0]&ssid=$_SESSION[stdid]'>PDF</a></td>";
				echo "</tr>";
             }

                                    ?>

                    </table>
        <?php
        }
                      
                        closedb();
                    }
                    ?>

                </div>

            </form>
            <div id="footer">
        </div>
      </div>
  </body>
</html>

