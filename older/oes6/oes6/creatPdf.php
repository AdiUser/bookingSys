<?php
// -----Info-----
session_start();
if(!isset($_GET['key']))
{
	echo "Access Denied!";
	exit;
}
ini_set('max_execution_time', 180);
require_once 'dbsettings.php';
$db=mysqli_connect($dbserver,$dbusername,$dbpassword,$dbname) or die('Error');

$query="select testname,testdesc from test where testid=$_GET[testid]";
$r3=mysqli_query($db,$query) or die('Error3');
$row3=mysqli_fetch_array($r3);

$query="select starttime from studenttest where testid=$_GET[testid] and stdid=$_GET[ssid]";
$r4=mysqli_query($db,$query) or die('Error3');
$row4=mysqli_fetch_array($r4);

$query="select stdname from student where stdid=$_GET[ssid]";
$r5=mysqli_query($db,$query) or die('Error3');
$row5=mysqli_fetch_array($r5);

    $query="select q.qnid,s.question,s.figure,s.optiona,s.optionb,s.optionc,s.optiond,s.optione,s.correct,s.type from question as q inner join subj_question as s on q.qnid_s=s.qnid_s  where q.testid=$_GET[testid] order by q.qnid";
    $r=mysqli_query($db,$query) or die('Error3');
    
    
    
 
ob_start();
?>
    
