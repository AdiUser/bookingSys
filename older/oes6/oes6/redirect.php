<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Online Examination System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    
  </head>
  <body>
    <div id="container">
      <div class="header">
	  	<img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="images/logo.gif" alt="OES"/>
		<div>
				<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
				<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
		</div>
	  </div>
	</div>
      <?php
      session_start();
      if($_SESSION['w_no']==0)
      {
      ?>
      <script type="text/javascript">
        if (window.console && window.console.firebug) {
            alert('Please Disable Firebug!');
            
        }
        else
        {
            window.open('stdwelcome.php','_blank','fullscreen=on,location=no,menubar=no,toolbar=no,titlebar=no,status=no,scrollbars=yes');
        }
        window.location="index.php";
      </script>
      <?php
      echo "<div style='text-align:center;color:white;margin-top:250px;' ><a style='text-decoration:none;color:blue;font-size:18px;' href='stdwelcome.php?logout=1'>Logout</a></div>";
        $_SESSION['w_no']=$_SESSION['w_no'] + 1;
      }
      else
      {
          echo "<div style='text-align:center;color:grey;margin-top:200px;' ><h1>Your window have already opened!</h1>";
		  echo "<p style='text-align:center;' >If window not opened, Please check <strong>POP-UP</strong> settings of browser, enable it and re-login.</p>";
          echo "<a style='text-decoration:none;color:blue;font-size:18px;' href='logout.php'>Logout</a></div>";
      }
      ?>
  </body>
</html>
