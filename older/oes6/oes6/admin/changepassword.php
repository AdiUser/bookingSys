<?php

error_reporting(0);

session_start();

include_once '../oesdb.php';

	

	

	if (!isset($_SESSION['admname'])) {

	header("Location:$PATH_ADMIN");

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

				

			/*/	else if(strlen($_REQUEST['password'])<8)

				{

				//	 $_GLOBALS['message']="Password length should be greater than 8..";

				}

				*/

				else

				{

				$result=executeQuery("select * from adminlogin where admname='".$_SESSION['admname']."'");

				if(mysql_num_rows($result)>0)

				  { 

					  $r=mysql_fetch_array($result);

					  if(strcmp($r['admpassword'],md5(htmlspecialchars($_REQUEST['oldpass'],ENT_QUOTES)))==0)

					  {

					  			$query="update adminlogin set admpassword=md5('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."') where admname='".$_SESSION['admname']."'";

								 if(!@executeQuery($query))

									$_GLOBALS['message']=mysql_error();

								 else

								 {

									$_GLOBALS['message']="Your Password is Successfully Updated.";

								 	header("Location: admwelcome.php");

								 }

					  }

					else

					  {

						 $_GLOBALS['message']="You entered wrong password.";

							 

					  }

				 }	  

			    }	 

						

    closedb();



   }





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"

    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

  <head>

    <title>OES-Change Password</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>

  <body class='default' style="height:100%; margin-top:-30px;">

      <div id="container">

      <div class="header">

       <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="100" src="../images/logo.png" alt="OES"/>

		<div>

				<h3 class="headtext">GEU Online Examination System </h3>

				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Transforming Dreams into Reality</i></h4>

		</div>  

	  </div>

         <form id="changepassword" action="changepassword.php" method="post">

          <div class="menubar" >

               <ul id="menu" style="float:right;margin-top:0px;" style=' height:2em; width:30%;'>

                        <?php if(isset($_SESSION['admname'])) {

                         // Navigations

                         ?>

						<li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>

                        <li><a href="admwelcome.php"><input type="button" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></a></li>

               </ul> 

			   <?php

				if($_GLOBALS['message']) {

					echo "<div class=\"message\" style='width:70%;'>".$_GLOBALS['message']."</div>";

				}

				?>

			

          </div>

      <div class="page">

            

			<table>

              <tr>

                  <td><input type="text" placeholder="Username" disabled="disabled" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "tabindex="1" name="name" value="<?php echo $_SESSION['admname']; ?>" size="30" /></td>

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

                      <input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('changepassword')" title="Save the changes"/>

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