<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';


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
			    $result=executeQuery("select * from subj_question where subid='".$_REQUEST['subject']."'");
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
		
		
		
		
case 2:
        $name='';
        $flag=false;
        
        if(!empty($_FILES['pic']['name']))
        {
            
            $name=time().".".basename($_FILES['pic']['type']);
            if(move_uploaded_file($_FILES['pic']['tmp_name'],"../image_data/".$name))
            {
                $flag=true;
                
            }
        }
        if($flag)
            $query="insert into subj_question(qnid_s,subid,level,question,figure,optiona,optionb,optionc,optiond,optione,correct) values (DEFAULT,'".htmlspecialchars($_REQUEST['subject'],ENT_QUOTES)."' , '".htmlspecialchars($_REQUEST['level'],ENT_QUOTES)."' , '".htmlspecialchars($_REQUEST['ques'],ENT_QUOTES)."' ,'$name', '".htmlspecialchars($_REQUEST['a'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['b'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['c'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['d'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['e'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['correct_answer'],ENT_QUOTES)."' )";
        else
            $query="insert into subj_question(qnid_s,subid,level,question,figure,optiona,optionb,optionc,optiond,optione,correct) values (DEFAULT,'".htmlspecialchars($_REQUEST['subject'],ENT_QUOTES)."' , '".htmlspecialchars($_REQUEST['level'],ENT_QUOTES)."' , '".htmlspecialchars($_REQUEST['ques'],ENT_QUOTES)."' ,DEFAULT, '".htmlspecialchars($_REQUEST['a'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['b'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['c'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['d'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['e'],ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['correct_answer'],ENT_QUOTES)."' )";
		
                if(executeQuery($query))
		{
		//echo $query;
		 echo "<script>window.location='createquestions.php?subid=$_REQUEST[subject]&level=$_REQUEST[level]&result=success';</script>";
                    
		}
		else
		{
			echo "<script>window.location='createquestions.php?subid=$_REQUEST[subject]&level=$_REQUEST[level]&result=failure';</script>";
		}
		
		break;
		
		
		
//Retreiving Question		
case 3:
		$result=executeQuery("select * from subj_question where qnid_s=$_REQUEST[question]");
		$r=mysql_fetch_array($result);
		
						echo "	<form name=\"editquestion\" id=\"editquestion\" action=\"ajaxhandler.php\"  method=\"post\" onsubmit=\"put_value();\" enctype=\"multipart/form-data\" ><h3 style=\"margin:0px 0px;\">
                                                            <input type=\"hidden\" name=\"request_id\" value=\"2\" id=\"rqst_no\" />
                                                            <input type=\"hidden\" name=\"subject\" value=\"\" id=\"sub\" />
                                                            <input type=\"hidden\" name=\"level\" value=\"\" id=\"lev\" />
                                                            <input type=\"hidden\" name=\"qnid_s\" value=\"\" id=\"qnid_ss\" />
                                                         <b>Subject : </b><span id=\"subject\" > ";
								$subresult=executeQuery("select subname from subject where subid=$r[subid]");
								$q=mysql_fetch_array($subresult);
								echo $q['subname']."																
								</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Level :</b><span id=\"level\" >";
							if(strcmp($r['level'],'level_e')==0)
							 echo "Easy";
							else if(strcmp($r['level'],'level_m')==0)
							 echo "Medium";
							else if(strcmp($r['level'],'level_h')==0)
							 echo "Hard";
							 
						echo	"</span> 
						<input type=\"submit\" name=\"submitquestion\" id=\"submit\" value=\"Save\" onclick=\"\" class=\"subbtn\" disabled=\"disabled\" style=\" float:right;\" />
							<input type=\"submit\" name=\"updateq\" id=\"update\" value=\"Update\" onclick='' class=\"subbtn\" disabled=\"disabled\" style=\" float:right;\" />
							<input type=\"button\" name=\"editq\" id=\"editque\" onclick=\"doedit();\" value=\"Edit\" class=\"subbtn\" style=\" float:right;\" />
							
						</h3>
												<h3 style=\"margin:0px 0px;\">
							Question:<br/>
							<textarea id=\"ques\" name=\"ques\" class=\"ckeditor\" rows=\"10\" cols=\"125\" disabled=\"disabled\">".$r['question']."	</textarea>";
                                                        if($r['figure']){echo "<p id='image_showhide' style='text-align:center;'><img src='../image_data/$r[figure]' /><br/><span id='removepic_id' >Remove Pic:<input type='radio' name='rem_pic' value='r' /></span></p>";}  
                                                      echo  "<p id='attachment_id' hidden='hidden'>Attachment: <input type=\"file\" name=\"pic\" id=\"attachment\" disabled=\"disabled\"/></p>";
						echo "</h3>
						
						<h3 style=\"margin:0px 0px;\">
							Options:<br/>
							A)<input value=\"optiona\" onclick=\"assign_v();\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiona') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"a\" name=\"a\" rows=\"1\" cols=\"125\" disabled=\"disabled\">".$r['optiona']. "</textarea><br/>
							B)<input value=\"optionb\" onclick=\"assign_v();\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionb') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"b\" name=\"b\" rows=\"1\" cols=\"125\" disabled=\"disabled\">".$r['optionb']. " </textarea><br/>
							C)<input value=\"optionc\" onclick=\"assign_v();\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optionc') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"c\" name=\"c\" rows=\"1\" cols=\"125\" disabled=\"disabled\">".$r['optionc']. " </textarea><br/>
							D)<input value=\"optiond\" onclick=\"assign_v();\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optiond') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"d\" name=\"d\" rows=\"1\" cols=\"125\" disabled=\"disabled\">".$r['optiond']. "</textarea><br/>
							E)<input value=\"optione\" onclick=\"assign_v();\"  type=\"radio\" name=\"correct_answer\""; if($r['correct']=='optione') { echo "checked='checked'"; }echo " disabled=\"disabled\"/><textarea id=\"e\" name=\"e\" rows=\"1\" cols=\"125\" disabled=\"disabled\">".$r['optione']. " </textarea><br/>						</h3>		
						<h3 style=\"margin:0px 0px;\">
							<div id=\"imageupload\">
																				
							</div>
						</h3></form>";			
		break;



//Updating Question
case 4:
        $name='';
        $flag=false;
        
        if(!empty($_FILES['pic']['name']))
        {
            
            $name=time().".".basename($_FILES['pic']['type']);
            if(move_uploaded_file($_FILES['pic']['tmp_name'],"../image_data/".$name))
            {
                $flag=true;
                
            }
        }
        if($flag)
            $query="update subj_question set question='".htmlspecialchars($_REQUEST['ques'],ENT_QUOTES)."', figure='$name' ,optiona='".htmlspecialchars($_REQUEST['a'],ENT_QUOTES)."' ,optionb='".htmlspecialchars($_REQUEST['b'],ENT_QUOTES)."', optionc='".htmlspecialchars($_REQUEST['c'],ENT_QUOTES)."', optiond='".htmlspecialchars($_REQUEST['d'],ENT_QUOTES)."', optione='".htmlspecialchars($_REQUEST['e'],ENT_QUOTES)."', correct='".htmlspecialchars($_REQUEST['correct_answer'],ENT_QUOTES)."' where qnid_s='$_REQUEST[qnid_s]'";
        else if($_REQUEST['rem_pic']=='r')
            $query="update subj_question set question='".htmlspecialchars($_REQUEST['ques'],ENT_QUOTES)."', figure='' ,optiona='".htmlspecialchars($_REQUEST['a'],ENT_QUOTES)."' ,optionb='".htmlspecialchars($_REQUEST['b'],ENT_QUOTES)."', optionc='".htmlspecialchars($_REQUEST['c'],ENT_QUOTES)."', optiond='".htmlspecialchars($_REQUEST['d'],ENT_QUOTES)."', optione='".htmlspecialchars($_REQUEST['e'],ENT_QUOTES)."', correct='".htmlspecialchars($_REQUEST['correct_answer'],ENT_QUOTES)."' where qnid_s='$_REQUEST[qnid_s]'";
        else
            $query="update subj_question set question='".htmlspecialchars($_REQUEST['ques'],ENT_QUOTES)."', optiona='".htmlspecialchars($_REQUEST['a'],ENT_QUOTES)."' ,optionb='".htmlspecialchars($_REQUEST['b'],ENT_QUOTES)."', optionc='".htmlspecialchars($_REQUEST['c'],ENT_QUOTES)."', optiond='".htmlspecialchars($_REQUEST['d'],ENT_QUOTES)."', optione='".htmlspecialchars($_REQUEST['e'],ENT_QUOTES)."', correct='".htmlspecialchars($_REQUEST['correct_answer'],ENT_QUOTES)."' where qnid_s='$_REQUEST[qnid_s]'";
    
		if(executeQuery($query))
		{
		 echo "<script>window.location='createquestions.php?subid=$_REQUEST[subject]&level=$_REQUEST[level]&result=success';</script>";
		}
		else
		{
			echo "<script>window.location='createquestions.php?subid=$_REQUEST[subject]&level=$_REQUEST[level]&result=failure';</script>";
			//echo $query;
		}
		
		break;



case 5:
		if(executeQuery("delete from subj_question where qnid_s='$_REQUEST[question]'"))
		{
		 echo "<div class='message'>Successfully Deleted.</div>";
		}
		else
		{
			echo "There is some error..";
		}
	break;



case 6:
		if(executeQuery("insert into subject(`subid`,`subname`) values(DEFAULT,'$_REQUEST[subject]')"))
		{
		 $result=executeQuery("select * from subject order by subid");
		 
		 while($r=mysql_fetch_array($result))
		 {
		    echo "<option id='".$r['subid']."' value='".$r['subname']."'>".$r['subname']."</option>";
		 }
		}
		else
		{
			echo "There is some error..";
		}



	break;

case 7:
    $result=executeQuery("select totalquestions from test where testid=$_GET[testid]");
    $r=mysql_fetch_array($result);
    
    $result2=executeQuery("select * from level where testid=$_GET[testid]");
    $r2=mysql_num_rows($result2);
    
    if($r[0] == trim($_GET[count]) && $r2 >0)
    {
        //--------Calculating total marks of the test---------------------
        $total=0;
        $rr2=executeQuery("select level from subj_question where qnid_s in (select qnid_s from question where testid=$_GET[testid])");

        $rr3=executeQuery("select * from level where testid=$_GET[testid]");
        $row2=mysql_fetch_array($rr3);
        while($row=mysql_fetch_array($rr2))
        {
            $total+=$row2[$row[0]];
        }
        
        
        if($total > 0)
        {
            $r3=executeQuery("update test set total=$total,status=1 where testid=$_GET[testid]");
            if($r3)
            {
                echo "Test Launched Successfuly. Total Marks: $total";
            }
            else
            {
                echo "There is some Error Re-Try";
            }
        }
        else
        {
            echo "There is some Error Re-Try";
        }
    }
    else
    {
        if($r[0] != trim($_GET[count]))
            echo "Total Questions are not Set, Please check the count!";
        else
            echo "Test Marks for Easy, Medium, Hard are not Set!";
    }
    break;
	
	
case 8:
            $r3=executeQuery("update test set status=0 where testid=$_GET[testid]");
            if($r3)
            {
                echo "Test Disabled Successfuly.";
            }
            else
            {
                echo "There is some Error Re-Try";
            }
    
    break;
case 9:	$r3=executeQuery("UPDATE `sett` SET `metadata`='$_GET[m_data]' WHERE `key`='notice'");            if($r3)
            {
                echo "1";
            }            else
            {
                echo "-1";
            }
break;case 10:	$r=executeQuery("update sett set flag=$_GET[m_data] where `key`='batch'");	$r2=executeQuery("update sett set flag=$_GET[m_data2] where `key`='Error_Allowed'");	if($r && $r2)		echo "1";	else		echo "0";break;
}		
		
closedb();			
?>