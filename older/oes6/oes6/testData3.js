var current=1;
var cur_ans='null';
var um=0;
var chg=0;
function startTest()
{
   $('#container').fadeIn('slow');
   $('#msg_area').hide();
   $('#prev_but').hide();
   if($.cookie(ssid+tid+"test") && $.cookie(ssid+tid+"test")=="progress") 
       {
           hour=$.cookie(ssid+tid+"hr");
           min=$.cookie(ssid+tid+"min");
           sec=$.cookie(ssid+tid+"sec");
       }
   else
       {
           mark_start();
       }
  
		var date= new Date();
		date.setTime(date.getTime()+(500*60*1000));
      
		$.cookie(ssid+tid+"test","progress",{expires:date});
      
      // --------------Display 1st Question---------------------
        $("#qpanel").html($("#"+1+"qs").html());
        $('.sel').removeClass('sel');
        document.getElementById(1+'d').className="sel";
        document.getElementById('q_no').innerHTML="1";
		showmarks(1);
		$('#1d').attr("class", "not_answered");
        
        countDown();
        
        
}

function load_comp()
{
    $('#container').hide();
    $('#quest_store').hide();
    //document.getElementById('msg_area').innerHTML="<div style='padding:10px;width:45%;position:absolute;top:10%;left:27%;background-color:#ffffff;'><h1 id='h_msg' style='text-align:center;' >Loading Questions....</h1><ul style='text-align: left;font-size: 140%;' align='center'><li> Use <b>'UP'</b> and <b>'DOWN'</b> buttons to navigate through questions.</li><li> Use <b>'A', 'B', 'C', 'D'</b> buttons to mark the right answer.</li><li> Use <b>'U'</b> button to un-mark a question.</li><li> All these can also be done with mouse clicks.<b>(Recommended)</b></li><li> Once you complete the test, you cannot re-appear unless the Admin resets it.</li><li> You session is auto-saved, incase power loss, you can resume it.</li><li style='color:red' >Please keep note of your answers to be in safe side.</li></ul><p id='lod_but' style='text-align:center;'><img src='images/loading.gif' /></p></div>";
    fetch_all(tid);
}

function fetch_all(testid)
{

    $.ajax({url:"prepareTest.php?getTest="+testid,success:function(result){
                                $('#pWait').hide();
                                document.getElementById('quest_store').innerHTML=result;
                                //document.getElementById('lod_but').innerHTML="<input type='button' value='START' onclick='startTest();' style='padding:10px;' />";
                                //document.getElementById('h_msg').innerHTML="The Timer will Start as you Press the Start Button. All The Best!";
    },
	error: function(){
			alert('Connection Timeout.Reload Page!');
		}
    });
}
//-------------Question Fecthing from Local----------------

function showmarks(qk)
{
	$('#show_marks').html($('#marks'+qk).html());
}

function fetch_q(k)
{
    
    $("#"+k+"qs").html($("#qpanel").html());
    current=++k;
    $("#qpanel").html($("#"+k+"qs").html());
    $('.sel').removeClass('sel');
    document.getElementById(k+'d').className="sel";
    document.getElementById('q_no').innerHTML=current;
    
    if(current > 1){ $('#prev_but').show(); }
    if(current == total){ $('#next_but').hide(); }
	showmarks(current);
    
}
function fetch_q1(k)
{
    
    $("#"+k+"qs").html($("#qpanel").html());
    current=--k;
    $("#qpanel").html($("#"+k+"qs").html());
    $('.sel').removeClass('sel');
    document.getElementById(k+'d').className="sel";
    document.getElementById('q_no').innerHTML=current;
    
    if(current < total){ $('#next_but').show(); }
    if(current == 1){ $('#prev_but').hide(); }
	showmarks(current);
    
}
function fetch_q2(k)
{
    //alert($("#qpanel").html());
    $("#"+current+"qs").html($("#qpanel").html());
    current=k;
    $("#qpanel").html($("#"+k+"qs").html());
    
    $('.sel').removeClass('sel');
    document.getElementById(k+'d').className="sel";
    document.getElementById('q_no').innerHTML=current;
    
    if(current > 1){ $('#prev_but').show(); }
    if(current == total){ $('#next_but').hide(); }
    
    if(current < total){ $('#next_but').show(); }
    if(current == 1){ $('#prev_but').hide(); }
	showmarks(current);
    
}

