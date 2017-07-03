<?php
//require_once 'checkBrowser.php';
session_start();
if(!isset($_SESSION['stdname'])) {
    echo "Session Timeout";
}
if( !isset($_GET['testid']) || !isset($_GET['dur']) || !isset($_GET['tot']) )
{
	echo "<h1>Access Denied!</h1>";

		exit;
}
include_once 'oesdb.php';

	$r2=executeQuery("select status from test where testid=$_GET[testid]");
	$row22=mysql_fetch_array($r2);
	if($row22[0] == 0)
	{
		echo "<h1>Access Denied!</h1>";
		closedb();
		exit;
	}


$r=executeQuery("select starttime,status from studenttest where stdid=$_SESSION[stdid] and testid=$_GET[testid]");
if(mysql_num_rows($r) > 0)
{
		$row=mysql_fetch_array($r);
		if($row[1] == 'over')
		{
			echo "<h1>You have already attempted the test on: $row[0]</h1>";
			closedb();
			exit;
		}
}

if(isset($_SESSION['test']) &&  $_SESSION['test'] == "on")
{
	echo "<h1>You have already started a Test. You cannot appear in more than one Test at a time.</h1>";
	exit;
}


$rr3=executeQuery("select duration,totalquestions from test where testid=$_GET[testid]");
	$row3=mysql_fetch_array($rr3);
	$dur=$row3[0];
	$tot=$row3[1];

closedb();

