<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';

if (!isset($_SESSION['admname'])) {
	header("Location:$PATH_ADMIN");
	}
	

$id=$_REQUEST['request_id'];
switch($id)
{
case 1:
		$lev=1;
		$sub=1;
		if(strcmp($_REQUEST['level'],'All')==0)
		  $lev=0;                 //Denotes All levels
		if($_REQUEST['subject']==0)
		   $sub=0;                 //Denotes All subjects 
		 echo "<table>";  
		   if($lev==0 && $sub==0)
		   {
			      $i=1;
				  $result=executeQuery("select * from subj_question");
				  while($r=mysql_fetch_array($result))
				  {
				  echo "<tr onclick='fetch_q(".$r['qnid_s'].")' style='padding:2px 5px;'>
						<td id='".$r['qnid_s']."d' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
						</tr>";
				   $i++; 
				  }
						
			}
		  else if($lev!=0 && $sub==0)
		   {		   
			    $result=executeQuery("select * from subj_question where level='".$_REQUEST['level']."'");
				$i=1;
				while($r=mysql_fetch_array($result))
				  {
				  echo "<tr onclick='fetch_q(".$r['qnid_s'].")' style='padding:2px 5px;'>
						<td id='".$r['qnid_s']."d' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
						</tr>";
						$i++; 
				  }
			}
		   else if($lev==0 && $sub!=0)
		   {
			    $result=executeQuery("select * from subj_question where subid=".$_REQUEST['subject']);
				$i=1;
				while($r=mysql_fetch_array($result))
				  {
				  echo "<tr onclick='fetch_q(".$r['qnid_s'].")' style='padding:2px 5px;'>
						<td id='".$r['qnid_s']."d' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
						</tr>";
				   $i++; 
				  }
			}
			else
			{
				$result=executeQuery("select * from subj_question where subid='".$_REQUEST['subject']."' AND level='".$_REQUEST['level']."'");
				$i=1;
				while($r=mysql_fetch_array($result))
				  {
				  echo "<tr onclick='fetch_q(".$r['qnid_s'].")' style='padding:2px 5px;'>
						<td id='".$r['qnid_s']."d' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
						</tr>";
				   $i++; 
				  }			
			}
			echo "</table>";
		break;
		
		
		
//Levels insertion
case 2:
		if(executeQuery("insert into level values($_REQUEST[testid],$_REQUEST[ep], $_REQUEST[mp] , $_REQUEST[hp] , $_REQUEST[en]  , $_REQUEST[mn]  , $_REQUEST[hn])"))
		{
			echo "Successfully Saved";
		}
		else
			echo "Error";
			
break;
//Display Question
case 3:
						$_SESSION['selected_question_id']=$_REQUEST['question'];
						$result=executeQuery("select * from subj_question where qnid_s=$_REQUEST[question]");
						$r=mysql_fetch_array($result);						
						echo "<h3 style=\"margin:0px 0px;\">							<b>Question Type :</b>							<select name=\"questionType\" id=\"questionType\" disabled>								<option value=\"Objective Type\" id=\"MC\" ";if($r['type']=="MC") echo "selected=\"selected\""; echo ">Objective Type</option>								<option value=\"Numerical Type\" id=\"NT\" ";if($r['type']=="NT") echo "selected=\"selected\""; echo ">Numerical Type</option>								</select><br/>
							Question:<br/>
							<textarea id=\"ques\" name=\"ques\" class=\"ckeditor\" rows=\"10\" cols=\"110\" disabled=\"disabled\">".$r['question']."</textarea>";
                            
							if($r['figure'])
							{
							echo "<p><img src='../image_data/$r[figure]' /></p>";
							}
						echo "</h3>";
												echo "<div id='objective_type'  "; if($r['type']=="NT") echo "hidden "; echo ">								<h3 style=\"margin:0px 0px;\">
								Options:<br/>
								A)<input value=\"optiona\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiona') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"a\" name=\"a\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optiona']. "</textarea><br/>
								B)<input value=\"optionb\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionb') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"b\" name=\"b\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optionb']. " </textarea><br/>
								C)<input value=\"optionc\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionc') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"c\" name=\"c\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optionc']. " </textarea><br/>
								D)<input value=\"optiond\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiond') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"d\" name=\"d\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optiond']. "</textarea><br/>";
								if($r['optione'])
								{
								echo "E)<input value=\"optione\"   type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optione') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"e\" name=\"e\" rows=\"1\" cols=\"110\" disabled=\"disabled\">".$r['optione']. " </textarea>";
								}
								echo "<br/></h3></div>";														echo "<div id='numerical_type'  "; if($r['type']=="MC") echo "hidden"; echo ">							<h3 style='margin:0px 0px;'>								Answer:	<input  type='text' value='$r[correct]' name='numerical_answer' id='numerical_answer' disabled /><br/>							</h3>								</div>";		
		break;




case 4:
		$result=executeQuery("select * from question where qnid_s=$_REQUEST[qnid_s] AND testid=$_REQUEST[testid]");
		if(mysql_num_rows($result)==0)
		{
				$result=executeQuery("select max(qnid) as m from question where testid=$_REQUEST[testid]");
				if(mysql_num_rows($result)==0)
				{
					$qry="insert into question values($_REQUEST[testid],1 , $_REQUEST[qnid_s])";
				}
				else
				{
					$r=mysql_fetch_array($result);
					$qry="insert into question values($_REQUEST[testid],$r[m]+1 , $_REQUEST[qnid_s])";
				}
				if(executeQuery($qry))
					{
						echo "<table>";
								  $i=1;
								  $result=executeQuery("select * from question where testid=$_REQUEST[testid]");
								  while($r=mysql_fetch_array($result))
								  {
								   echo "<tr onclick='fetch_right(".$r['qnid_s'].")' style='padding:2px 5px;'>
										  <td id='".$r['qnid_s']."test' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
										</tr>";
								   $i++; 
								  }
						echo "</table>";	
					}
				else
						echo "Error";
		}
		else
			 echo "Question Already Present In Test.";			
        
		
		break;



case 5:
				 $result=executeQuery("select * from question where testid=$_REQUEST[testid] AND qnid_s=$_REQUEST[question]");
				 if(mysql_num_rows($result)<=0)
				 {
				 	echo '<input type="button" name="addtotest" id="addtotest" value="Add To Test" onClick="addtotest()" class="subbtn" style=" float:right;" />';
				 }
				 else
				    echo " ";	
				 
				
	break;



case 6:
		
				if(executeQuery("DELETE FROM `question` WHERE qnid_s=$_REQUEST[qnid_s] AND testid=$_REQUEST[testid]"))
					{
						echo "<table>";
								  $i=1;
								  $result=executeQuery("select * from question where testid=$_REQUEST[testid]");
								  while($r=mysql_fetch_array($result))
								  {
								   echo "<tr onclick='fetch_right(".$r['qnid_s'].")' style='padding:2px 5px;'>
										  <td id='".$r['qnid_s']."test' class='' style='padding:2px 5px;cursor:pointer;' >Ques.$i</td>
										</tr>";
								   $i++; 
								  }
						echo "</table>";	
					}
				else
						echo "Error";
		
		break;

case 7:
		if(executeQuery("UPDATE test SET mean=$_REQUEST[mean],variance=$_REQUEST[variance],standard_deviation=$_REQUEST[sd] WHERE testid=$_REQUEST[testid]"))
		{
			echo "Successfully Saved";
		}
		else
		{
			echo "Error";
		}
break;
                
}

closedb();		

		
?>