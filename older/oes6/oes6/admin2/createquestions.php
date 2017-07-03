<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';



if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
} 
?>

<html>
    <head>
        <title>OES-Create Questions</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
		<link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />
        <script type="text/javascript" src="../lib/jquery-1.10.1.min.js"></script>
        <script src="ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" href="ckeditor/styles.css" />
		<script type="text/javascript">
			var r_value=-1;
               
                //  --------------------------------------------------------------- Assign radio value --------------------------------------------------------------- 
                function assign_v()
				{
                     for(var i=0;i<=4;i++)
                        {
                            if(document.getElementsByName('correct_answer')[i].checked == true) 
                                {
                                    r_value=document.getElementsByName('correct_answer')[i].value;
                                }
                        }
				}
        
/*
    // --------------------------------------------------------------- Saving a new question in database --------------------------------------------------------------- 
	   function insert()
		{
                    $('#newSub').hide();
 				    $('#nsub').show();
			        document.getElementById('g_msg').innerHTML="";
					var subject=$("#subjectSelection option:selected").attr('id');
					var level= $("input:radio[name='level']:checked").val();
                    var ques= $("#ques").val();
					var opa=$("#a").val();
					var opb=$("#b").val();
					var opc=$("#c").val();
					var opd=$("#d").val();
					var ope=$("#e").val();
					var opsel=$('#'+r_value).val();
					
					if(ques=="" || opa=="" || opb==""|| opc=="" || opd=="")
                     {
                         alert("Some of the fields are Empty.");
                         return false;
                     }
					 else if(r_value ==-1)
					 {
					 	 alert("Select a Correct option..");
                         return false;
					 }
					     
					 else if(opsel=="")
					 {
					 	 alert("Please select a valid option..");
                         return false;
					 }
					else
					{
					$.ajax({url:"ajaxhandler.php?request_id=2&subject="+escape(subject)+"&level="+escape(level)+"&question="+escape(ques)+"&attachment="+'atch'+"&opa="+escape(opa)+"&opb="+escape(opb)+"&opc="+escape(opc)+"&opd="+escape(opd)+"&ope="+escape(ope)+"&correct="+escape(r_value),success:function(result){
								document.getElementById('g_msg').innerHTML=result;
								$(':input','#editquestion')
								.not(':button, :submit, :reset, :hidden')
								.text('')
								.removeAttr('checked')
								.removeAttr('selected');
								$("#ques").attr('disabled','disabled');
								$("#attachment").attr('disabled','disabled');
								$("#a").attr('disabled','disabled');
								$("#b").attr('disabled','disabled');
								$("#c").attr('disabled','disabled');
								$("#d").attr('disabled','disabled');
								$("#e").attr('disabled','disabled');					
								$('input[name=correct_answer]').attr('disabled','disabled');
								$("#editque").hide();						
								$("#update").hide();								
								$("#submit").hide();	
								$(':input','#editquestion')
								.not(':button, :submit, :reset, :hidden')
								.text('')
								.removeAttr('checked')
								.removeAttr('selected');
							}
                          });
					r_value=-1;		
					$.ajax({url:"ajaxhandler.php?request_id=1&subject="+escape(subject)+"&level="+escape(level),success:function(result){
						       $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("medium");
							   }
                          }); 			
                    
				  }
				}
		
			
// --------------------------------------------------------------- Updating a question --------------------------------------------------------------- 
		function updatevalue()
		{
					$('#newSub').hide();
 				    $('#nsub').show();
			        document.getElementById('g_msg').innerHTML="";
					var ques= $("#ques").val();
					var opa=$("#a").val();
					var opb=$("#b").val();
					var opc=$("#c").val();
					var opd=$("#d").val();
					var ope=$("#e").val();
					var opsel=$('#'+r_value).val();
					
					if(ques=="" || opa=="" || opb==""|| opc=="" || opd=="")
                     {
                         alert("Some of the fields are Empty.");
                         return false;
                     }
					 else if(r_value ==-1)
					 {
					 	 alert("Select a Correct option..");
                         return false;
					 }
					     
					 else if(opsel=="")
					 {
					 	 alert("Please select a valid option..");
                         return false;
					 }
					else
					{
					$.ajax({url:"ajaxhandler.php?request_id=4&qnid_s="+escape(selected_question_id) +"&question="+escape(ques)+"&attachment="+'atch'+"&opa="+escape(opa)+"&opb="+escape(opb)+"&opc="+escape(opc)+"&opd="+escape(opd)+"&ope="+escape(ope)+"&correct="+escape(r_value),success:function(result){
								document.getElementById('g_msg').innerHTML=result;
								$(':input','#editquestion')
								.not(':button, :submit, :reset, :hidden')
								.text('')
								.removeAttr('checked')
								.removeAttr('selected');
								$("#ques").attr('disabled','disabled');
								$("#attachment").attr('disabled','disabled');
								$("#a").attr('disabled','disabled');
								$("#b").attr('disabled','disabled');
								$("#c").attr('disabled','disabled');
								$("#d").attr('disabled','disabled');
								$("#e").attr('disabled','disabled');					
								$('input[name=correct_answer]').attr('disabled','disabled');
								$("#editque").hide();						
								$("#update").hide();								
								$("#submit").hide();	
								$("#submit").attr('disabled','disabled');
							}
                         });
                    }
					
		}
  */         //-----------------------------put level and subject in form hidden fields-----------------------
                function put_value()
                {
                    var subject=$("#subjectSelection option:selected").attr('id');
                    var level= $("input:radio[name='level']:checked").val();
                    $("#sub").val(subject);
                    $("#lev").val(level);
                    $("#qnid_ss").val(selected_question_id);
                    return true;
                }
				
				var global_position=0;
			/*	document.onkeydown = function() 
                    {
                        //alert(event.keyCode);
                        
                        if(global_position!=0)
						{
							switch (event.keyCode) 
							{
								case 38 : //UP
									 fetch_q(parseInt(global_position)-1);
									 return false;
								 case 40 : //DOWN
									 fetch_q(parseInt(global_position)+1);
									 return false;
								 
							}
						}	
                        
                    }
			*/		
		</script>		
    </head>
    
	<body onLoad="start();">		<hr style="margin-top:1%;" />
        <div id="container" >
			 	<div class="menubar" id="g_msg">
	        	<?php      
				if(isset($_REQUEST['result']))
					{
					if($_REQUEST['result']=='success')
						echo "<span style='padding:5px 10px;width:200px; float:left; font-size:22px; '>Successfully Saved.</span>";					
					else if($_REQUEST['result']=='failure')
						echo "<span style='padding:5px 10px;width:200px;float:left; font-size:22px; '>There Is Some error.</span>";
					}
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
				  </ul>';	
				  }
						?>
                        
      		</div>
			
			<?php					
				if (isset($_SESSION['admname'])) {
            ?>
			<div class="page">
				<div id="rightpanel" style="width:80%;height:85%; border: solid #000000; background-color: #f8f9f6; padding:5px;  float:right; overflow: auto;">
					<form name="editquestion" id="editquestion" action="ajaxhandler.php"  method="post" onsubmit="put_value();" enctype="multipart/form-data" >
                                                <input type="hidden" name="request_id" value="2" id="rqst_no" />
                                                <input type="hidden" name="subject" value="" id="sub" />
                                                <input type="hidden" name="level" value="" id="lev" />
                                                 <input type="hidden" name="qnid_s" value="" id="qnid_ss" />
						<h3 style="margin:0px 0px;">
							<b>Subject : </b><span id="subject" >Miscellaneous</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Level :</b><span id="level" >All</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;														<b>Type :</b> 							<select name="qsType" >								<option value="MC" >Multiple Choice</option>								<option value="NT" >Numerical Type</option>							</select>
							
							<input type="submit" name="submitquestion" id="submit" value="Save" hidden="hidden" onClick="" class="subbtn" disabled="disabled" style=" float:right;" />
							<input type="submit" name="updateq" id="update" value="Update"  onclick='' class="subbtn" disabled="disabled" style=" float:right;" />
							<input type="button" name="editq" id="editque" value="Edit" class="subbtn" style=" float:right;" />							
							
						</h3>
						<h3 style="margin:0px 0px;">
							Question:<br/>
							<textarea id="ques" name="ques" rows="10" cols="125" disabled="disabled" ></textarea>
                            Attachment:<input type="file" name="pic" id="attachment" disabled="disabled"/>
						</h3>
						
						<h3 style="margin:0px 0px;">
							Options:<br/>
							A)<input  type="radio" value="optiona" name="correct_answer" /><textarea id="a" name="a" rows="1" cols="125" disabled="disabled"></textarea><br/>
							B)<input  type="radio" value="optionb" name="correct_answer" /><textarea id="b" name="b" rows="1" cols="125" disabled="disabled"></textarea><br/>
							C)<input  type="radio" value="optionc" name="correct_answer" /><textarea id="c" name="c" rows="1" cols="125" disabled="disabled"></textarea><br/>
							D)<input  type="radio" value="optiond" name="correct_answer" /><textarea id="d" name="d" rows="1" cols="125" disabled="disabled"></textarea><br/>
							E)<input  type="radio" value="optione" name="correct_answer" /><textarea id="e" name="e" rows="1" cols="125" disabled="disabled"></textarea><br/>						</h3>		
						
						
					</form>					
	</div>
				
				<div id="leftpanel" style="width:18%; height:87%; border: solid #000000;" >
				  <form name="subjectsandquestion" action=""  method="post">
					<select name="subjectSelection" id="subjectSelection">
					  
					  <?php
					  $result=executeQuery("select * from subject");
						while($r=mysql_fetch_array($result))
						{
						    echo "<option id='".$r['subid']."' value='".$r['subname']."'";
							if($_GET['subid']==$r['subid']){echo " selected='selected'"; }
							
							echo ">".$r['subname']."</option>";
							if($_GET['subid']==$r['subid'])
								echo "<script>document.getElementById('subject').innerHTML='$r[subname]';</script>";
						}
						
						
					  ?>	
					</select>
					<br/>
					<?php 
					if(isset($_GET['level']))
					{
					if($_GET['level']=='level_e')
								echo "<script>document.getElementById('level').innerHTML='Easy'</script>";
					if($_GET['level']=='level_m')
								echo "<script>document.getElementById('level').innerHTML='Medium'</script>";
					if($_GET['level']=='level_h')
								echo "<script>document.getElementById('level').innerHTML='Hard'</script>";
								
					echo '<input type="radio" name="level" title="All" value="All" />All
					<input type="radio" name="level" title="Easy" value="level_e" '; if($_GET['level']=='level_e'){ echo 'checked="checked" ';} echo '/>Easy
					<input type="radio" name="level" title="Medium" value="level_m" '; if($_GET['level']=='level_m'){ echo 'checked="checked" ';} echo '/>Medium
					<input type="radio" name="level" title="Hard" value="level_h" '; if($_GET['level']=='level_h'){ echo 'checked="checked" ';} echo '/>Hard';
					}
				
					else
					{
					echo '
					<input type="radio" name="level" title="All" value="All" checked="checked" />All
					<input type="radio" name="level" title="Easy" value="level_e" />Easy
					<input type="radio" name="level" title="Medium" value="level_m" />Medium
					<input type="radio" name="level" title="Hard" value="level_h" />Hard
					';
					}
					?>
					<br/>
					
	<! --------------------------------------------------------------- List of Questions --------------------------------------------------------------- >
					
					<div id="questionsList" name="questions" style=" height:70%;border:solid; overflow: auto;">
					   <table>
						  <?php
						  $i=1;
						  $result=executeQuery("select * from subj_question");
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
						
					<div style="height:7%">
					<input type="button" disabled="disabled" id="new" title="New Question" name="New Question" style="background:url(../images/new.jpg); width:48px; "/>
					<input type="button" id="delete" title="Delete Question" name="Delete Question" onClick="deletequestion();" style="background-image:url(../images/delete.jpg);width:48px;"/>
					<input type="button" id="nsub" title="Add Subject" name="Add Subject" onClick="addsubject();" style="background-image:url(../images/addSubject.jpg);width:48px;"/>
					</div>
					
					<div id="newSub">
						<input id="asub" placeholder="Subject Name" size="16" />
						<input type="button" id="addbut" onClick="addnewsubject();" value="Add"/>
					</div>
					
					   
					
				  </form>
				</div> 
			</div>
			
			<?php 
				}
			?>
			<hr/ style="margin:20px;">
		</div>
		
		
	<script>
	
	var selected_question_id=-1;