function testOver()
{
    $('#msg_area').hide();
    document.getElementById('container').innerHTML="<h1 style='text-align:center;margin:35px;' >Your Test is Over, Submit When you are asked to Submit.</h1><p id='res_box' ><input style='padding:15px;' type='button' value='Submit Test' onclick='submitTest();' ></p>";
    $.removeCookie(ssid+tid+"test");
    $.removeCookie(ssid+tid+"min");
    $.removeCookie(ssid+tid+"sec");
    $.removeCookie(ssid+tid+"hr");
	
    $.ajax({url:"prepareTest.php?over="+tid+"&ssid="+ssid,success:function(result){
            
            //alert(result);
        
        }
    });
    
    
}
function submitTest()
{
    //alert('1');
    document.getElementById('res_box').innerHTML="<img src='images/loading.gif' />";
    var datastring = $("#ansForm").serialize();
    $.ajax({
            type: "POST",
            url: "prepareTest.php",
            data: datastring,
            success: function(data) {
				document.getElementById('res_box').innerHTML="";
                document.getElementById('res_box').innerHTML=data;
                $('#res_box').css("background-color","rgb(242, 221, 251)");
            },
            error: function(){
                  
				  document.getElementById('container').innerHTML="<h1 style='text-align:center;margin:35px;' >Wait There is Network Congestion.</h1><p id='res_box' ><span style='color:red;font-weight:bold;' >Please do not Close this Window! Keep Try Re-Submitting.</span> <br/><br/><input style='padding:15px;' type='button' value='Submit Test' onclick='submitTest();' ></p>";
    
            }
        });
        /*
    $.ajax({url:"prepareTest.php?result="+tid,success:function(result){
    
        document.getElementById('res_box').innerHTML=result;
    }
    
    }); */
}
function mark_start()
{
    $.ajax({url:"prepareTest.php?start="+tid,success:function(result){
            
            //alert(result);
        
        }
    });
}

function answer_q(stdid,testid,qid,stdans)
{
    
	if(qlog[qid]==0)
		qlog[qid]=1;
	cur_ans=stdans;
	
	chg=1;
    //-------Local Content Saving for Resume Capability------------
	/*
	var date= new Date();
    date.setTime(date.getTime()+(500*60*1000));
	
    var thenum = stdans.replace( /\D+$/g, '');
	var theopt = stdans.replace( thenum, '');
	//alert(thenum+" "+theopt);
    
    $.cookie(thenum,theopt,{expires:date});
    */
}
function unmark()
{
	$('input:text[name="'+current+'anss"]').val("");
    
    $('form[id^="form-"]').find("input:radio:checked").prop('checked',false);
                                        $("#"+current+"opta").removeAttr("checked");
                                        $("#"+current+"optb").removeAttr("checked");
                                        $("#"+current+"optc").removeAttr("checked");
                                        $("#"+current+"optd").removeAttr("checked");
                                        $("#"+current+"opte").removeAttr("checked");
	$('#'+current+'d').attr("class", "not_answered");
	
	if($('#form-0').find('#dispInp'+current).length)
	{
		$('#form-0').find('#dispInp'+current).find('#indiv').html("|");
		txt="";
	}
	
	qlog[current]=0;
	//alert(qlog[current]);
	um=1;
	//$.removeCookie(qid);
    
}

function mark_ans(opt)
{
    //$('input:radio[name="answer"]').attr('checked', false);
    $("input[type='radio'][value='"+opt+"']").attr('checked',true);
    answer_q(ssid,tid,current,opt);
}

function conf_fin()
{
    $('#msg_area').html("<div style='border-radius:10px;opacity:0.8;padding:10px;width:600px;position:fixed;top:40%;left:25%;background-color:#000000;color:#ffffff;text-align:center;'><h2>Confirm Finished?</h2><p style='padding:15px;'><input type='button' value='Finish' onclick='testOver();' /> <input type='button' value='Cancel' onclick='$(\"#msg_area\").hide();' /></p></div>");
    $('#msg_area').fadeIn('fast');
}

function review()
{
	//alert(chg);
    if(qlog[current]==1 || qlog[current]==2 || qlog[current]==4 || qlog[current]==3 && cur_ans != 'null' || ($('#form-0').find('#dispInp'+current).length && $('#form-0').find('#dispInp'+current).find('#indiv').html() != "|"))
	{
		if(chg == 1)
		{
			if(qlog[current]==2 || qlog[current]==4 )
				{
					$('form[id^="form-"]').find("input:radio:checked").prop('checked',false);
					$("#"+current+"opta").removeAttr("checked");
					$("#"+current+"optb").removeAttr("checked");
					$("#"+current+"optc").removeAttr("checked");
					$("#"+current+"optd").removeAttr("checked");
					$("#"+current+"opte").removeAttr("checked");
					
				}
				
				$('input:text[name="'+current+'anss"]').val($("#"+cur_ans).val());
				$("#"+cur_ans).attr('checked','checked');
				
				chg=0;
		}
		if($('#form-0').find('#dispInp'+current).length)
		{
			$('input:text[name="'+current+'anss"]').val($('#form-0').find('#dispInp'+current).find('#indiv').html());
		}
			
			$('#'+current+'d').attr("class", "review_answered ");
			cur_ans='null';
			qlog[current]=4;
			
			if(current == total)
				fetch_nRep(1);
			else
				fetch_nRep(current+1);
	}
	else
	{
		qlog[current]=3;
		$('#'+current+'d').attr("class", "review");
		
		if(current == total)
			fetch_q3(1);
		else
			fetch_q3(current+1);
		
	}
}