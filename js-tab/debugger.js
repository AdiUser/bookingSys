window.onload = function() {

    $('ul.tabs').tabs();

    $('select').material_select();
    $("select[required]").css({
        display: "inline",
        height: 0,
        padding: 0,
        width: 0
    });

    $("#date__rafting").datepicker_({
        minDate: 0,
    });

    $("#date_arr_site").datepicker_({
        minDate: 0,
    });
    
    $("#date_arr_camp").datepicker_({
        dateFormat: "dd-M-yy",
        minDate: 0,
        onSelect: function () {
            var dt2 = $('#date_dpr_camp');
            var startDate = $(this).datepicker_('getDate');
            //add 30 days to selected date
            startDate.setDate(startDate.getDate() + 30);
            var minDate = $(this).datepicker_('getDate');
            //minDate of dt2 datepicker = dt1 selected day
            dt2.datepicker_('setDate', minDate);
            //sets dt2 maxDate to the last day of 30 days window
            dt2.datepicker_('option', 'maxDate', startDate);
            //first day which can be selected in dt2 is selected date in dt1
            dt2.datepicker_('option', 'minDate', minDate);
            //same for dt1
            $(this).datepicker_('option', 'minDate', minDate);
        }
    });
    $('#date_dpr_camp').datepicker_({
        dateFormat: "dd-M-yy",
        onSelect: function(dataText) {
             
            var _in_time = $('#date_arr_camp').datepicker_('getDate').getTime();
            var _out_time = $('#date_dpr_camp').datepicker_('getDate').getTime();
            var days_camp = ((_out_time - _in_time)/ (1000*60*60*24)) + 1;
            $('#hidden_days_input_camp').val(days_camp);
        }
    });
    
    
    $("#date_arr_hotels").datepicker_({
        dateFormat: "dd-M-yy",
        minDate: 0,
        onSelect: function () {
            var dt2 = $('#date_dpr_hotels');
            var startDate = $(this).datepicker_('getDate');
            //add 30 days to selected date
            startDate.setDate(startDate.getDate() + 30);
            var minDate = $(this).datepicker_('getDate');
            //minDate of dt2 datepicker = dt1 selected day
            dt2.datepicker_('setDate', minDate);
            //sets dt2 maxDate to the last day of 30 days window
            dt2.datepicker_('option', 'maxDate', startDate);
            //first day which can be selected in dt2 is selected date in dt1
            dt2.datepicker_('option', 'minDate', minDate);
            //same for dt1
            $(this).datepicker_('option', 'minDate', minDate);
        }
    });
    $('#date_dpr_hotels').datepicker_({
        dateFormat: "dd-M-yy",
        onSelect: function(dataText) {
             
            var _in_time = $('#date_arr_hotels').datepicker_('getDate').getTime();
            var _out_time = $('#date_dpr_hotels').datepicker_('getDate').getTime();
            var days_camp = ((_out_time - _in_time)/ (1000*60*60*24)) + 1;
            $('#hidden_input_days_hotels').val(days_camp);
        }
    });
    
    
     $("#date_arr_homestay").datepicker_({
        dateFormat: "dd-M-yy",
        minDate: 0,
        onSelect: function () {
            var dt2 = $('#date_dpr_homestay');
            var startDate = $(this).datepicker_('getDate');
            //add 30 days to selected date
            startDate.setDate(startDate.getDate() + 30);
            var minDate = $(this).datepicker_('getDate');
            //minDate of dt2 datepicker = dt1 selected day
            dt2.datepicker_('setDate', minDate);
            //sets dt2 maxDate to the last day of 30 days window
            dt2.datepicker_('option', 'maxDate', startDate);
            //first day which can be selected in dt2 is selected date in dt1
            dt2.datepicker_('option', 'minDate', minDate);
            //same for dt1
            $(this).datepicker_('option', 'minDate', minDate);
        }
    });
    $('#date_dpr_homestay').datepicker_({
        dateFormat: "dd-M-yy",
        onSelect: function(dataText) {
             
            var _in_time = $('#date_arr_homestay').datepicker_('getDate').getTime();
            var _out_time = $('#date_dpr_homestay').datepicker_('getDate').getTime();
            var days_camp = ((_out_time - _in_time)/ (1000*60*60*24)) + 1;
            $('#hidden_days_input_homestay').val(days_camp);
        }
    });
    
    
    
    



}
