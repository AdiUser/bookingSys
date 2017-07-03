
function countDown() {
      sec--;
  if (sec == -01) {
    sec = 59;
    min = min - 1;
    if(min==-01)
        {
            min=59;
            hour=hour-1;
        }else
            {
                hour=hour;
            }
  } else {
   min = min;
  }
if (sec<=9) {sec = "0" + sec;}

  time = (hour<=9 ? "0" + hour : hour) + " : " + (min<=9 ? "0" + min : min) + " : " + sec + "";
if (document.getElementById) {document.getElementById('timer').innerHTML = time;}
if (hour=='00'&& min == '00' && sec == '00') {sec = "00";min="00"; window.clearTimeout(SD); testOver();}
  SD=window.setTimeout("countDown();", 1000);
  
  if (hour=='02'&& min == '59' && sec == '59')
{
	$('#faadu_message').html("All the Best! Do well.");
	$('#faadu_message').slideDown(1000);
	setTimeout(function(){$('#faadu_message').slideUp(1000);}, 15000);
}



}

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
  countDown();
});