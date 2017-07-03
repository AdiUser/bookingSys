

<?php

error_reporting(0);
session_start();

        if(!isset($_SESSION['stdname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
                session_destroy();
                
            $_GLOBALS['message']="You are Loggged Out Successfully.<form name=\"relogin\" action=\"index.php\" method=\"post\">
                    <input type=\"submit\" value=\"Log In\" name=\"login_but\" class=\"subbtn\" href=\"index.php\" style=\"margin-top:-35px; float:right;\"  /> </form>";
            
             echo "<script>window.location='index.php'</script>";
			
            
        }
?>
<html>
    <head>
        <title>OES-DashBoard</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="oes.css"/>
        
        <script type="text/javascript" src="lib/gettheme.js"></script>
        <link rel="stylesheet" href="lib/jqwidgets/styles/jqx.base.css" type="text/css" />
        <script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="lib/jqwidgets/jqxcore.js"></script>
         <script type="text/javascript" src="lib/jqwidgets/jqxbuttons.js"></script>

    </head>
 
    <body>
        <script type="text/javascript">
            $(document).ready(function () {
                var theme = getDemoTheme();

                // Create a jqxToggleButton widget.
                $(".jqxButton").jqxLinkButton({ width: '300', height: '50', theme: theme });
                
            });
        </script>

     <div id="container">
      <div class="header">
	  	<img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
		<div>
				<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
		</div>
	  </div>
	</div>
        
            <div class="menubar">
			<?php
			if($_GLOBALS['message']) {
				echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
			}
			?>

                <form name="stdwelcome" action="stdwelcome.php" method="post">
                    <ul id="menu">
                     <?php if(isset($_SESSION['stdname'])){ ?>
                        <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
                        <li><a href="editprofile.php"><input type="button" value="Change Password" name="action" class="subbtn" title="Change Password"/></a></li>
                        <li style="color: #0000cc; font-size: 24px;padding:0 10px;margin-right: 10px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva';"><b>	<?php echo $_SESSION['stdname']; ?> </li>
                    <?php } ?>
                    </ul>
                </form>
            </div>
			<div class="page">
	           <div style="text-align: left; padding: 40px;">
                <?php if(isset($_SESSION['stdname'])){ ?>
                <table style="text-align: left; ">
                    <tr>
                        <th><a href="stdtest.php" class='jqxButton'>Take Test</a></th>
                    </tr>
                    <tr>
                        <th><a href="resumetest.php" class='jqxButton'>Resume Test</a></th>
                    </tr>
                    <tr>
                        <th><a href="viewresult.php" class='jqxButton'>View Results</a></th>
                    </tr>
                    <tr>
                        <th><a href="myGraph.php" class='jqxButton'>Performance Statistics</a></th>
                    </tr>
                </table>        
                <?php }?>
            </div>
			
		</div>
           <div id="footer">
         
      </div>
      </div>
  </body>
</html>