?>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>GEU Online Test</title>
    <link rel="stylesheet" type="text/css" href="gate_st.css"/>
    <script type="text/javascript" src="jquerycookie.js"></script>
    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer3.js" ></script>
    <script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="lib/jqueryajax.js"></script>
    <script type="text/javascript" src="lib/jquery.cookie.js"></script>
    <script type="text/javascript" src="lib/grunt.js"></script>
    <script type="text/javascript" src="lib/jqueryajax.js"></script>
    <script type="text/javascript" >
        var hour;
        var min;
        var sec;
        var tid='<?php echo $_GET['testid']; ?>';
        var total=<?php echo $_GET['tot']; ?>;
        var ssid='<?php echo $_SESSION['stdid']; ?>';

		var date= new Date();
        date.setTime(date.getTime()+(500*60*1000));

        <?php if(isset($_SESSION['resume']) && $_SESSION['resume']=="on")
            { ?>
                if(!$.cookie(ssid+tid+"test"))
                    {
                        alert('Open Test on same browser, that you have closed last time.');
                        window.location='logout.php';
                    }

            <?php }
            else {?>
            hour=<?php echo floor($_GET['dur']/60); ?>;
            min=<?php echo ($_GET['dur']%60); ?>;
            sec=1;


           <?php }?>
        //--------DEFAULT---------
			var txt="";
			function typeIn(k)
			{
				if(k != "dot" && k != "minus" && k != "bksp" )
				{
					var n=k.substring(2,k.length);
					txt=txt+n;
					$("#indiv").html(txt);
				}
				else
				{
					if($("#indiv").html() != "|")
					{
						if(k == "bksp")
							txt=txt.substring(0,txt.length-1);
						if(k == "dot")
							txt=txt+".";
					}
					else
					{
						if(k == "minus")
						{
							txt="-";
						}
					}

						$("#indiv").html(txt);
						if($("#indiv").html() == "")
						{
							$("#indiv").html("|");
						}
				}
			}


        //Auto saving state after some interval
        $(document).ready(function(){
		$('#faadu_message').hide();
		$('#readylink').hide();
		$('#secondPagep2').hide();
		$('#secondPagep1').hide();
		$('#full_paper_bg').hide();
		$('#full_paper').hide();
		$('#inpBoxStore').hide();

            setInterval(function ()
                {
                    if($.cookie(ssid+tid+"test") == 'progress')
                        {
                            $.cookie(ssid+tid+"hr",hour,{expires:date});
                            $.cookie(ssid+tid+"min",min,{expires:date});
                            $.cookie(ssid+tid+"sec",sec,{expires:date});


                        }

                },5000);


        });

        // Preveventing Right Click
                    var oLastBtn=0;
                        bIsMenu = false;
                        //No RIGHT CLICK************************
                        // ****************************
                        if (window.Event)
                        document.captureEvents(Event.MOUSEUP);
                        function nocontextmenu()
                        {
                        event.cancelBubble = true
                        event.returnValue = false;
                        return false;
                        }
                        function norightclick(e)
                        {
                        if (window.Event)
                        {
                        if (e.which !=1)
                        return false;
                        }
                        else
                        if (event.button !=1)
                        {
                        event.cancelBubble = true
                        event.returnValue = false;
                        return false;
                        }
                        }
                        document.oncontextmenu = nocontextmenu;
                        document.onmousedown = norightclick;
                        //**************************************
                        // ****************************
                        // Block backspace onKeyDown************
                        // ***************************
                         function onKeyDown() {
                                if ( (event.altKey) || ((event.keyCode == 8) &&
                                                (event.srcElement.type != "text" &&
                                                event.srcElement.type != "textarea" &&
                                                event.srcElement.type != "password")) ||
                                                ((event.ctrlKey) && ((event.keyCode == 78) || (event.keyCode == 82)) ) ||


                                                (event.keyCode == 116) ) {
                                        event.keyCode = 0;
                                        event.returnValue = false;
                                }
                         }


         // Preveneting button
         document.onkeydown = function()
                    {
                        //alert(event.keyCode);

                        switch (event.keyCode)
                        {

                            case 116 : //F5 button
                                event.returnValue = false;
                                event.keyCode = 0;
                                event.stopPropagation();
                                return false;
                            case 82 : //R button
                                if (event.ctrlKey)
                                {
                                    event.returnValue = false;
                                    event.keyCode = 0;
                                    event.stopPropagation();
                                    return false;
                                }
                            case 8 : //Backspace button
                                event.returnValue = false;
                                event.keyCode = 0;
                                event.stopPropagation();
                                return false;

                        }

                    }


    </script>
    <script type="text/javascript" src="testData3.js" ></script>
	<script type="text/javascript" src="gate_sc.js" ></script>
    <style type="text/css" >
		#inpBox table tr td {
			padding:10px 20px;
			background-color:white;
		}

		#inpBox table tr td:hover {
			color:blue;
			cursor:pointer;
			background-color:lightgrey;
		}
	</style>
    </head>
    <body onLoad="load_comp();" >
        <h2 style="color:red;" align="center" ><noscript>For the proper Functionality, You must use Javascript enabled Browser.<br>Sorry for the Inconvenience..Please Try Again..</noscript></h2>

      <div id="container" >
	  	<div id="header" >
		<div id="faadu_message" style="padding-top:8px;margin-top:6px;text-align:center;color:white; position:fixed;top:0;left:0px;width:100%;height:42px; z-index:999; background-color:green;font-weight:bold;font-size:30px;"> </div>
			 <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
				  <tr>
					<td align="left" id="bannerImage">
						<div style="margin-top:10px;text-align:center;">

							<font size="4" color="#ffffff">
								<b>

									GEU ONLINE TEST

								</b>
							</font>

						</div>
					</td>
				  </tr>
				</tbody>
			  </table>
		</div>

      <div style="width:100%;">

          <!-- CCFFFF--------------------Right Panel for Question List display------------------------ #fae6f6 -->
		  <div style="background-color: rgb(228, 237, 247);margin-top:-5px;float:right;width:250px;height:88%; padding:5px;;overflow:auto;" id="lpanel">
			<div style="background-color:white;margin:3px;text-align:center;" >
				<h3>Timer: &nbsp;&nbsp; <span id="timer" class="timerclass"></span></h3>
			</div>
			<div style="height:345px;overflow:auto;padding-left:10px;" >
              <table>
                  <?php
                  $r=1;
                  while($r <= $_GET['tot'])
                  {

                    echo "<tr>";

					echo "<td><div id='".$r."d' class='not_visited'  onclick='fetch_q3($r)' style='cursor:pointer;' >$r</div></td>";
					$r++;
					if($r > $_GET['tot']) break;
					echo "<td><div id='".$r."d' class='not_visited'  onclick='fetch_q3($r)' style='cursor:pointer;' >$r</div></td>";
					$r++;
					if($r > $_GET['tot']) break;
					echo "<td><div id='".$r."d' class='not_visited'  onclick='fetch_q3($r)' style='cursor:pointer;' >$r</div></td>";
					$r++;
					if($r > $_GET['tot']) break;
					echo "<td><div id='".$r."d' class='not_visited'  onclick='fetch_q3($r)' style='cursor:pointer;' >$r</div></td>";
					$r++;

					echo "</tr>";
          }
          closedb();
          ?>
          </table>
			  </div>
			<div style="position:relative;bottom:0px;margin:5px;" >
			<p>
			<img src='images/legend.png' />
			</p>
			<p style="margin-top:10px;border-top:black 1px solid;padding-top:10px;" >
				<input type="button" onClick="full_paper();" style="cursor: pointer;padding:3px; background-color: rgb(228, 237, 247); font-size:14px;" value="Question Paper" />
					<input type="button" onClick="conf_fin();" style="cursor: pointer; padding:3px;background-color: rgb(228, 237, 247);font-size:14px;" value="Submit" />
				</p>

			</div>
          </div>

          <div class="tc" id="main_tc" style="width:80%;margin-top: 10px; height:508px;">
			<div style="border:1px solid black; padding:5px;" >

								<div id="show_marks" style="font-size:14px;float:right;font-weight:bold;"></div>
								<div style="color: #af0a36;font-size:18px;font-weight:bold;">Question No: <span id="q_no">1</span></div>

			</div>

			  <div>
				<!-- Question panel Starts -->
				  <div id="qpanel" style="height:100%;width:100%;" >

				  </div>
				<!-- Question panel Ends -->
				  <div style="border:1px solid grey;padding:3px;" >

					<input type="button" onClick="save_next();" style="cursor: pointer;float:right;padding:3px;background-color: rgb(97, 139, 252);font-size:14px;" value="Save and Next" />

					<input type="button" onClick="review();" style="cursor: pointer;padding:3px; background-color: rgb(228, 237, 247); font-size:14px;" value="Mark for Review and Next" />
					<input type="button" onClick="unmark();" style="cursor: pointer; padding:3px;background-color: rgb(228, 237, 247);font-size:14px;" value="Clear Response" />

				  </div>
			  </div>
        </div>
      </div>
    </div>

    <div id="msg_area">
        <div id="pWait" style="background:grey;height:100%;width:100%;z-index:1999;position:absolute;opacity:0.8;filter:alpha(opacity=40);">
			<div style="top:45%;position:relative;color:white">
			<center><img src="images/loading.gif" style="height:50px;width:50px;display:block;"/><br/><h2>Please wait</h2>
			<p style="color:yellow;" >(Loading all Questions and Images, will take sometime depending upon the connection speed.)</p>
			</center>
			</div>
		</div>

		<div id="header" >
			 <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
				  <tr>
					<td align="left" id="bannerImage">
						<div style="margin-top:10px;text-align:center;">

							<font size="4" color="#ffffff">
								<b>

									GEU ONLINE TEST

								</b>
							</font>

						</div>
					</td>
				  </tr>
				</tbody>
			  </table>
		</div>
			<div id="mainleft" style="margin-left:3px;width:79%;">
				<div id="firstPage" style="overflow:auto;border:1px #CCC solid;padding:2px">
					<iframe src="genins.html" height="80%" width="99%" ></iframe>
				</div>
				<div id="secondPagep1" style="overflow:auto;display:none;border:1px #CCC solid;padding:2px">
					<iframe src="csins.html" height="70%" width="99%" ></iframe>
				</div>
				<div id="instPagination" style="padding:10px;" ><center><a id="instPaginationa" onclick="showNext()" alt="" style="color:blue;font-weight:bold;cursor:pointer;" >Next >></a></center></div>
				<div id="secondPagep2" >

					<span class="highlightText">
						<table><tr><td><input type="checkbox" id="disclaimer" onclick="linkdisp(this.id);"> </input></td>
						<td><span style="width:90%:float:left;color:red;font-weight:bold;">The computer provided to me is in proper working condition. I have read and understood the instructions given above.</span></td></tr></table>
					</span>
					<br/>
					<center><span><font size="5" ><input type='button' style='padding:10px;' value='I am ready to begin' id="readylink" onclick="startTest();" /></font></span></center>
					<br/>
				</div>

			</div>
			<div id="footer">

				<div style="width:100%;padding-top:15px;">
					<center>
						<font color="white">

							 Version : 1.1

						</font>
					</center>
				</div>

			</div>

	</div>



        <div id="quest_store">
        </div>

		<div id="full_paper_bg" style="position:fixed;z-index:990;top:0px; bottom:0px; left:0px; right:0px; background-color:black; opacity:0.8;" >
			<div style="float:right; "> <img src="./images/close.png" style="opacity:1;width:50px;height:50px;" onClick='full_paper_hide();' ></div>
		</div>
		<div id="full_paper" style="position:fixed;top:0px; bottom:0px; left:5%; right:5%; height:100%; background-color:white; overflow:auto; opacity:1;z-index:999;">


		</div>
		<div id="inpBoxStore" >
			<div id="inpBox" style="width:15%;height:50%;background-color:grey;border:1px solid black;" >
			<div id="indiv" style="width:95%;height:14%;background-color:white;margin-top:1%;margin-left:1%;padding:1%;font-weight:bold;" >|</div>
			<table>
				<tr>
					<td id="di1" onclick="typeIn(this.id);" >1</td>
					<td id="di2" onclick="typeIn(this.id);" >2</td>
					<td id="di3" onclick="typeIn(this.id);" >3</td>
				</tr>
				<tr>
					<td id="di4" onclick="typeIn(this.id);" >4</td>
					<td id="di5" onclick="typeIn(this.id);" >5</td>
					<td id="di6" onclick="typeIn(this.id);" >6</td>
				</tr>
				<tr>
					<td id="di7" onclick="typeIn(this.id);" >7</td>
					<td id="di8" onclick="typeIn(this.id);" >8</td>
					<td id="di9" onclick="typeIn(this.id);" >9</td>
				</tr>
				<tr>
					<td id="dot" onclick="typeIn(this.id);" ><strong>.</strong></td>
					<td id="di0" onclick="typeIn(this.id);" >0</td>
					<td id="minus" onclick="typeIn(this.id);" ><strong>-</strong></td>
				</tr>
				<tr>
					<td colspan="3" id="bksp" onclick="typeIn(this.id);"  >Backspace</td>
				</tr>
			</table>
			</div>
		</div>
    </body>

	<script>
	function full_paper()
	{
		$('#full_paper_bg').fadeIn(400);
		$('#full_paper').slideDown(400);
		$('#full_paper').html($('#full_paper_retrieve').html());

	}
	function full_paper_hide()
	{
		$('#full_paper_bg').fadeOut(300);
		$('#full_paper').slideUp(400);

	}
	function showNext()
	{
		$('#firstPage').hide();
		$('#secondPagep1').show();
		$('#instPaginationa').html("<< Previous");
		$('#instPaginationa').attr("onclick","showPrev()");
		$('#secondPagep2').show();
	}
	function showPrev()
	{

		$('#secondPagep1').hide();
		$('#firstPage').show();
		$('#instPaginationa').html("Next >>");
		$('#instPaginationa').attr("onclick","showNext()");
		$('#secondPagep2').hide();
	}
	function linkdisp(k)
	{
		if($('#'+k).is(':checked'))
			$('#readylink').show();
		else
			$('#readylink').hide();
	}
	</script>
</html>