// ---------------------------------------------------------------  Delete Question --------------------------------------------------------------- 
	function deletequestion()
	{
	   $('#newSub').hide();
	   $('#nsub').show();$('#logout').show();


		$.ajax({url:"ajaxhandler.php?request_id=5&question="+selected_question_id,success:function(result){ 
						document.getElementById('g_msg').innerHTML=result;
								
						$(':input','#editquestion')
						.not(':button, :submit, :reset, :hidden')
					    .text('')
					    .removeAttr('checked')
					    .removeAttr('selected');
								
                                }
                        });
		var subj=$("#subjectSelection option:selected").attr('id');
		var lev= $("input:radio[name=level]:checked").val();				
		$.ajax({url:"ajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						     	$("#questionsList").html(result).hide();
								$("#questionsList").slideDown("medium");
							   }
                            }); 				
	
	
	}
		// --------------------------------------------------------------- Dispaly question --------------------------------------------------------------- 
	function fetch_q(qnid_s)
	{
		global_position=qnid_s;
		$.ajax({url:"ajaxhandler.php?request_id=3&question="+qnid_s,success:function(result){ 
								r_value=-1;
							   $('#newSub').hide();
							   $('#nsub').show();
							   $('#delete').show();
								selected_question_id=qnid_s;                               
								$("#rightpanel").html(result).hide();
								$("#rightpanel").slideDown("medium");
								$('.selected').removeClass('selected');
                                $('#'+qnid_s+'d').addClass('selected');
								$('#submit').hide();
								$('#update').hide();
								$("#removepic_id").hide();
                                }
                        });
	}
        // --------------------------------------------------------------- Show Add Subject Div --------------------------------------------------------------- 
	function addsubject()
	{
			   $('#newSub').show();
			   $('#nsub').hide();
	}	
	
	// --------------------------------------------------------------- Add Subject --------------------------------------------------------------- 
	function addnewsubject()
	{
			   var newsub=$('#asub').val();
			   if(newsub=='')
			   {
			   alert('Enter Subject Name..');
			   return false;
			   }
			   else
			   {
			   $.ajax({url:"ajaxhandler.php?request_id=6&subject="+newsub,success:function(result){
			   					document.getElementById('subjectSelection').innerHTML=result;
							   }
                            }); 
			   $('#newSub').hide();
			   $('#nsub').show();
			   }
	}
		
	
	// --------------------------------------------------------------- Edit Question --------------------------------------------------------------- 
    function doedit()
	{
					r_value=-1;
	            	$('#update').show();
	        		$('#delete').show();
            		$('#editque').hide();
					$("#ques").removeAttr('disabled');
					$("#attachment").removeAttr('disabled');
					$("#a").removeAttr('disabled');
					$("#b").removeAttr('disabled');
					$("#c").removeAttr('disabled');
					$("#d").removeAttr('disabled');
					$("#e").removeAttr('disabled');
					$('input[name=correct_answer]').removeAttr('disabled');
					$("#update").removeAttr('disabled');
					$("#editque").attr('disabled','disabled');
                    $("#rqst_no").val("4");
					$("#removepic_id").show();
					$("#attachment_id").show();

	} 
	
	 //--------------------------------------------------------------- Onload --------------------------------------------------------------- 
    function subject_and_level_set(subj,lev)
	{
	$.ajax({url:"ajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						        $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("medium");
								$('#new').show();
								$('#new').removeAttr('disabled');
					
							   }
                            }); 
	}
	
	function start()
	{
	        $('#editque').hide();
            $('#update').hide();
	        $('#new').hide();
            $('#delete').hide();
			$('#newSub').hide();
			<?php
			if(isset($_GET['level']))
				echo "subject_and_level_set('$_GET[subid]','$_GET[level]');";
				
			?>	
	
	}
	
	
   $(document).ready(function(){
	       $("input:radio[name='correct_answer']").bind('click', function(){
            //alert('1');
            assign_v();
        });
        
               
    	// --------------------------------------------------------------- For DropDown List Of subjects --------------------------------------------------------------- 
		
		$("#subjectSelection").change(function(){
					var subject=$("#subjectSelection option:selected").val();
					var subj=$("#subjectSelection option:selected").attr('id');
					var level= $("input:radio[name=level]:checked").attr('title');
					var lev= $("input:radio[name=level]:checked").val();
					document.getElementById('subject').innerHTML=subject;
					document.getElementById('level').innerHTML=level;
					if(subject=='Miscellaneous' || level=='All')
					{
						$('#new').hide();
						$('#delete').hide();
						$("#ques").attr('disabled','disabled');
						$("#attachment").attr('disabled','disabled');
						$("#a").attr('disabled','disabled');
						$("#b").attr('disabled','disabled');
						$("#c").attr('disabled','disabled');
						$("#d").attr('disabled','disabled');
						$("#e").attr('disabled','disabled');
						$("#submit").attr('disabled','disabled');
					}
					else
					{
	        			$('#new').show();
						$("#new").removeAttr('disabled');
					}		   
					
						$(':input','#editquestion')
						.not(':button, :submit, :reset, :hidden')
					    .text('')
					    .removeAttr('checked')
					    .removeAttr('selected');
						
						
					
			   $('#newSub').hide();
			   $('#nsub').show();	
					
					$.ajax({url:"ajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						        $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("slow");
							   }
                            }); 
            });
			
			
			// --------------------------------------------------------------- For Level Radio Buttons --------------------------------------------------------------- 
			$('input[name=level]').change(function(){
					var subject=$("#subjectSelection option:selected").val();
					var subj=$("#subjectSelection option:selected").attr('id');
					var level= $("input:radio[name=level]:checked").attr('title');
					var lev= $("input:radio[name=level]:checked").val();
					document.getElementById('subject').innerHTML=subject;
					document.getElementById('level').innerHTML=level;
					if(subject=='Miscellaneous' || level=='All')
					{						
						$('#new').hide();
						$('#delete').hide();
						$("#ques").attr('disabled','disabled');
						$("#attachment").attr('disabled','disabled');
						$("#a").attr('disabled','disabled');
						$("#b").attr('disabled','disabled');
						$("#c").attr('disabled','disabled');
						$("#d").attr('disabled','disabled');
						$("#e").attr('disabled','disabled');	
						$('input[name=correct_answer]').attr('disabled','disabled');				
						$("#submit").attr('disabled','disabled');
					}
					else
					{
	        			$('#new').show();
					    $("#new").removeAttr('disabled');
					}
					
						$(':input','#editquestion')
						.not(':button, :submit, :reset, :hidden')
					    .text('')
					    .removeAttr('checked')
					    .removeAttr('selected');
							
			   $('#newSub').hide();
			   $('#nsub').show();
					$.ajax({url:"ajaxhandler.php?request_id=1&subject="+subj+"&level="+lev,success:function(result){
						        $("#questionsList").html(result).hide();
								$("#questionsList").slideDown("medium");
							   }
                            }); 
                });	
		
		
		
		
		
		
			//--------------------------------------------------------Creating New Question--------------------------------------------------------------
			
			$("#new").click(function(){
					$(':input','#editquestion')
								.not(':button, :submit, :reset, :hidden')
								.text('')
								.removeAttr('checked')
								.removeAttr('selected');
					r_value=-1; 
					$("#ques").removeAttr('disabled');
                                        
					$("#attachment").removeAttr('disabled');
					$("#a").removeAttr('disabled');
					$("#b").removeAttr('disabled');
					$("#c").removeAttr('disabled');
					$("#d").removeAttr('disabled');
					$("#e").removeAttr('disabled');
					$('input[name=correct_answer]').removeAttr('disabled');
					$("#editque").hide();
					$("#update").hide();										
					$("#image_showhide").hide();	
					$("#submit").show();	
					$("#submit").removeAttr('disabled');
			   $('#newSub').hide();
			   $('#nsub').show();
                           $("#rqst_no").val("2");
                           //CKEDITOR.instances['ques'].setReadOnly(true);
					$("#attachment_id").show();
		   }); 
		   
		

		
	});	
		</script>
	</body>
</html>			