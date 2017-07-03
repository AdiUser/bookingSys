<?php
error_reporting(0);
session_start();
include_once 'oesdb.php';
	if(!isset($_SESSION['stdname'])) {
		$_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
	}
	else if(isset($_REQUEST['logout']))
	{
		//Log out
		unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.<form name=\"relogin\" action=\"index.php\" method=\"post\">
                    <input type=\"submit\" value=\"Log In\" name=\"login_but\" class=\"subbtn\" href=\"index.php\" style=\"margin-top:-35px; float:right;\"  /> </form>";
            echo "<script>window.close(this);</script>";
	}
	else if(isset($_REQUEST['dashboard'])){
      //redirect to dashboard
     header('Location: stdwelcome.php');
    }
	else if(isset($_REQUEST['savem']))
	{
				  /************************** Step 2 - Case 3 *************************/
							//updating the modified values
				if(empty($_REQUEST['repass'])||empty ($_REQUEST['password'])||empty ($_REQUEST['oldpass']))
				{
					 $_GLOBALS['message']="Some of the required Fields are Empty.";
				}
				
				else if($_REQUEST['password'] != $_REQUEST['repass'])
				{
					 $_GLOBALS['message']="Your passwords Do not Match..";
				}
				
				else if(strlen($_REQUEST['password'])<4)
				{
					 $_GLOBALS['message']="Password length should be greater than equal to 4..";
				}
				else
				{
				$qry="select stdid from student where stdname='".htmlspecialchars($_SESSION['stdname'],ENT_QUOTES)."' and stdpassword=md5('".htmlspecialchars($_REQUEST['oldpass'],ENT_QUOTES)."')";
				
				$result=executeQuery($qry);
				  if(mysql_num_rows($result)>0)
				  {
					  $r=mysql_fetch_array($result);
					
					  
								$query="update student set stdpassword=md5('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."') where stdid=$r[0]";
								 if(!@executeQuery($query))
									$_GLOBALS['message']=mysql_error();
								 else
								 {
									$_GLOBALS['message']="Your Profile is Successfully Updated.";
								 	//header("Location: stdwelcome.php");
								 }
					  
					  
				 }
				 else
						{
						   $_GLOBALS['message']="Authentication Failed. Wrong Password.";
						}
				}	 
						
    closedb();

   }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Edit Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
 <body class='default' style="height:100%; margin-top:-30px;">
      <div id="container">
      <div class="header">
       <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
		<div>
				<h3 class="headtext"> Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
		</div>  
	  </div>
         <form id="editprofile" action="editprofile.php" method="post">
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
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
               </ul>
          </div>
      <div class="page">
            
			<table>
              <tr>
                  <td><input type="text" placeholder="Username" disabled="disabled" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "tabindex="1" name="name" value="<?php echo $_SESSION['stdname']; ?>" size="30" /></td>
              </tr>
			  <tr>    
				  <td><input type="password" placeholder="Old Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " tabindex="2" name="oldpass" value="" size="30" onkeyup="isalphanum(this)"/></td>
              </tr>
			  
			  <tr>    
				  <td><input type="password" placeholder="New Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " tabindex="2" name="password" value="" size="30" onkeyup="isalphanum(this)" /></td>
              </tr>
			  <br />
			  <tr>    
				  <td><input type="password" placeholder="Re-type Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " tabindex="2" name="repass" value="" size="30" onkeyup="isalphanum(this)"/></td>
              </tr>
			  <tr>    
				  <td >
                      <input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes"/>
				  </td>
              </tr>
            </table>
		</div>
      </form>
	  <?php
	  } 
	  ?>
	  
      <div id="footer">
        
      </div>
      </div>
  </body>
</html>