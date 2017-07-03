 <?php

      error_reporting(0);

      session_start();

      include_once '../oesdb.php';





if (isset($_SESSION['admname'])) {

	header("Location: admwelcome.php");

	} 

if(isset($_REQUEST['admsubmitreg']))

      {

		   $result=executeQuery("select admname as adm from adminlogin where admname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

			// $_GLOBALS['message']=$newstd;

			if(empty($_REQUEST['cname'])||empty ($_REQUEST['password']) ||empty ($_REQUEST['repass']))

			{

				 $_GLOBALS['message']="Some of the required Fields are Empty";

			}

			else if($_REQUEST['password'] != $_REQUEST['repass'])

			{

				 $_GLOBALS['message']="Your passwords Do not Match..";

			}

			else if(strlen($_REQUEST['cname']) <4)

			{

				 $_GLOBALS['message']="Username length is not sufficient..";

			}

			/*

			else if(strlen($_REQUEST['password'])<8)

			{

				 $_GLOBALS['message']="Password length should be greater than 8..";

			}

			*/

			else if(mysql_num_rows($result)>0)

			{

				$_GLOBALS['message']="Sorry the User Name is Not Available..Try with Some Other name..";

			}

			else

			{

				 $query="insert into adminlogin(admname,admpassword) values('".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',md5('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."'))";

					 if(!@executeQuery($query))

								$_GLOBALS['message']=mysql_error();

					 else

					 {

						$success=true;

						$_GLOBALS['message']="Your Account is Successfully Created.You can Login Now..";

					   // header('Location: index.php');

					 }

 			}

     closedb();

     }











      /***************************** Step 2 ****************************/

      if(isset($_REQUEST['admsubmit']))

      {

          $result=executeQuery("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES))."'");

        

         // $result=mysql_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");

          if(mysql_num_rows($result)>0)

          {

              

              $r=mysql_fetch_array($result);

              if(strcmp($r['admpassword'],md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)

              {

                  $_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);

                  unset($_GLOBALS['message']);

                  header('Location: admwelcome.php');

              }

		else

          {

             $_GLOBALS['message']="Check Your user name and Password.";

                 

          }



          }

          else

          {

              $_GLOBALS['message']="Check Your user name and Password.";

              

          }

          closedb();

      }

 ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"

    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

	<head>

		<title>Administrator Login</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

		<link rel="stylesheet" type="text/css" href="../oes.css"/>

			<script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>

			<script src="../lib/ui/jquery.ui.effect.js"></script>

			<script src="../lib/ui/jquery.ui.effect-explode.js"></script>

                       <script>

                             var i = 0; var path = new Array(); 



                               // LIST OF IMAGES 

                               path[0] = "slider_photo1.jpg"; 

                               path[1] = "slider_photo2.jpg"; 

                               path[2] = "slider_photo3.gif"; 

                               path[3] = "slider_photo4.jpg";



                               function swapImage() 

                               { 

                                  document.slide.src = path[i]; 

                                  if(i < path.length - 1) 

                                     i++; 

                                  else 

                                      i = 0; 

                                  setTimeout("swapImage()",300); 

                               } 



                       </script>

	</head>

  <body onload='swapImage()'; class='default' style="position:fixed;top:0px;bottom:0px;left:0px;right:0px; ">

      <div id="container">

               <div class="header">

			   <div style=" float:right; width:420px; margin-top:50px;">

		     <form id="indexform" action="index.php" method="post">

			 <table>

              <tr>

                  <td><input type="text" placeholder="Admin UserName" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "tabindex="1" name="name" value="" size="18" onkeyup="isalphanum(this)" /></td>

                  <td><input type="password" placeholder="Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " tabindex="2" name="password" value="" size="14" onkeyup="isalphanum(this)"/></td>

                  <td >

                      <input type="submit" tabindex="3" value="Log In" name="admsubmit" class="subbtn"  />

                  </td>

              </tr>

            </table>

       </form>

	</div>

               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="../images/logo.gif" alt="OES"/>

				<div>

						<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>

						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>

				</div>

            </div>

	  <div class="menubar">

	        <?php      

				if(isset($_GLOBALS['message']))

				{

				 echo "<div class=\"message\">".$_GLOBALS['message']."</div>";

				}

			  ?>



      </div>

      <div class="page">

      

  <div style="width:100%; text-align:center;"><img id='slide_show' src="../images/slider_photo1.jpg" /></div>

	<div style='text-align:center;padding:15px;' > <table style='background-color:inherit;' ><tr><td style='font-size:25px;font-weight:bold;' >FOR BETTER PERFORMANCE USE </td> <td><img src='../images/ch2.png' width='60px'  > </td></tr></table></div>

</div>

	  

<div id="overlay" hidden="hidden"></div>

	

<div id="popup" style=" border-radius:20px; top:10%;background-color:black;" hidden="hidden">

	<img src="../images/close.png" id="hidethis"  onclick="hide_contact();" style="position:absolute;z-index: 999;float:right;cursor:pointer;border-radius:20px; width:30px; height:30px;" />

        <img id='card' src="../images/contact_card.jpg" hidden="hidden" style="border-radius:20px;z-index: 998;width:100%; height:100%; " />

</div>		



	  

     

	 

	 <div id="footer">

      <span style="color:#0000FF">&reg;All rights Reserved For BRISNGER.</span><input type="button" id="newwindow" value="Contact Us" />

	 </div>

<script>



   $(document).ready(function(){

        $( "#card" ).hide();

        $( "#popup" ).hide();

	$( "#overlay" ).hide();



   

                

	$(function() {

		// run the currently selected effect

		function runEffect() {

			var selectedEffect = 'explode';

			var options = {};

			// run the effect

			$( "#popup" ).css("background-color","black");

			$( "#overlay" ).show('explode', options,500);

			$( "#card" ).show('explode', options, 500 );

			$( "#popup" ).show('explode', options,500);

			

		};



		// set effect from select menu value

		$( "#newwindow" ).click(function() {

			runEffect();

			return false;

		});

		

		$( "#hidethis" ).click(function() {

				var selectedEffect = 'explode';

				var options = {};

				$( "#card" ).effect( selectedEffect, options, 500 );

				$( "#popup" ).effect( selectedEffect, options, 500 );

				$( "#overlay" ).effect( selectedEffect, options, 500 );

			return false;

		});

	});


});
		</script>

  </body>



</html>

		