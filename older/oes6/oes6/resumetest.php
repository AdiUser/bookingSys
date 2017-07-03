
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
error_reporting(0);
session_start();
include_once 'oesdb.php';
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.<form name=\"relogin\" action=\"index.php\" method=\"post\">
                    <input type=\"submit\" value=\"Log In\" name=\"login_but\" class=\"subbtn\" href=\"index.php\" style=\"margin-top:-35px; float:right;\"  /> </form>";
            echo "<script>window.close(this);</script>";

    }
    else if(isset($_REQUEST['dashboard'])) {
        //redirect to dashboard
            header('Location: stdwelcome.php');

        }
        else if(isset($_REQUEST['resume'])) {
            //test code preparation
                if($r=mysql_fetch_array($result=executeQuery("select testname from test where testid=".$_REQUEST['resume'].";"))) {
                    $_SESSION['testname']=htmlspecialchars_decode($r['testname'],ENT_QUOTES);
                    $_SESSION['testid']=$_REQUEST['resume'];
                }
            }
            else if(isset($_REQUEST['resumetest'])) {
                //Prepare the parameters needed for Test Conducter and redirect to test conducter
                    if(true) {
                        $result=executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=".$_SESSION['testid'].";");

                        if($r=mysql_fetch_array($result)) {
                            if(false) {
                                $display=true;
                                $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                            }
                            else {
                            //now prepare parameters for Test Conducter and redirect to it.

                                $result=executeQuery("select totalquestions,duration from test where testid=".$_SESSION['testid'].";");
                                $r=mysql_fetch_array($result);
                                $_SESSION['tqn']=htmlspecialchars_decode($r['totalquestions'],ENT_QUOTES);
                                $_SESSION['duration']=htmlspecialchars_decode($r['duration'],ENT_QUOTES);
                                $result=executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
                                $r=mysql_fetch_array($result);
                                $_SESSION['starttime']=$r['startt'];
                                $_SESSION['endtime']=$r['endt'];
                                $_SESSION['qn']=1;
                                header('Location: testconducter.php');
                            }

                        }
                        else {
                            $display=true;
                            $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                        }
                    }
                    else {
                        $display=true;
                        $_GLOBALS['message']="Enter the Test Code First!";
                    }
                }


?>

<html>
    <head>
        <title>OES-Resume Test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="oes.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    <body >
        <div id="container">
           <div class="header">
               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
				<div>
						<h3 class="headtext"> &nbsp;GEU Online Examination System </h3>
						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Transforming Dreams into Reality</i></h4>
				</div>
            </div>
            <form id="summary" action="resumetest.php" method="post">
                <div class="menubar">

					<?php

					if($_GLOBALS['message']) {
						echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
					}
					?>
                    <ul id="menu">
        <?php if(isset($_SESSION['stdname'])) {
// Navigations
    ?>
                        <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>

                    </ul>


                </div>
                <div class="page">

    <?php
    if(isset($_REQUEST['resume'])) {
        //echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of ".$_SESSION['testname']." ? </div>";
    }
    else {
        echo "<div class=\"pmsg\" style=\"text-align:center;\">Tests to be Resumed</div>";
    }
    ?>
                        <?php

                        if(isset($_REQUEST['resume'])|| $display==true) {
                            ?>
                    <table cellpadding="30" cellspacing="10">
                        <tr>
                            <td>Enter Test Code</td>
                            <td><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
                            <td><b>Note:</b> Press Resume button to utilize<br/> Remaining time.</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" tabindex="3" value="Resume Test" name="resumetest" class="subbtn" />
                            </td>
                        </tr>
                    </table>


    <?php
    }
    else {

        $result=executeQuery("select * from studenttest where stdid=$_SESSION[stdid] and status='inprogress'");
        if(mysql_num_rows($result)==0) {
            echo"<h3 style=\"color:#0000cc;text-align:center;\">There are no incomplete exams, that needs to be resumed! Please Try Again..!</h3>";
        }
        else {
        //editing components
            ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Test</th>
                            <th>Subject</th>

                            <th>Resume</th>
                        </tr>
                                <?php

                                while($r=mysql_fetch_array($result)) {

                                    $r2=executeQuery("select testname,subid from test where testid=$r[1]");
                                    $row2=mysql_fetch_array($r2);

                                    $r3=executeQuery("select subname from subject where subid=$row2[1]");
                                    $row3=mysql_fetch_array($r3);


                                        echo "<tr>";
                                        echo "<td>$row2[0]</td> <td>$row3[0]</td> <td><a href='prepareTest.php?testid=$r[1]&resume=on'>Resume</a></td>";
                                        echo "</tr>";
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
</html>
