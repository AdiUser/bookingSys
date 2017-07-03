<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';


if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
} 
else if (!isset($_REQUEST['testqn'])) {echo "<script>alert('Please select a test...'); window.location='managetest.php';</script>";
	exit();
}  
else if (!isset($_REQUEST['testname'])) {echo "<script>alert('Test name not mentioned...'); window.location='managetest.php';</script>";
exit();
}  
else if (!isset($_REQUEST['subid'])) {echo "<script>alert('Subject not mentioned...'); window.location='managetest.php';</script>";
exit();
}  



?>

<html>
    <head>
        <title>Add Questions In Test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
		<link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />
        <script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" >
            function launch()
            {
                var c=$("#noofques").html();
                //alert(c);
                $.ajax({url:"ajaxhandler.php?request_id=7&testid="+escape(<?php echo $_REQUEST['testqn']; ?>)+"&count="+escape(c),success:function(result)
                    {
                        alert(result);
						if(result.substr(2,25)=='Test Launched Successfuly')
							{
							$('#test_launcher').val('Disable Test').attr('onclick','disableTest()');
							}
					
                    }
                });
            }
			
			function disableTest()
			{
				$.ajax({url:"ajaxhandler.php?request_id=8&testid="+escape(<?php echo $_REQUEST['testqn']; ?>),success:function(result)
                    {
                        alert(result);
						if(result.substr(2,25)=='Test Disabled Successfuly')
							{
							$('#test_launcher').val('Launch Test').attr('onclick','launch()');
							}
					
                    }
                });
			}
        </script>
    </head>
    
	<body onLoad="start();">		<hr style="margin-top:1%;" />
        <div id="container" >
            
	     
			 	<div class="menubar" id="g_msg">
                                    <span id="dsp_msg" style="float:left;color:yellow;font-size: 18px;" ></span>
	        	<?php      
				if(isset($_GLOBALS['message']))
				{
				 echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
				}
			  	?>
				
				<?php					
				  echo '<ul id="menu">';
						if (isset($_SESSION['admname'])) {
                       			 echo '<li><a href="logout.php"><input type="button" value="LogOut" name="logout" class="subbtn" title="Log Out"/></a></li>
					  <li><a href="admwelcome.php"><input type="button" value="Dashboard" name="dashboard" class="subbtn" title="Dash Board"/></a></li>
                                          <li>';
										  $r3=executeQuery("select status from test where testid=$_REQUEST[testqn]");
										  $res=mysql_fetch_array($r3);
											if($res[0]==1)
											{
												echo '<input type="button" value="Disable Test" id="test_launcher" class="subbtn" onclick="disableTest();" /> </li>';
											}
											else
											{
										      echo '<input type="button" value="Launch Test" id="test_launcher" class="subbtn" onclick="launch();" /> </li>';
											}
										  
						
				  echo '</ul>';	
				  }
						?>
                        
      		</div>
			
			<?php					
				if (isset($_SESSION['admname'])) {
            ?>
		<div class="page">
			<div id="rightmostpanel" style="width:13%;height:88%; border: solid #000000; background-color: #f8f9f6; padding:5px;  float:right; overflow: auto;">
				<h3 style="margin:0px 0px;text-align:center; "><b>Test Questions </b>
				<hr/>
                                </h3>
                                <div id="questionscount" style="text-align: center;" ><span id="noofques">
                                        <?php 
                                       $result=executeQuery("select count(qnid_s) as count from question where testid=$_REQUEST[testqn]");
                                       $r=mysql_fetch_array($result);
                                       echo $r['count'];
                                    ?></span>
                                    <?php echo "out of ";
                                       $result=executeQuery("select totalquestions from test where testid=$_REQUEST[testqn]");
                                       $r=mysql_fetch_array($result);
                                       echo "<span id='totalques'>".$r['totalquestions']."</span>";
                                    ?>
                                <hr/>
                                </div>
				<div id="rightquestionlist">
					<table>
						  <?php
						  $i=1;
						  $result=executeQuery("select * from question where testid=$_REQUEST[testqn]");
						  while($r=mysql_fetch_array($result))
						  {
						   echo "<tr onclick='fetch_right(".$r['qnid_s'].")' style='padding:2px 5px;'>
						          <td id='".$r['qnid_s']."test' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
								</tr>";
						   $i++; 
						  }
						   ?>
					</table>		   
				</div>
			</div>
			
			<div style="width:70%;height:88%; border: solid #000000; background-color: #f8f9f6; padding:5px;  float:right;">
				<div style="height:10%; margin-bottom:0px; ">
				 	<div id="adddiv">
					<input type="button" name="addtotest" id="addtotest" value="Add To Test" onClick="addtotest()" class="subbtn" style=" float:right;" />
					</div>
                                    <input type="button" name="removefromtest" id="remove" value="Remove from Test" onClick="removefromtest()" class="subbtn" style=" float:right;" />
					
				 <?php
						 $result=executeQuery("select * from level where testid=$_REQUEST[testqn]");
				 		 if(mysql_num_rows($result)==0)
				 		 {
						?>		
								<span id="set"><b>SET MARKS:</b></span>
								Easy Level:<input type="text" size="3" value="" placeholder="+ve" id="level_e"/>&nbsp;<input type="text" size="3" value="" placeholder="-ve" id="n_level_e"/>
								Medium Level:<input type="text" size="3" value="" placeholder="+ve" id="level_m"/>&nbsp;<input type="text" size="3" value="" placeholder="-ve" id="n_level_m"/>
								Hard Level:<input type="text" size="3" value="" placeholder="+ve" id="level_h"/>&nbsp;<input type="text" size="3" value="" placeholder="-ve" id="n_level_h"/>
								<input type="button" name="Save" value="Save"  id="savemarks"/>
						<?php
						}
						else
						{
							$r=mysql_fetch_array($result);
						?>
								<span id="set"><b>MARKS:</b></span>
								Easy Level:<input type="text" size="3" value="<?php echo $r['level_e']; ?>" disabled="disabled" id="level_e"/>&nbsp;<input type="text" size="3" value="<?php echo $r['n_level_e']; ?>"  disabled="disabled" id="n_level_e"/>
								Medium Level:<input type="text" size="3" value="<?php echo $r['level_m']; ?>" disabled="disabled"  id="level_m"/>&nbsp;<input type="text" size="3" value="<?php echo $r['n_level_m']; ?>"  disabled="disabled"  id="n_level_m"/>
								Hard Level:<input type="text" size="3" value="<?php echo $r['level_h']; ?>" disabled="disabled"  id="level_h"/>&nbsp;<input type="text" size="3" value="<?php echo $r['n_level_h']; ?>"  disabled="disabled" id="n_level_h"/>
								
						<?php
						}		
						?>
				</div>	
				
				
				<div id="rightpanel" style="height:89%; border: solid #000000; overflow: auto; margin:0px;" >
						
						<?php 
						$result=executeQuery("select * from subj_question where qnid_s=$_REQUEST[question]");
						$r=mysql_fetch_array($result);
		
						echo "<h3 style=\"margin:0px 0px;\">
							Question:<br/>
							<textarea id=\"ques\" name=\"ques\" class=\"ckeditor\" rows=\"10\" cols=\"110\" disabled=\"disabled\">".$r['question']."</textarea>";
                            
							if($r['figure'])
							{
							echo "<p><img src='../image_data/$r[figure]' /><br/>Remove Pic:<input type='radio' name='rem_pic' value='r' /></p>";
							}
						echo "</h3>
						
						<h3 style=\"margin:0px 0px;\">
							Options:<br/>
							A)<input value=\"optiona\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiona') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"a\" name=\"a\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optiona']. "</textarea><br/>
							B)<input value=\"optionb\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionb') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"b\" name=\"b\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optionb']. " </textarea><br/>
							C)<input value=\"optionc\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionc') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"c\" name=\"c\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optionc']. " </textarea><br/>
							D)<input value=\"optiond\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiond') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"d\" name=\"d\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optiond']. "</textarea><br/>";
							if($r['optione']!='')
							{
							echo "E)<input value=\"optione\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optione') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"e\" name=\"e\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optione']. " </textarea>";
							}
							echo "<br/></h3>";
				?>
				</div>
			</div>
				
				
				<div id="leftpanel" style="width:15%; height:89%; border: solid #000000;" >
				<h3 style="margin:0px 0px; text-align:center;">
							<b>Test : <span id="testname" ><?php echo "$_REQUEST[testname]";?></span></b>
				</h3>
				
					<?php 
					if($_GET['subid']==0)
					{
					echo "<div>
						<select id='subjectSelection' >";
					$result=executeQuery("select * from subject");
						while($r=mysql_fetch_array($result))
						{
						    echo "<option id='".$r['subid']."' value='".$r['subname']."'";
							if($_GET['subid']==$r['subid']){echo " selected='selected'"; }
							
							echo ">".$r['subname']."</option>";
							if($_GET['subid']==$r['subid'])
								echo "<script>document.getElementById('subject').innerHTML='$r[subname]';</script>";
						}
						echo "</select></div>";
					}
					?>
					
				
				<hr/>
				<div align="center">
					<input type="radio" name="level" title="All" value="All" checked="checked" />All
					<input type="radio" name="level" title="Easy" value="level_e" />Easy<br/>
					<input type="radio" name="level" title="Medium" value="level_m" />Medium
					<input type="radio" name="level" title="Hard" value="level_h" />Hard
					<br/>
					<hr/>
				</div>	
					
	<! --------------------------------------------------------------- List of Questions --------------------------------------------------------------- >
					
					<div id="questionsList" name="questions" style=" height:78%; overflow: auto;">
					   <table>
						  <?php
						  if($_GET['subid']==0)
						  {
							$result=executeQuery("select * from subj_question");
						  
						  }
						  else
							$result=executeQuery("select * from subj_question where subid=$_REQUEST[subid]");
						  
						  $i=1;
						  while($r=mysql_fetch_array($result))
						  {
						   echo "<tr onclick='fetch_q(".$r['qnid_s'].")' style='padding:2px 5px;'>
						          <td id='".$r['qnid_s']."d' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
								</tr>";
						   $i++; 
                                                   
						  }
                                                  
						   ?>
					  </table>					 
					</div>
				</div> 
			</div>
			
			<?php 
				}
                                closedb();
			?>
			
			<hr/ style="margin:15px;">
		</div>
		
	<script>	
	var selected_question_id;
	var delete_question_id;
	
		$("#subjectSelection").change(function(){
					
					var subj=$("#subjectSelection option:selected").attr('id');
					
					var lev= $("input:radio[name=level]:checked").val();
					
					
					$.ajax({url:"ajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						        $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("slow");
							   }
                            }); 
            });


	//--------------------------------------------------------------- Onload --------------------------------------------------------------- 
    function start()
	{
	        $('#adddiv').hide();
                $('#remove').hide();
	}
	
        function removefromtest()
        {
            var count=document.getElementById('noofques').innerHTML;
            if(parseInt(count)>0)
            {
                      document.getElementById('noofques').innerHTML=parseInt(count)-1;
                      $.ajax({url:"testajaxhandler.php?request_id=6&testid="+escape(<?php echo $_REQUEST['testqn']; ?>)+"&qnid_s="+delete_question_id,success:function(result){
                      $("#rightquestionlist").html(result).hide();
                      $("#rightquestionlist").slideDown("medium");
                      $('.testselected').removeClass('selected');
                      $('#'+qnid_s+'test').addClass('testselected');
                    }
		});
            }
            $('#remove').hide();
        }
	
	function addtotest()
        {
            $('#remove').hide();
            var count=document.getElementById('noofques').innerHTML;
            var total=document.getElementById('totalques').innerHTML;
            if(parseInt(count)<parseInt(total))
            {
                      document.getElementById('noofques').innerHTML=parseInt(count)+1;
                      $.ajax({url:"testajaxhandler.php?request_id=4&testid="+escape(<?php echo $_REQUEST['testqn']; ?>)+"&qnid_s="+selected_question_id,success:function(result){
                      $("#rightquestionlist").html(result).hide();
                      $("#rightquestionlist").slideDown("medium");
                      $('.testselected').removeClass('selected');
                      $('#'+qnid_s+'test').addClass('testselected');
                    }
		});
                       $("#adddiv").hide();
                        $.ajax({url:"testajaxhandler.php?request_id=5&question="+qnid_s+"&testid="+escape(<?php echo $_REQUEST['testqn']; ?>),success:function(result){ 
                                                                        document.getElementById('adddiv').innerHTML=result;
                                                                         }
                                });  

            }
            else
                alert("Questions Limit Exceeded!!!!");
	}		  
			
	
		// --------------------------------------------------------------- Dispaly question --------------------------------------------------------------- 
	function fetch_q(qnid_s)
	{
		
                $('#remove').hide();
                $.ajax({url:"testajaxhandler.php?request_id=3&question="+qnid_s,success:function(result){ 
								selected_question_id=qnid_s;                               
								$("#rightpanel").html(result).hide();
								$("#rightpanel").slideDown("medium");
								$('.selected').removeClass('selected');
                                $('#'+qnid_s+'d').addClass('selected');
								$('#adddiv').show();
                                }
                        });
                        $.ajax({url:"testajaxhandler.php?request_id=5&question="+qnid_s+"&testid="+escape(<?php echo $_REQUEST['testqn']; ?>),success:function(result){ 
								document.getElementById('adddiv').innerHTML=result;
								 }
                        });
						
	}
	
	function fetch_right(qnid_s)
	{
		
                $('#remove').show();
                $.ajax({url:"testajaxhandler.php?request_id=3&question="+qnid_s,success:function(result){ 
								delete_question_id=qnid_s;                               
								$("#rightpanel").html(result).hide();
								$("#rightpanel").slideDown("medium");
								$('.testselected').removeClass('testselected');
                                                                $('#'+qnid_s+'test').addClass('testselected');
								$('#adddiv').hide();
                                }
                        });
                        $.ajax({url:"testajaxhandler.php?request_id=5&question="+qnid_s+"&testid="+escape(<?php echo $_REQUEST['testqn']; ?>),success:function(result){ 
								document.getElementById('adddiv').innerHTML=result;
								 }
                        });
						
	}
	
	
