
var qlog=new Array(total+1);		
for(var i=0;i<=total;i++)
{
	qlog[i]=0;
}

function fetch_q3(k)
{

	if(um == 1)
	{		
		fetch_nRep(k);
		um=0;
	}
	else
	{
		
		if(qlog[current]==1)
			qlog[current]=0;
		
		current=k;
		$("#qpanel").html($("#"+k+"qs").html());
		document.getElementById('q_no').innerHTML=current;
		showmarks(current);
		
		//Assigning a particular indiv
		if($('#form-0').find('#dispInp'+current).length)
		{
			if($('input:text[name="'+current+'anss"]').val().length)
			{
				$('#form-0').find('#dispInp'+k).find('#indiv').html($('input:text[name="'+current+'anss"]').val());
				txt=$('#form-0').find('#dispInp'+k).find('#indiv').html();
			}
			else
				txt="";
		}
		
		if(qlog[k]==0)
			$('#'+k+'d').attr("class", "not_answered");

    }
	
	chg=0;
}

function fetch_nRep(k)
{

    //alert($("#qpanel").html());

    $("#"+current+"qs").html($("#qpanel").html());
    current=k;
    $("#qpanel").html($("#"+k+"qs").html());
    document.getElementById('q_no').innerHTML=current;
	showmarks(current);

	if(qlog[k]==0)
		$('#'+k+'d').attr("class", "not_answered");
	
	if($('#form-0').find('#dispInp'+k).length)
	{
		if($('input:text[name="'+current+'anss"]').val().length)
			{
				$('#form-0').find('#dispInp'+k).find('#indiv').html($('input:text[name="'+current+'anss"]').val());
				txt=$('#form-0').find('#dispInp'+k).find('#indiv').html();
			}
			else
				txt="";
	}
	
	chg=0;
}

function save_next()
{
	if(qlog[current]==1 || qlog[current]==2 || qlog[current]==3 || qlog[current]==4 || $('#form-0').find('#dispInp'+current).find('#indiv').html() != "|")
	{
		
		//alert(qlog[current]);
		if(cur_ans != 'null')
		{			
			if(qlog[current]==2 || qlog[current]==4)
			{
				$('form[id^="form-"]').find("input:radio:checked").prop('checked',false);

                $("#"+current+"opta").removeAttr("checked");

                $("#"+current+"optb").removeAttr("checked");

                $("#"+current+"optc").removeAttr("checked");

                $("#"+current+"optd").removeAttr("checked");

                $("#"+current+"opte").removeAttr("checked");
			}

			qlog[current]=2;
			$('input:text[name="'+current+'anss"]').val($("#"+cur_ans).val());
			$("#"+cur_ans).attr('checked','checked');
			
			$('#'+current+'d').attr("class", "answered");
			cur_ans='null';
		}
		else if($('#form-0').find('#dispInp'+current).length && $('#form-0').find('#dispInp'+current).find('#indiv').html() != "|")
		{
			
			qlog[current]=2;
			$('input:text[name="'+current+'anss"]').val($('#form-0').find('#dispInp'+current).find('#indiv').html());
			txt="";
			$('#'+current+'d').attr("class", "answered");
		}
		else
		{
			if(qlog[current]==4)
				$('#'+current+'d').attr("class", "answered");

			cur_ans='null';
		}
		
		if(current == total)
			fetch_nRep(1);

		else
			fetch_nRep(current+1);

	}

	else
	{
		if(current == total)
			fetch_q3(1);

		else
			fetch_q3(current+1);
	}

}

