

<?php
error_reporting(0);
session_start();
include_once 'oesdb.php';

if(isset($_REQUEST['stdsubmit']))
{
 /***************************** Step 1 : Case 1 ****************************/
 //Add the new user information in the database
     $result=executeQuery("select max(stdid) as std from student");
     $r=mysql_fetch_array($result);
     if(is_null($r['std']))
     $newstd=1;
     else
     $newstd=$r['std']+1;

     $result=executeQuery("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

    // $_GLOBALS['message']=$newstd;
    if(empty($_REQUEST['cname'])||empty ($_REQUEST['password']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty";
    }else if(mysql_num_rows($result)>0)
    {
        $_GLOBALS['message']="Sorry the User Name is Not Available Try with Some Other name.";
    }
    else
    {
     $query="insert into student(stdid,stdname,stdpassword) values($newstd,'".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'))";
     if(!@executeQuery($query))
                $_GLOBALS['message']=mysql_error();
     else
     {
        $success=true;
        $_GLOBALS['message']="Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
       // header('Location: index.php');
     }
    }
    closedb();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Registration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
  <body >
       <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
      <div id="container">
     <div class="header">
                <h3 class="headtext"> &nbsp;Raman Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
            </div>
          <div class="menubar">
              <?php if(!$success): ?>

              <h2 style="text-align:center;color:#ffffff;">New User Registration</h2>
              <?php endif; ?>
             
          </div>
      <div class="page">
          <?php
          if($success)
          {
                echo "<h2 style=\"text-align:center;color:#0000ff;\">Thank You For Registering with Online Examination System.<br/><a href=\"index.php\">Login Now</a></h2>";
          }
          else
          {
           /***************************** Step 2 ****************************/
          ?>
          <form id="admloginform"  action="register.php" method="post" onsubmit="return validateform('admloginform');">
                   <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
              <tr>
                  <td>User Name</td>
                  <td><input type="text" name="cname" value="" size="16" onkeyup="isalphanum(this)"/></td>

              </tr>

                      <tr>
                  <td>Password</td>
                  <td><input type="password" name="password" value="" size="16" onkeyup="isalphanum(this)" /></td>

              </tr>
                      <tr>
                  <td>Re-type Password</td>
                  <td><input type="password" name="repass" value="" size="16" onkeyup="isalphanum(this)" /></td>

              </tr>
              

                 
                       <tr>
                           <td style="text-align:right;"><input type="submit" name="stdsubmit" value="Register" class="subbtn" /></td>
                  <td><input type="reset" name="reset" value="Reset" class="subbtn"/></td>
              </tr>
            </table>
        </form>
       <?php } ?>
      </div>

<div id="footer">
        
      </div>
      </div>
  </body>
</html>

