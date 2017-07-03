<?php

error_reporting(0);
include_once '../oesdb.php';
/********************* Step 1 *****************************/
session_start();
        
if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
} 
?>

<html>
    <head>
        <title>OES-DashBoard</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        
        <script type="text/javascript" src="../lib/gettheme.js"></script>
        
        <link rel="stylesheet" href="../lib/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link rel="stylesheet" href="../lib/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
        
        <script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="../lib/jqwidgets/jqxcore.js"></script>
         <script type="text/javascript" src="../lib/jqwidgets/jqxbuttons.js"></script>
         <script type="text/javascript" src="../lib/jqwidgets/jqxswitchbutton.js"></script>
         <script type="text/javascript" src="../lib/jqwidgets/jqxcheckbox.js"></script>
         
         <style type="text/css">
        
        .jqx-switchbutton-label-on-custom
        {
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3065c4', endColorstr='#75adfc',GradientType=0 ); /* IE6-9 */    
            background-image: linear-gradient(bottom, rgb(118,174,252) 20%, rgb(48,103,197) 62%);
            background-image: -o-linear-gradient(bottom, rgb(118,174,252) 20%, rgb(48,103,197) 62%);
            background-image: -moz-linear-gradient(bottom, rgb(118,174,252) 20%, rgb(48,103,197) 62%);
            background-image: -webkit-linear-gradient(bottom, rgb(118,174,252) 20%, rgb(48,103,197) 62%);
            background-image: -ms-linear-gradient(bottom, rgb(118,174,252) 20%, rgb(48,103,197) 62%);
            background-image: -webkit-gradient(
	            linear,
	            left bottom,
	            left top,
	            color-stop(0.2, rgb(118,174,252)),
	            color-stop(0.62, rgb(48,103,197))
            );                    
            color: #fff;
            text-shadow: 0px -1px 1px #000;                                   
        }      
        
        .jqx-switchbutton-label-off-custom
        {
            background: #cfcfcf; /* Old browsers */
            background: -moz-linear-gradient(top,  #cfcfcf 0%, #fefefe 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cfcfcf), color-stop(100%,#fefefe)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  #cfcfcf 0%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  #cfcfcf 0%,#fefefe 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  #cfcfcf 0%,#fefefe 100%); /* IE10+ */
            background: linear-gradient(top,  #cfcfcf 0%,#fefefe 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cfcfcf', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */ 
            color: #808080;                 
        }
                
        .jqx-switchbutton-thumb-custom
        {
            background: #bababa; /* Old browsers */
            background: -moz-linear-gradient(top,  #bababa 0%, #fefefe 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bababa), color-stop(100%,#fefefe)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  #bababa 0%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  #bababa 0%,#fefefe 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  #bababa 0%,#fefefe 100%); /* IE10+ */
            background: linear-gradient(top,  #bababa 0%,#fefefe 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bababa', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */    
            border: 1px solid #aaa;
            -webkit-box-shadow: -6px 0px 17px 1px #275292;
            -moz-box-shadow: -6px 0px 17px 1px #275292;
            box-shadow: -6px 0px 17px 1px #275292;          
        }
        .jqx-switchbutton-custom
        {
            border: 1px solid #999999;
        }       
        
        #settings-panel
        {
            background-color: #fff;
            padding: 20px;
            display: inline-block;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            position: relative;
        }
        .settings-section
        {
            background-color: #f7f7f7;
            height: 55px;
            width: 600px;
            border: 1px solid #b4b7bc;
            border-bottom-width: 0px;
        }
        .settings-section-top
        {
            border-bottom-width: 0px;
            -moz-border-radius-topleft: 10px;
            -webkit-border-top-left-radius: 10px;
            border-top-left-radius: 10px;
            -moz-border-radius-topright: 10px;
            -webkit-border-top-right-radius: 10px;
            border-top-right-radius: 10px;            
        }
        .sections-section-bottom
        {
            border-bottom-width: 1px;
            -moz-border-radius-bottomleft: 10px;
            -webkit-border-bottom-left-radius: 10px;
            border-bottom-left-radius: 10px;
            -moz-border-radius-bottomright: 10px;
            -webkit-border-bottom-right-radius: 10px;
            border-bottom-right-radius: 10px;            
        }
        .sections-top-shadow
        {
            width: 500px;
            height: 1px;
            position: absolute;
            top: 21px;
            left: 21px;
            height: 30px;
            border-top: 1px solid #e4e4e4;
            -moz-border-radius-topleft: 10px;
            -webkit-border-top-left-radius: 10px;
            border-top-left-radius: 10px;
            -moz-border-radius-topright: 10px;
            -webkit-border-top-right-radius: 10px;
            border-top-right-radius: 10px;  
        }
        .settings-label
        {
            font-weight: bold;
            font-family: Sans-Serif;
            font-size: 14px;
            margin-left: 14px;
            margin-top: 15px;
            float: left;
        }
        .settings-melody
        {
            color: #385487;
            font-family: Sans-Serif;
            font-size: 14px;
            display: inline-block;
            margin-top: 7px;
        }
        .settings-setter
        {
            float: right;
            margin-right: 14px;
            margin-top: 8px;
        }
        .events-container
        {
            margin-left: 20px;
        }
        #theme
        {
            margin-left: 20px;
            margin-bottom: 20px;
        }
    </style>

         
    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function () {
                var theme = "energyblue";

                // Create a jqxToggleButton widget.
                $(".jqxButton").jqxLinkButton({ width: '300', height: '50', theme: theme });
                
                
                label = {
                    'button1': 'Enable Registration'
                };
                
                $('#button1').jqxSwitchButton({ height: 27, width: 81, theme: theme, checked: <?php
                $r2=executeQuery("SELECT * FROM  `sett` WHERE  `key` =  'stu_reg'");
                $row=mysql_fetch_array($r2);
                if($row[1] == 1)
                {
                    echo "true";
                }
                else
                {
                    echo "false";
                }
                ?> });
                
                $('.jqx-switchbutton').on('checked', function (event) {
                    
                        $.ajax({url:"admwelcome.php?stuRg=1",success:function(result){
            //alert(result);    
           
                                }
                            });
                    
                    });
                    
                    $('.jqx-switchbutton').on('unchecked', function (event) {
                        
                        
                         $.ajax({url:"admwelcome.php?stuRg=0",success:function(result){
            //alert(result);
                                }
                            });
                        
                    });
                    
                    function applyCustomTheme() {
                $('#button1').jqxSwitchButton('theme', 'custom');                
            }

            applyCustomTheme();
            
            });
        </script>
        <div id="container">
             <div class="header">
               <img style="margin:2px 2px 2px 2px;float:left;" height="100" width="180" src="../images/logo.gif" alt="OES"/>
				<div>
						<h3 class="headtext"> &nbsp;Raman Classes Online Examination System </h3>
						<h4 style="color:#ffffff;text-align:center;margin:-20px 0 5px 5px;"><i>Fulfill Your Dreams Of Studying In IITs</i></h4>
				</div>
            </div>
            <div class="menubar">

				<?php
				if(isset($_GLOBALS['message'])) {
					echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
				}
				?>
                <form name="admwelcome" action="admwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['admname'])){ ?>
                        <li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
						<li><a href="changepassword.php"><input type="button" value="Change Password" name="action" class="subbtn" title="Change Password"/></a></li>
                        <li><a href="admwelcome.php"><input type="button" value="Home" name="action" class="subbtn" /></a></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
            <?php 
            if(isset($_REQUEST['newAd']))
            {
                ?>
                    <div class="page" style="padding:5% 15%;">
                        <form id="admloginform" action="index.php" method="post" onsubmit="return validateform('admloginform');">
                           <table cellpadding="2" cellspacing="2" style="text-align:left;margin-left:15em" >
                                          <tr>
                                  <td><h2 style="font-size:24px; font-family: 'Monotype Corsiva'; font:'Monotype Corsiva'; " align="center"><b>New Administarator?</b></h2></td>
                              </tr>
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
                                                  <input type="submit" name="admsubmitreg" value="Register" class="subbtn" />
                                  <input type="reset" name="reset" value="Reset" class="subbtn"/>
                                                  </td>
                             </tr>
                            </table>
                        </form>
                    </div>
                <?php
            }
            else if(isset($_REQUEST['shwAd']))
            {
                include_once 'oesdb.php';
                $result=executeQuery("select admname from adminlogin");
                echo "<div class=\"page\"  style=\"padding:5% 15%;\">";
                echo "<table border='1' width='30%' cellpadding=\"2\" cellspacing=\"2\" style=\"text-align:left;margin-left:15em;padding:30px;border:1px solid black;\" >";
                echo "<tr>
                                <th style='padding:5px;' colspan='2' align='center'>Admin </th>
                            </tr>";
                while($r=mysql_fetch_array($result))
                {
                    echo "  <tr>
                                <td style='padding:5px;' > $r[0] </td>
                                <td style='padding:5px;' >";
								if($r[0]=='root')
								{
								echo "Can not remove root.";
								} 
								else 
								{
								echo "<a href='admwelcome.php?delAd=$r[0]' >Remove $r[0]";
								} 
								echo"</a> </td>
                            </tr>";
                }
                echo "</table></div>";
            }
            else if(isset($_REQUEST['delAd']))
            {
                if($_SESSION['admname'] == $_REQUEST['delAd'])
                {
                    echo "<script> alert('You cannot remove Yourself.') </script>";
                }
                if($_REQUEST['delAd'] == "root")
                {
                    echo "<script> alert('You cannot remove ROOT.') </script>";
                }
                else
                {
                    executeQuery("delete from adminlogin where admname='$_REQUEST[delAd]'");
                    echo "<script> alert('Admin Removed Successfuly.') </script>";
                }
            }
            else if(isset($_REQUEST['stuRg']))
            {
                
                    executeQuery("update sett set flag=$_REQUEST[stuRg] WHERE  `key` =  'stu_reg'");
                    exit();
                    //echo "<script> alert('Student Registration Enabled ') </script>";               
            }
            else
            {
            ?>
            <div class="page" >						    
			    <div style="text-align: left;">					<div id="setTab" style="float:left;padding:10px;text-align:center;margin:0px 0px;" >						<h2 style="font-family:arial;" >Settings</h2>						<?php						$r=executeQuery("select flag from sett where `key`='batch'");						$row=mysql_fetch_array($r);												$r2=executeQuery("select flag from sett where `key`='Error_Allowed'");						$row2=mysql_fetch_array($r2);												?>						<table>							<tr>								<th>Set Batch</th>								<td><input type="text" value="<?php echo $row[0]; ?>" id="bat" size="4" maxlength="4" disabled="disabled" /></td>							</tr>							<tr>								<th>Error Allowed</th>								<td><input type="text" value="<?php echo $row2[0]; ?>" id="err" size="4" maxlength="8" disabled="disabled" /></td>							</tr>							<tr>								<td colspan="2" ><input type="button" value="Edit" onclick="edit_set(this);" /></td>							</tr>						</table>									</div>
                <?php if(isset($_SESSION['admname'])){ ?>
				
                <table style="text-align: center;  ">
                    <tr>
                        <th><a href="usermng.php" class='jqxButton'>Manage Users</a></th>
                        <th><a href="submng.php" class='jqxButton'>Manage Subjects</a></th>
                    </tr>
                    
                    <tr>
                        <th><a href="rsltmng.php" class='jqxButton'>Manage Results</a></th>
                        <th><a href="managetest.php" class='jqxButton'>Manage Tests</a></th>
                    </tr>
                   
                    <tr>
                        <th colspan="2" ><a href="createquestions.php" class='jqxButton'>Prepare Questions</a></th>
                        
                    </tr>
                    
                    <tr>
                        <th><a href="admwelcome.php?newAd=1" class='jqxButton'>Add New Admin</a></th>
                        <th><a href="admwelcome.php?shwAd=1" class='jqxButton'>Show All Admin</a></th>
                    </tr>
                    <tr>
                        <th colspan="2" ><a href="user_activity.php" class='jqxButton'>User Activity</a></th>
                        
                    </tr>
                    <tr>
                        <th colspan="2" >
                             <div id="settings-panel">

                             <div class="sections-top-shadow"></div>

                            <div class="sections-section-bottom settings-section">
                                <div class="settings-label">Enable Registration</div>
                                <div class="settings-setter">
                                    <div id="button1"></div>
                                </div>
                            </div>
                            
                          </div>
                        </th>
                    </tr>
                </table> 
				<?php
					$r3=executeQuery("SELECT `metadata` FROM `sett` WHERE `key`='notice'");
					$row=mysql_fetch_array($r3);
				?>
				<table>
					<tr>
						<th>NOTICE and UPDATES</th>
					</tr>
					<tr>
						<td><textarea cols="80" rows="15" id="mdata" disabled="disabled" ><?php echo $row[0]; ?></textarea></td>
					</tr>
					<tr>
						<td><input type="button" value="Edit" id="but1" onclick="enbArea();" /></td>
					</tr>
				</table>
				<br/><br/>
                <?php }?>
            </div>
            </div>
        <?php }
        closedb();
        ?>
          <div id="footer">
          
      </div>
      </div>
<script>
	function enbArea()
	{
		$('#but1').val('Update');
		$('#but1').attr('onclick','update_notice()');
		$('#mdata').removeAttr('disabled');
	}
	function update_notice()
	{
	
		
		$.ajax({url:"ajaxhandler.php?request_id=9&m_data="+escape($('#mdata').val()),success:function(result){
						        
								if(result == 1)
								{
									$('#but1').val('Edit');
									$('#mdata').attr('disabled','disabled');
									$('#but1').attr('onclick','enbArea()');
									}
								else
									alert('Error. Try Again!');
							   }
                            }); 
	}		function edit_set(k)	{		$(k).val("Save");		$(k).attr("onclick","save_set(this)");		$('#bat').removeAttr('disabled');		$('#err').removeAttr('disabled');	}	function save_set(k)	{		$.ajax({url:"ajaxhandler.php?request_id=10&m_data="+escape($('#bat').val())+"&m_data2="+escape($('#err').val()),success:function(result){							if(result == 1)					{						$(k).val("Edit");						$(k).attr("onclick","edit_set(this)");						$('#bat').attr('disabled','disabled');						$('#err').attr('disabled','disabled');					}					else						alert("Error! Try Again.");				}			});	}

</script>
  </body>
</html>
