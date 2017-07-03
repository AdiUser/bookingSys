<?php
      error_reporting(0);
      session_start();
      include_once 'oesdb.php';
    if(isset($_REQUEST['stdsubmitreg']))
      {
		 $result=executeQuery("select max(stdid) as std from student");
		 $r=mysql_fetch_array($result);
		 if(is_null($r['std']))
		   $newstd=1;
		 else
		   $newstd=$r['std']+1;
		   $result=executeQuery("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");
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
			else if(strlen($_REQUEST['password'])<4)
			{
				 $_GLOBALS['message']="Password length should be greater than or equal to 4..";
			}
			else if(mysql_num_rows($result)>0)
			{
				$_GLOBALS['message']="Sorry the User Name is Not Available..Try with Some Other name..";
			}
			else
			{
				 $query="insert into student(stdid,stdname,stdpassword,batch) values($newstd,'".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',md5('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."'),'$_REQUEST[cbatch]')";
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
   else if($_REQUEST['stdsubmit'])
      {
 //Perform Authentication
          $result=executeQuery("select * from student where stdpassword=md5('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."') and stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."'");
          if(mysql_num_rows($result)>0)
          {
				$r=mysql_fetch_array($result);
                  $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
                  $_SESSION['stdid']=$r['stdid'];
                  unset($_GLOBALS['message']);
                  header('Location: redirect.php');
                  $_SESSION['w_no']=0;
              
		 }
         else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
          }
          
      }
 ?>
 
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Welcome</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="validate.js" ></script>
        <link rel="stylesheet" type="text/css" href="oes.css"/>
	<script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>
	<script src="lib/ui/jquery.ui.effect.js"></script>
	<script src="lib/ui/jquery.ui.effect-explode.js"></script>
	<script>
	// run the currently selected effect
		
	function runEffect() {
			var selectedEffect = 'explode';
			var options = {};
			// run the effect
			$( "#popup" ).css("background-color","black");
			$( "#overlay" ).show('explode', options,500);
			$( "#card" ).show('explode', options, 500 );
			$( "#popup" ).show('explode', options,500);
			
		}
	
	function hide_contact()
	{
		var selectedEffect = 'explode';
				var options = {};
				$( "#card" ).effect( selectedEffect, options, 500 );
				$( "#popup" ).effect( selectedEffect, options, 500 );
				$( "#overlay" ).effect( selectedEffect, options, 500 );
	}
	</script>
  </head>
  <body class='default' style="position:fixed;top:0px;bottom:0px;left:0px;right:0px;">
  <div id="container">
      <div class="header">
		<img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
			<div style=" float:right; width:420px; margin-top:50px;">
		     <form id="stdloginform" action="index.php" method="post">
			 <table>
              <tr>
                  <td><input type="text" placeholder="Username" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); "tabindex="1" name="name" value="" size="16" onkeyup="isalphanum(this)" /></td>
                  <td><input type="password" placeholder="Password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; height:30px; background-image:url(images/input_bg.png); " tabindex="2" name="password" value="" size="16" onkeyup="isalphanum(this)"/></td>
                  <td >
                      <input type="submit" tabindex="3" value="Log In" name="stdsubmit" class="subbtn"  />
                  </td>
              </tr>
            </table>
       </form>
	</div>
				<div>
				<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
				</div>
</div>
      <div class="menubar">
       
         <?php

        if($_GLOBALS['message']) {
            echo "<div style=\" margin-right:0px;\" class=\"message\"> <b>".$_GLOBALS['message']."</b></div>";
        }
        ?>
       <ul id="menu">
	   
                    <?php if(isset($_SESSION['stdname'])){
                          header('Location: redirect.php');
                          }
                          else{  
                          /***************************** Step 2 ****************************/
                        ?>

                      <!--  <li><input type="submit" value="Register" name="register" class="subbtn" title="Register"/></li>-->
                        <?php } ?>
                    </ul>

      </div>
      <div class="page">
	  
       <div>
			  
	   <?php
          if($success)
          {
                echo "<h2 style=\"text-align:center;color:#0000ff;\">Thank You For Registering...<br/><a href=\"index.php\">Login Now</a></h2>";
          }
          else
          {
              $r2=executeQuery("SELECT * FROM  `sett` WHERE  `key` =  'stu_reg'");
                $row=mysql_fetch_array($r2);
				
                if($row[1] == 1)
                {					$r3=executeQuery("SELECT flag FROM  `sett` WHERE  `key` =  'batch'");					$row2=mysql_fetch_array($r3);
         ?>
		  <form id="admloginform"  action="index.php" method="post" onsubmit="return validateform('admloginform');" style="float:right;width:25%;" >
           <table cellpadding="2" cellspacing="2" style="text-align:left;" >
			  <tr>
                  <td><h2 style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; " align="center"><b>New User?</b></h2></td>
              </tr>			  			  <tr>                  <td><input type="text" name="cbatch" readonly value="<?php echo $row2[0]; ?>"  style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';  height:30px; background-image:url(images/input_bg.png); "  size="36" /></td>              </tr>
			  <tr>
                  <td><input type="text" name="cname" placeholder="Username" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';  height:30px; background-image:url(images/input_bg.png); " value="" size="36" onkeyup="isalphanum(this)"/></td>
              </tr>
              <tr>
                  <td><input type="password" placeholder="Password" name="password" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';  height:30px; background-image:url(images/input_bg.png); " value="" size="36" onkeyup="isalphanum(this)" /></td>
              </tr>
              <tr>
                  <td><input type="password" placeholder="Re-type Password" name="repass" style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';  height:30px; background-image:url(images/input_bg.png); " value="" size="36" onkeyup="isalphanum(this)" /></td>
              </tr>
              <tr>
                  <td style="text-align:right;">
				  <input type="submit" name="stdsubmitreg" value="Register" class="subbtn" />
                  <input type="reset" name="reset" value="Reset" class="subbtn"/>
				  </td>
             </tr>
            </table>
        </form>
		
       <?php 
                }
				if(true)
				{
					$r3=executeQuery("SELECT `metadata` FROM `sett` WHERE `key`='notice'");
					$row=mysql_fetch_array($r3);
				?>
				<div style="float:right;width:25%;height:250px;border:1px solid;margin-top:5px; text-align:center;padding:5px;clear:none;" >
					<div style="color:blue;font-size:16px;text-decoration:underline;font-weight:bold;" >NOTICE and UPDATES</div>
					<marquee  behavior="scroll" direction="up" scrollamount="2" style="color:red;text-weight:bold;margin-top:2%;font-size:20px; height:220px; text-align:center;" onmouseover="this.stop();" onmouseout="this.start();">
						<?php echo nl2br($row[0]); ?>
					</marquee>
				</div>
				<?php
				}
       } 
       closedb();
       ?>
  </div> <div style="width:30%;"><img src="images/slider_photo1.jpg" width="162%" /></div>
	<div style='text-align:center;padding:15px;' > <table style='background-color:inherit;' ><tr><td style='font-size:25px;font-weight:bold;' >USE ONLY</td> <td><img src='images/ch2.png' width='60px'  > </td></tr></table></div>
 
	</div>
	  
      </div>
<div id="overlay" hidden="hidden"></div>
	
<div id="popup" style=" border-radius:20px; top:10%;background-color:black;" hidden="hidden">
	<img src="images/close.png" id="hidethis"  onclick="hide_contact();" style="position:absolute;z-index: 999;float:right;cursor:pointer;border-radius:20px; width:30px; height:30px;" />
        <img id='card' src="images/contact_card.jpg" hidden="hidden" style="border-radius:20px;z-index: 998;width:100%; height:100%; " />
</div>		

	  
     
	 
	 <div id="footer">
               <span style="color:#0000FF">&reg;All rights Reserved For BRISNGER.</span><input type="button" id="newwindow" value="Contact Us" onClick="runEffect();"/>
	 </div>
	
  </body>
<script>
    $(document).ready(function(){
        $( "#card" ).hide();
        $( "#popup" ).hide();
	$( "#overlay" ).hide();
   });
</script>

</html>				