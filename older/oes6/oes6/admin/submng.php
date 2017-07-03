
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
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from subject where subid=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this subject, then first delete the tests that are conducted/dependent on this subject.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Subject/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the subject/s to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update subject set subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "', subdesc='" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'where subid=" . $_REQUEST['subject'] . ";";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Subject Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new Subject information in the database
    $result = executeQuery("select max(subid) as sub from subject");
    $r = mysql_fetch_array($result);
    if (is_null($r['sub']))
        $newstd = 1;
    else
        $newstd=$r['sub'] + 1;

    $result = executeQuery("select subname as sub from subject where subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "';");
    // $_GLOBALS['message']=$newstd;
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry Subject Already Exists.";
    } else {
        $query = "insert into subject values($newstd,'" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "',NULL)";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given Subject Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error();
        }
        else
            $_GLOBALS['message'] = "Successfully New Subject is Created.";
    }
    closedb();
}
?>
<html>
    <head>
        <title>OES-Manage Subjects</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
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
            <form name="submng" action="submng.php" method="post">
                <div class="menubar">

<?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
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
                        <li><input type="submit" value="Save" name="savea" class="subbtn" onClick="validatesubform('submng')" title="Save the Changes"/></li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onClick="validatesubform('submng')" title="Save the changes"/></li>

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

    if (isset($_REQUEST['add'])) {

?>
                    <table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >
						<tr>
						  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Add New Subject</th>
						</tr>
						<tr>
                            <td><input type="text" placeholder="Subject Name" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " name="subname" value="" size="30" onKeyUp="isalphanum(this)" onBlur="if(this.value==''){alert('Subject Name is Empty');this.focus();this.value='';}"/></td>

                        </tr>

                        <tr>
                            <td><textarea name="subdesc" placeholder="Subject Description" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';" cols="31" rows="3" onBlur="if(this.value==''){alert('Subject Description is Empty');this.focus();this.value='';}"></textarea></td>
                        </tr>

                    </table>

<?php
    } else if (isset($_REQUEST['edit'])) {

        /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing Subject.
        $result = executeQuery("select subid,subname,subdesc from subject where subname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
        if (mysql_num_rows($result) == 0) {
            header('submng.php');
        } else if ($r = mysql_fetch_array($result)) {


            //editing components
?>
                    <table cellpadding="" cellspacing="" align="center" style="text-align:left;margin-left:35%; padding:20px 100px;" >
						<tr>
						  <th align="center" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; ">Edit Subject Information</th>
						</tr>
						 <tr>
                            <td><input type="text" placeholder="Subject Name" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " name="subname" value="<?php echo htmlspecialchars_decode($r['subname'], ENT_QUOTES); ?>" size="30" onKeyUp="isalphanum(this)" onBlur="if(this.value==''){alert('Subject Name is Empty');this.focus();this.value='';}"/></td>

                        </tr>

                        <tr>
                            <td><textarea name="subdesc" placeholder="Subject Description" style="font-size:20px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';" cols="31" rows="3" onBlur="if(this.value==''){alert('Subject Description is Empty');this.focus();this.value='';}"><?php echo htmlspecialchars_decode($r['subdesc'], ENT_QUOTES); ?></textarea></td>
                        </tr>
                        
                    </table>
<?php
                    closedb();
                }
            } else {
                $result = executeQuery("select * from subject order by subid;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Subjets Yet..!</h3>";
                } else {
                    $i = 0;
?>
                    <table cellpadding="" cellspacing="" class="datatable">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Subject Name</th>
                            <th>Subject Description</th>
                            <th>Edit</th>
                        </tr>
<?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0) {
                            echo "<tr class=\"alt\">";
                        } else {
                            echo "<tr>";
                        }
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['subid'] . "\" /></td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['subdesc'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"submng.php?edit=" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
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

