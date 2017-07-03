<?php
error_reporting(0);
session_start();
include_once 'oesdb.php';
if (!isset($_SESSION['stdname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_SESSION['starttime'])) {
    header('Location: testconducter.php');
} else if (isset($_REQUEST['logout'])) {
    unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.<form name=\"relogin\" action=\"index.php\" method=\"post\">
                    <input type=\"submit\" value=\"Log In\" name=\"login_but\" class=\"subbtn\" href=\"index.php\" style=\"margin-top:-35px; float:right;\"  /> </form>";
            echo "<script>window.close(this);</script>";
} else if (isset($_REQUEST['dashboard'])) {
    //redirect to dashboard
    header('Location: stdwelcome.php');
} else if (isset($_REQUEST['starttest'])) {
    //Prepare the parameters needed for Test Conducter and redirect to test conducter
    if (true) {
        $result = executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=" . $_SESSION['testid'] . ";");
        if ($r = mysql_fetch_array($result)) {
            if (false) {
                $display = true;
                $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
            } else {
                //now prepare parameters for Test Conducter and redirect to it.
                //first step: Insert the questions into table
                $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                if (mysql_num_rows($result) == 0) {
                    $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                } else {
                  //  executeQuery("COMMIT");
                    $error = false;
                //    executeQuery("delimiter |");
                 /*   if (!executeQuery("create event " . $_SESSION['stdname'] . time() . "
ON SCHEDULE AT (select endtime from studenttest where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . ") + INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE
DO update studenttest set correctlyanswered=(select count(*) from studentquestion as sq,question as q where sq.qnid=q.qnid and sq.testid=q.testid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=" . $_SESSION['stdid'] . " and sq.testid=" . $_SESSION['testid'] . "),status='over' where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . "|"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    executeQuery("delimiter ;");*/
                    if (!executeQuery("insert into studenttest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    else {
                        while ($r = mysql_fetch_array($result)) {
                            if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL)")) {
                                $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                $error = true;
                            }
                        }
                        if ($error == true) {
                      //      executeQuery("rollback;");
                        } else {
                            $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                            $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                            $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['starttime'] = $r['startt'];
                            $_SESSION['endtime'] = $r['endt'];
                            $_SESSION['qn'] = 1;
                            header('Location: testconducter.php');
                        }
                    }
                }
            }
        } else {
            $display = true;
            $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
    } else {
        $display = true;
        $_GLOBALS['message'] = "Enter the Test Code First!";
    }
} else if (isset($_REQUEST['testcode'])) {
    //test code preparation
    if ($r = mysql_fetch_array($result = executeQuery("select testid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
        $_SESSION['testname'] = $_REQUEST['testcode'];
        $_SESSION['testid'] = $r['testid'];
    }
} else if (isset($_REQUEST['savem'])) {
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
    }
    closedb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>OES-Offered Tests</title>
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
						<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
				</div>
            </div>
            <form id="stdtest" action="stdtest.php" method="post">
                <div class="menubar">
							
					<?php
					if ($_GLOBALS['message']) {
						echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
					}
					?>
                    <ul id="menu">
                        <?php
                        if (isset($_SESSION['stdname'])) {
                            // Navigations
                        ?>
                            <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
                            <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>


                        </ul>
                    </div>
                    <div class="page">
                    <?php
                            if (isset($_REQUEST['testcode'])) {
                                echo "";
                            } else {
                                echo "<div class=\"pmsg\" style=\"text-align:center;\">Offered Tests</div>";
                            }
                    ?>
                    <?php
                            if (isset($_REQUEST['testcode']) || $display == true) {
                    ?>
                                <table cellpadding="30" cellspacing="10">
                                    <tr>
                                        
                                        <td><b>Note:</b><br/>Once you press start test<br/>button timer will be started</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="submit" tabindex="3" value="Start Test" name="starttest" class="subbtn" />
                                        </td>
                                    </tr>
                                </table>


                    <?php
                            } else {
                                
                                    //editing components
                    ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Test Description</th>
                                            <th>Subject Name</th>
                                            <th>Duration(min)</th>
                                            <th>Total Questions</th>
                                            <th>Take Test</th>
                                        </tr>
                        <?php
									//$result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid and t.totalquestions=(select count(*) from question where testid=t.testid) and t.status=1 ;");
									
									$result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid and t.totalquestions=(select count(*) from question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . ") and t.status=1 ;");
                            	
                                    while ($r = mysql_fetch_array($result)) {
                                        $i = $i + 1;
                                        
                                        $query="select duration,totalquestions from test where testid=". htmlspecialchars_decode($r['testid'], ENT_QUOTES);
                                        $r33=executeQuery($query);
                                        $row=mysql_fetch_array($r33);
                                        if ($i % 2 == 0) {
                                            echo "<tr class=\"alt\">";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo "<td>" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                        . "</td><td>" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td>"
                                        . "<td class=\"tddata\"><a title=\"Start Test\" href=\"runTest.php?testid=" . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "&dur=$row[0]&tot=$row[1]\"><img src=\"images/starttest.png\" height=\"30\" width=\"40\" alt=\"Start Test\" /></a></td></tr>";
                                    }
                        ?>
                                </table>
                    <?php
                                
                                closedb();
                            }
                        }
                    ?>

                </div>

            </form>
            <div id="footer">
               
            </div>
        </div>
    </body>
</html>

