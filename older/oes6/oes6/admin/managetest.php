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

else if (isset($_REQUEST['dashboard'])) {

    header('Location: admwelcome.php');

}

else if (isset($_REQUEST['savea'])) {

				if (empty($_REQUEST['testname']) || empty($_REQUEST['testdesc']) || empty($_REQUEST['totalqn']) || empty($_REQUEST['duration'])  || empty($_REQUEST['testdate']) ||(strcmp($_REQUEST['Subject'],'Choose the Subject')==0)) 

				{

					$_GLOBALS['message'] = "Some of the required Fields are Empty.Nothing is inserted.";

				} 

				else 

				{

					$data=@executeQuery("select max(testid) from test");

					$row=mysql_fetch_array($data);

					$query = "insert into test(`testid`, `testname`, `testdesc`, `testdate`,`subid`, `duration`, `totalquestions`)  values ($row[0]+1,'" . htmlspecialchars($_REQUEST['testname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['testdesc'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['testdate'], ENT_QUOTES) . "'," . htmlspecialchars($_REQUEST['subject'], ENT_QUOTES) . "," . htmlspecialchars($_REQUEST['duration'], ENT_QUOTES) . "," . htmlspecialchars($_REQUEST['totalqn'], ENT_QUOTES) .") ;";

					if (!@executeQuery($query)) 

					{

						if (mysql_errno () == 1062)

							$_GLOBALS['message'] = "Given Test Name voilates some constraints, please try with some other name.";

						else

							$_GLOBALS['message'] = mysql_error();

					}

					else

						$_GLOBALS['message'] = $_GLOBALS['message'] . "Successfully New Test is Created.";

			}

				closedb();

}





else if (isset($_REQUEST['savem'])) 

{

				if (empty($_REQUEST['testname']) || empty($_REQUEST['testdesc']) || empty($_REQUEST['totalqn']) || empty($_REQUEST['duration'])  || empty($_REQUEST['testdate']) ||(strcmp($_REQUEST['Subject'],'Choose the Subject')==0) ) 

				{

					$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";

				} 

				else 

				{

					$query = "update test set testname='" . htmlspecialchars($_REQUEST['testname'], ENT_QUOTES) . "',testdesc='" . htmlspecialchars($_REQUEST['testdesc'], ENT_QUOTES) . "',subid=" . htmlspecialchars($_REQUEST['subject'], ENT_QUOTES) . ",testdate='" . htmlspecialchars($_REQUEST['testdate'], ENT_QUOTES) . "',duration=" . htmlspecialchars($_REQUEST['duration'], ENT_QUOTES) . ",totalquestions=" . htmlspecialchars($_REQUEST['totalqn'], ENT_QUOTES) . " where testid=" . $_REQUEST['testid'] ;

					

					if (!@executeQuery($query))

						$_GLOBALS['message'] = mysql_error();

					else

						$_GLOBALS['message'] = "Test Information is Successfully Updated.";

				}

				closedb();

}



else if (isset($_REQUEST['delete'])) { 

				unset($_REQUEST['delete']);

				$hasvar = false;

				foreach ($_REQUEST as $variable) {

					if (is_numeric($variable)) { //it is because, some session values are also passed with request

						$hasvar = true;

			

						if (!@executeQuery("delete from test where testid=$variable")) {

							if (mysql_errno () == 1451) //Children are dependent value

								$_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this test, then first delete the questions that are associated with it.";

							else

								$_GLOBALS['message'] = mysql_errno();

						}

					}

				}

				if (!isset($_GLOBALS['message']) && $hasvar == true)

					$_GLOBALS['message'] = "Selected Tests are successfully Deleted";

				else if (!$hasvar) {

					$_GLOBALS['message'] = "First Select the Tests to be Deleted.";

				}

				closedb();

}

else if (isset($_REQUEST['manageqn'])) {

    $testname = $_REQUEST['manageqn'];

    $result = executeQuery("select testid from test where testname='" . htmlspecialchars($testname, ENT_QUOTES) . "';");



    if ($r = mysql_fetch_array($result)) {

        //  $_GLOBALS['message']=$_SESSION['testname'];

        header('Location: addQuestionsToTest.php?testname='.$testname.'&testqn='.$r['testid'].'&subid='.$_REQUEST['subid']);

    }

}







    

?>





<html>

    <head>

        <title>OES-Manage Tests</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <link rel="stylesheet" type="text/css" href="../oes.css"/>

        <link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />

        <script type="text/javascript" src="../validate.js" ></script>

		<script>

		$(document).ready(function(){

		   

        });

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

            <form name="testmng" id="testmng" action="managetest.php" method="post">

                <div class="menubar">

					<?php

					if($_GLOBALS['message']) 

					{

						echo "<span class=\"message\" style='float:left;width:50%;overflow:hidden;'>" . $_GLOBALS['message'] . "</span>";

					}

					?>

					<ul id="menu">

						<?php

						if (isset($_SESSION['admname'])) 

						{

						?>

							<li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>

							<li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>

						<?php

						}

    					if (isset($_REQUEST['newtest'])) 

						{

						?>

							<li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>

							<li><input type="submit" value="Save" name="savea" class="subbtn" title="Save the Changes"/></li>

						<?php

						}

						else if (isset($_REQUEST['edit'])) 

						{

						?>

                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>

                        <li><input type="submit" value="Save" name="savem" class="subbtn" title="Save the changes"/></li>

						<?php

						} 

						else 

						{  

						?>

							<li><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete"/></li>

							<li><input type="submit" id="newtest" value="New Test" name="newtest" class="subbtn" title="New Test"/></li>

						<?php

						}

						?>

					</ul>

				</div>

			<div class="page">

			<?php

  				if(isset($_REQUEST['newtest']))

				{

				?>

					  <table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >

						<tr>

						  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">New Test Description</th>

						</tr>

						<tr>

                            <td>

                                <select name="subject" style="font-size:18px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';background-image:url(images/input_bg.png);">

									<option selected value="Choose the Subject">&lt;Choose the Subject&gt;</option>

									

									<?php

											$result = executeQuery("select subid,subname from subject;");

											while ($r = mysql_fetch_array($result)) {

									

												echo "<option value=\"" . $r['subid'] . "\">" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</option>";

											}

											closedb();

									?>

                                </select>

                            </td>

                        </tr>

                        <tr>

                            <td><input type="text" name="testname" value="" placeHolder="Test Name" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);" /></td>

                            

                        </tr>

                        <tr>

                            <td><textarea name="testdesc" cols="31" rows="3" placeHolder="Test Description"  style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';" ></textarea></td>

                           

                        </tr>

                        <tr>

                            <td><input type="text" name="totalqn" value="" placeHolder="Total Questions" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);"  onKeyUp="isnum(this)" /></td>



                        </tr>

                        <tr>

                            <td><input type="text" name="duration" value="" placeHolder="Duration(Mins)" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);"  onKeyUp="isnum(this)" /></td>
                        </tr>

                        <tr>

                            <td><input type="text" id="testdate" name="testdate" value="" placeHolder="Test Date(YYYY-MM-DD)" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);" /></td>

                        </tr>
                        

					</table>

				

				<?php

				} 

				else if (isset($_REQUEST['edit'])) 

				{

								$result = executeQuery("select t.totalquestions,t.duration,t.testid,t.testname,t.testdesc,t.subid,s.subname,DATE_FORMAT(t.testdate,'%Y-%m-%d') as testdate from test as t,subject as s where t.subid=s.subid and t.testid='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");

								if (mysql_num_rows($result) == 0) 

								{

									header('Location: managetest.php');

								} 

								else if ($r = mysql_fetch_array($result)) 

								{

						

						?>

									<table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >

									<tr>

									  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">New Test Description</th>

									</tr>

									<tr>

										<td>

											<select name="subject" style="font-size:18px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';background-image:url(images/input_bg.png);">

											<option selected value="0">Miscellaneous</option>

												<?php

												$result = executeQuery("select subid,subname from subject;");

												while ($r1 = mysql_fetch_array($result)) 

												{

													if (strcmp($r['subname'], $r1['subname']) == 0)

														echo "<option value=\"" . $r1['subid'] . "\" selected>" . htmlspecialchars_decode($r1['subname'], ENT_QUOTES) . "</option>";

													else

														echo "<option value=\"" . $r1['subid'] . "\">" . htmlspecialchars_decode($r1['subname'], ENT_QUOTES) . "</option>";

												}

												closedb();

												?>

											</select>

										</td>

									</tr>

									<tr>

									<td><input type="hidden" name="testid" value="<?php echo $r['testid']; ?>"/>

										<input type="text" name="testname" value="<?php echo htmlspecialchars_decode($r['testname'], ENT_QUOTES); ?>" placeHolder="Test Name" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);" onKeyUp="isalphanum(this)" /></td>

										

									</tr>

									<tr>

										<td><textarea name="testdesc" cols="31" rows="3" placeHolder="Test Description"  style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';" ><?php echo htmlspecialchars_decode($r['testdesc'], ENT_QUOTES); ?></textarea></td>

									   

									</tr>

									<tr>

										<td><input type="text" name="totalqn" value="<?php echo htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES); ?>" placeHolder="Total Questions" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);"  onKeyUp="isnum(this)" /></td>

			

									</tr>

									<tr>

										<td><input type="text" name="duration" value="<?php echo htmlspecialchars_decode($r['duration'], ENT_QUOTES); ?>" placeHolder="Duration(Mins)" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);"  onKeyUp="isnum(this)" /></td>

			

									</tr>

									<tr>

										<td><input type="text" id="testdate" name="testdate" value="<?php echo $r['testdate']; ?>" placeHolder="Test Date(YYYY-MM-DD)" size="30" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png);" /></td>

									</tr>

								</table>										

										<?php

									closedb();

								}

				}				   

				else

				{

				 		$result = executeQuery("select * from test order by testdate desc");

                                if (mysql_num_rows($result) == 0) 

								{

                                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet..!</h3>";

                                } 

								else 

								{

                                    $i = 0;

?>

                                    <table cellpadding="30" cellspacing="10" class="datatable">

                                        <tr>

                                            <th>&nbsp;</th>

                                            <th>Test Name</th>

                                            <th>Subject Name</th>

                                            <th>Duration</th>

                                            <th>Date</th>

                                            <th>Edit</th>

                                            <th style="text-align:center;" >Manage<br/>Questions</th>

                                            <th style="text-align:center;" > Status </th>

                                        </tr>

<?php

                                    while ($r = mysql_fetch_array($result)) 

									{

                                        $i = $i + 1;

                                        if ($i % 2 == 0)

                                            echo "<tr class=\"alt\">";

                                        else

                                            echo "<tr>";

											

                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['testid'] . "\" /></td><td> " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . " : " . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES)."</td><td>";

										

										$innerresult=executequery("select subname from subject where subid='$r[subid]'");

										$in=mysql_fetch_array($innerresult);

										echo htmlspecialchars_decode($in['subname'], ENT_QUOTES) . "</td><td>" . $r['duration'] . "</td><td>". $r['testdate'] . "

										<td class=\"tddata\">  <a title=\"Edit " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"href=\"managetest.php?edit=" . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td>"

                                        . "<td class=\"tddata\"><a title=\"Manage Questions of " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"href=\"managetest.php?subid=".$r['subid']."&manageqn=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><img src=\"../images/mngqn.png\" height=\"30\" width=\"40\" alt=\"Manage Questions\" /></a></td>";

                                                                                if($r['status'] == 0) {

                                                                                    echo "<td class=\"tddata\" style='color:red;' > Not Launched </td>";

                                                                                }

                                                                                else

                                                                                {

                                                                                    echo "<td class=\"tddata\" style='color:green;' > Launched </td>";

                                                                                }

                                                                                echo "</tr>";

 									}

									echo "</table>";

								}

                        

				}

?>

			</form>

			</div>

		</div>

	</body>

</html>						