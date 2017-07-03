<?php

error_reporting(0);

session_start();

include_once '../oesdb.php';



if (!isset($_SESSION['admname'])) {

	header("Location:$PATH_ADMIN");

	} 

 else if (isset($_REQUEST['logout'])) {

    header('Location: logout.php');

} else if (isset($_REQUEST['dashboard'])) {

    header('Location: admwelcome.php');

} else if (isset($_REQUEST['delete'])) {

    //deleting the selected users

    unset($_REQUEST['delete']);

    $hasvar = false;

    foreach ($_REQUEST as $variable) {

        if (is_numeric($variable)) { //it is because, some sessin values are also passed with request

            $hasvar = true;

            if (!@executeQuery("delete from student where stdid=$variable")) {

                if (mysql_errno () == 1451) //Children are dependent value

                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this user, then first manually delete all the records that are associated with this user.";

                else

                    $_GLOBALS['message'] = mysql_errno();

            }

        }

    }

    if (!isset($_GLOBALS['message']) && $hasvar == true)

        $_GLOBALS['message'] = "Selected User/s are successfully Deleted";

    else if (!$hasvar) {

        $_GLOBALS['message'] = "First Select the users to be Deleted.";

    }

} else if (isset($_REQUEST['savem'])) {

    /*     * ************************ Step 2 - Case 4 ************************ */

    //updating the modified values

    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) ) {

        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";

    } else {

        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password']) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . htmlspecialchars($_REQUEST['student'], ENT_QUOTES) . "';";

        if (!@executeQuery($query))

            $_GLOBALS['message'] = mysql_error();

        else

            $_GLOBALS['message'] = "User Information is Successfully Updated.";

    }

    closedb();

}

else if (isset($_REQUEST['savea'])) {

    /*     * ************************ Step 2 - Case 5 ************************ */

    //Add the new user information in the database

    $result = executeQuery("select max(stdid) as std from student");

    $r = mysql_fetch_array($result);

    if (is_null($r['std']))

        $newstd = 1;

    else

        $newstd=$r['std'] + 1;



    $result = executeQuery("select stdname as std from student where stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "';");





    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) ) {

        $_GLOBALS['message'] = "Some of the required Fields are Empty";

    } else if (mysql_num_rows($result) > 0) {

        $_GLOBALS['message'] = "Sorry User Already Exists.";

    } else {

        $query = "insert into student(stdid,stdname,stdpassword) values(DEFAULT,'" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "',md5('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "'))";

        if (!@executeQuery($query)) {

            if (mysql_errno () == 1062) //duplicate value

                $_GLOBALS['message'] = "Given User Name voilates some constraints, please try with some other name.";

            else

                $_GLOBALS['message'] = $query."              ".mysql_error();

        }

        else

            $_GLOBALS['message'] = "Successfully New User is Created.";

    }

    closedb();

}

?>

<html>

    <head>

        <title>OES-Manage Users</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <link rel="stylesheet" type="text/css" href="../oes.css"/>

        <script type="text/javascript" src="../validate.js" ></script>

    </head>

    <body>

        <div id="container">

            <div class="header">

               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="100" src="../images/logo.png" alt="OES"/>

				<div>

						<h3 class="headtext"> &nbsp;GEU Online Examination System </h3>

						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Transforming Dreams into Reality</i></h4>

				</div>

            </div>

            <form name="usermng" action="usermng.php" method="post">

                <div class="menubar">



<?php

if (isset($_GLOBALS['message'])) {

    echo "<span class=\"message\" style='float:left;width:50%;'>" . $_GLOBALS['message'] . "</span>";

}

?>



                    <ul id="menu">

<?php

if (isset($_SESSION['admname'])) {

// Navigations

?>

                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>

                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>

						<?php

    //navigation for Add option

    if (isset($_REQUEST['add'])) {

?>

                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>

                        <li><input type="submit" value="Save" name="savea" class="subbtn" onClick="validateform('usermng')" title="Save the Changes"/></li>



<?php

    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option

?>

                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>

                        <li><input type="submit" value="Save" name="savem" class="subbtn" onClick="validateform('usermng')" title="Save the changes"/></li>



<?php

    } else {  //navigation for Default

?>

                        <li><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete"/></li>

                        <li><input type="submit" value="Add" name="add" class="subbtn" title="Add"/></li>

<?php }

} ?>

                    </ul>



                </div>

                <div class="page">

<?php