<page backtop='10mm' backbottom='15mm' backleft='5mm' backright='10mm' footer='page'  >
    <page_header> 
                
		<p style="font-size: 11px;"> <b>Test :</b>  <?php echo $row3[0]; ?> <b>Date :</b> <?php echo $row4[0]; ?> <b>Name :</b><?php echo $row5[0]; ?></p>
    </page_header> 
        
    <page_footer> 		
	<p style="text-align: right;margin-right: 90px;margin-bottom: 18px;font-size: 12px;">
                 RAMAN CLASSES 2013-14
        </p>     
    </page_footer> 
    <p>
		<div style="padding:10px;text-align:center;font-weight:bold;border:2px solid blue;font-size:20px;color:#900818;" ><?php echo $row3[1]; ?></div>
        <?php
        while($row=mysqli_fetch_array($r))
        {
            $query="select stdanswer,marks from studentquestion where stdid=$_GET[ssid] and testid=$_GET[testid] and qnid=$row[0]";
            $r2=mysqli_query($db,$query) or die('Error3');
            $row2=  mysqli_fetch_array($r2);
        ?>
        <div style="margin:10px;padding:10px;font-size: 14px;">
        <table >
            <tr style="width:650px;" >
                <th colspan="2" style="padding:5px;" >Q<?php echo $row[0].". ".nl2br($row[1]); ?></th>
                
            </tr>
            <?php
            if(!isset($_GET['key']))
			{
				if($row[9] == "MC")
				{
					if(trim($row[2])){echo "<tr><td colspan='2' ><img src='image_data/$row[2]' /></td></tr>";}
					?>
					<tr>
						<td style="width:300px;<?php if($row[8] == 'optiona') {echo "background-color: #b9fdbb;";} if($row2[0]=='optiona'){echo "color: #6577f1;font-weight:bold;";} ?>padding:8px;"><strong>a)</strong> <?php echo $row[3]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;<?php if($row[8] == 'optionb') {echo "background-color: #b9fdbb;";} if($row2[0]=='optionb'){echo "color: #6577f1;font-weight:bold;";} ?>padding:8px;"><strong>b)</strong> <?php echo $row[4]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;<?php if($row[8] == 'optionc') {echo "background-color: #b9fdbb;";} if($row2[0]=='optionc'){echo "color: #6577f1;font-weight:bold;";} ?>padding:8px;"><strong>c)</strong> <?php echo $row[5]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;<?php if($row[8] == 'optiond') {echo "background-color: #b9fdbb;";} if($row2[0]=='optiond'){echo "color: #6577f1;font-weight:bold;";} ?>padding:8px;"><strong>d)</strong> <?php echo $row[6]; ?></td>
					</tr>
					<?php if(trim($row[7])){echo "<tr><td style='";
					if($row[8] == 'optione'){ echo "background-color: #b9fdbb;";}
					if($row2[0]=='optione'){echo "color: #6577f1;font-weight:bold;";}
					echo "padding:8px;' ><strong>e</strong>) $row[7]</td> </tr>";}
				}
				else
				{
					?>
					<tr>
						<td style="width:300px;padding:8px;"><strong>Correct Answer: </strong> <?php echo $row[8]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;padding:8px;<?php if($row2[1] >0 ) { echo "background-color: #b9fdbb;";} else { echo "background-color: #FCBDCD;";} ?>"><strong>Your Answer: </strong> <?php  echo $row2[0] ?></td>
					</tr>
					<?php
				}
			}
			else
			{
				if($row[9] == "MC")
				{
					if(trim($row[2])){echo "<tr><td colspan='2' ><img src='image_data/$row[2]' /></td></tr>";}
					?>
					<tr>
						<td style="width:300px;padding:8px;"><strong>a)</strong> <?php echo $row[3]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;padding:8px;"><strong>b)</strong> <?php echo $row[4]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;padding:8px;"><strong>c)</strong> <?php echo $row[5]; ?></td>
					</tr>
					<tr>
						<td style="width:300px;padding:8px;"><strong>d)</strong> <?php echo $row[6]; ?></td>
					</tr>
					<?php if(trim($row[7])){echo "<tr><td style='";
					echo "padding:8px;' ><strong>e</strong>) $row[7]</td> </tr>";}
				}
			}
			?>
     </table> 
        </div>
    <hr/>
    <?php
        } 
    ?>
    <div style="border:1px solid black;margin: 10px;padding: 10px;">
        <?php
            $correct=0;
            $score=0.0;
            $attpt=0;

            $r=mysqli_query($db,"select testname,totalquestions,total from test where testid=$_GET[testid]");
            $row=  mysqli_fetch_array($r);

            $r2=mysqli_query($db,"select count(*) from studentquestion where testid=$_GET[testid] and stdid=$_GET[ssid]");
            $row2=mysqli_fetch_array($r2);
            
            $r4=mysqli_query($db,"select correctlyanswered,score from studenttest where testid=$_GET[testid] and stdid=$_GET[ssid]");
            $row4=  mysqli_fetch_array($r4);
            $p=($row4[1]/$row[2])*100;

    ?>
    <table align="center">
        <tr>
            <th style="padding:5px;"> Test </th>
            <td style="padding:5px;" ><?php echo $row[0]; ?></td>
        </tr>
        <tr>
            <th style="padding:5px;" > Total Questions </th>
            <td style="padding:5px;" ><?php echo $row[1]; ?></td>
        </tr>
        <tr>
            <th style="padding:5px;" > Total Attempted </th>
            <td style="padding:5px;" ><?php echo $row2[0]; ?></td>
        </tr>
        <tr>
            <th style="padding:5px;" > Total Correct </th>
            <td style="padding:5px;" ><?php echo $row4[0]; ?></td>
        </tr>
        <tr>
            <th style="padding:5px;" > Total Score </th>
            <td style="color:red;padding:5px;"><?php echo "$row4[1] / $row[2]"; ?></td>
        </tr>
        <tr>
            <th style="padding:5px;" > Percentage </th>
            <td style="color:blue;padding:5px;"><?php echo round($p,2)." %"; ?></td>
        </tr>
        
    </table>
   
    </div>       
    </p>
</page>
<?php
    mysqli_close($db);
    $content = ob_get_clean();
	
    require_once('html_pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A3','en' , false, 'UTF-8');
    $html2pdf->WriteHTML($content);
	if(!isset($_GET['key']))
	{
		$html2pdf->Output("$row3[0]_solution.pdf");
	}
	else
	{
		$html2pdf->Output("$row3[0]_questions.pdf");
	}
    //$html2pdf->Output('../all_Patients/exemple.pdf','F');
?>