$(document).ready(function(){
	       
		   $('#savemarks').click(function(){
                                        $('#remove').hide();
		   			var ep=$("#level_e").val();
					var en=$("#n_level_e").val();
					var mp=$("#level_m").val();
					var mn=$("#n_level_m").val();
					var hp=$("#level_h").val();
					var hn=$("#n_level_h").val();
					
					
					{
					$.ajax({url:"testajaxhandler.php?request_id=2&testid="+escape(<?php echo $_REQUEST['testqn']; ?>)+"&ep="+escape(ep)+"&en="+escape(en)+"&mp="+escape(mp)+"&mn="+escape(mn)+"&hp="+escape(hp)+"&hn="+escape(hn),success:function(result){
								document.getElementById('dsp_msg').innerHTML=result;
		   			$("#level_e").attr('disabled','disabled');
					$("#n_level_e").attr('disabled','disabled');
					$("#level_m").attr('disabled','disabled');
					$("#n_level_m").attr('disabled','disabled');
					$("#level_h").attr('disabled','disabled');
					$("#n_level_h").attr('disabled','disabled');
					$('#savemarks').hide();
					document.getElementById('set').innerHTML="<b>MARKS:</b>";
								}
						  });		
		   			}
				});	
			
		// --------------------------------------------------------------- For Level Radio Buttons --------------------------------------------------------------- 
			$('input[name=level]').change(function(){
			
						<?php
						if($_REQUEST['subid']==0)
						{
						?>
							var subj=$("#subjectSelection option:selected").attr('id');
						<?php
						}
						else
						{
						?>	var subj=<?php echo "$_REQUEST[subid] ;";
						
						}
						?>						
						var lev= $("input:radio[name=level]:checked").val();
                        $('#remove').hide();
						$("#ques").attr('disabled','disabled');
						$("#a").attr('disabled','disabled');
						$("#b").attr('disabled','disabled');
						$("#c").attr('disabled','disabled');
						$("#d").attr('disabled','disabled');
						$("#e").attr('disabled','disabled');	
						$('input[name=correct_answer]').attr('disabled','disabled');				
					
						$(':input','#editquestion')
						.not(':button, :submit, :reset, :hidden')
					    .text('')
					    .removeAttr('checked')
					    .removeAttr('selected');
					$.ajax({url:"testajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						        $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("medium");
							   }
                            });
                });		
					
		   
});
		</script>
	</body>
</html>			