if (isset($_SESSION['admname'])) {

    echo "<div class=\"pmsg\" style=\"text-align:center;\">Students Management </div>";

    if (isset($_REQUEST['add'])) {

        /*         * ************************ Step 3 - Case 1 ************************ */

        //Form for the new user

?>

                    <table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >

						<tr>

						  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Add New User</th>

						</tr>

                        <tr>

                            <td><input type="text" placeholder="User Name" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " name="cname" value="" size="24" onKeyUp="isalphanum(this)"/></td>



                        </tr>



                        <tr>

                            <td><input type="password"  placeholder="Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "name="password" value="" size="24" onKeyUp="isalphanum(this)" /></td>



                        </tr>

                        <tr>

                            <td><input type="password" placeholder="Re-type Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " name="repass" value="" size="24" onKeyUp="isalphanum(this)" /></td>



                        </tr>

                        

                    </table>



<?php

    } else if (isset($_REQUEST['edit'])) {

        /*         * ************************ Step 3 - Case 2 ************************ */

        // To allow Editing Existing User Information

        $result = executeQuery("select stdid,stdname,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");

        if (mysql_num_rows($result) == 0) {

            header('Location: usermng.php');

        } else if ($r = mysql_fetch_array($result)) {



            //editing components

?>

                    <table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >

						<tr>

						  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Edit User Information</th>

						</tr>

                            <tr>

                            <td><input type="text" placeholder="User Name" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?>" size="30" onKeyUp="isalphanum(this)"/></td>



                        </tr>



                        <tr>

                            <td><input type="text" placeholder="Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "type="text" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'], ENT_QUOTES); ?>" size="30" onKeyUp="isalphanum(this)" /></td>



                        </tr>



                        <tr>

                            <td><input type="text" placeholder="E-mail ID" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'], ENT_QUOTES); ?>" size="30" /></td>

                        </tr>

                        <tr>

                            <td><input type="text" placeholder="Contact No" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'], ENT_QUOTES); ?>" size="30" onKeyUp="isnum(this)"/></td>

                        </tr>

						 <tr>

                            <td><textarea name="address" placeholder="Address" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; background-image:url(images/input_bg.png) repeat;" cols="31" rows="3"><?php echo htmlspecialchars_decode($r['address'], ENT_QUOTES); ?></textarea></td>

                        </tr>



                        <tr>

                            <td><input type="text" placeholder="City" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'], ENT_QUOTES); ?>" size="30" onKeyUp="isalpha(this)"/></td>

                        </tr>

                        <tr>

                            <td><input type="text" placeholder="PIN Code" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " value="<?php echo $r['pincode']; ?>" size="30" onKeyUp="isnum(this)" />

							</td>

						</tr>

						<tr>

						   <td><input type="hidden" name="student" value="<?php echo htmlspecialchars_decode($r['stdid'], ENT_QUOTES);?>"/>

							</td>

						</tr>



                    </table>

<?php

                    closedb();

                }

            } else {

                /*                 * ************************ Step 3 - Case 3 ************************ */

                // Defualt Mode: Displays the Existing Users, If any.

                $result = executeQuery("select * from student where batch=(select flag from sett where `key`='batch') order by average_percentage DESC");

                if (mysql_num_rows($result) == 0) {

                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Users Yet..!</h3>";

                } else {

                    $i = 0;

?>

                    <table cellpadding="30" cellspacing="10" align="center" class="datatable" >

                        <tr >

                            <th style="text-align:center;"></th>

							<th style="text-align:center;">Rank</th>

                            <th style="text-align:center;">User Name</th>

                            <th style="text-align:center;">Average % </th>

							<th style="text-align:center;">Performance & Statistics</th>

                            <th style="text-align:center;">Edit</th>

                        </tr>

<?php

                    while ($r = mysql_fetch_array($result)) {

                        $i = $i + 1;

                        

						

						

                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['stdid'] . "\" /></td><td style=\"text-align:center;\">$i</td><td>" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES). "</td><td>" . htmlspecialchars_decode($r['average_percentage'], ENT_QUOTES) . "</td>

						<td class=\"tddata\">

							<a title=\"Statistics\" href='userGraph.php?sid=$r[0]'>

								<img src=\"../images/statistics.png\" height=\"30\" width=\"40\" alt=\"Statistics\" /> 

							</a>

						</td>"

                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"usermng.php?edit=" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";

                    }

?>

                    </table>

<?php

                }

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

