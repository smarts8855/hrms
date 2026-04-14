//submit Staff name on Ongoing staff
$('#staffName').change( function(){ 
   $('#searchStaffUserID').submit();
}); 

//submit courtID to populate staff name
$('#staffCourtPostByJson').change( function(){ 
    $('#staffCourt').val($('#staffCourtPostByJson').val());
    $('#PostCourtID').submit();
}); 

    

$( function() {
        $("#empdate").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true, 
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst){
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
                $("#empdate").val(dateFormatted);
            },
        });

  } );

$( function() {
        $("#dob").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true, 
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst){
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                $("#dateOfBirth").val(dateFormatted);
            },
        });
  } );

(function () {
    $('#getcourt').change( function(){
        $.ajax({
            url: murl +'/new-staff/getcourt',
            type: "post",
            data: {'courtID': $('#getcourt').val(), '_token': $('input[name=_token]').val()},
            success: function(data){
            $('#division').empty();
            $('#division').append( '<option value="">Select Now</option>' ); 
            $.each(data, function(index, obj){
            $('#division').append( '<option value="'+obj.divisionID+'">'+obj.division+'</option>');
            });
                
            }
        })  
});}) ();

(function () {
    $('#getcourt').change( function(){
    //$('#processing').text('Processing. Please wait...');
        $.ajax({
            url: murl +'/new-staff/getdepartments',
            type: "post",
            data: {'courtID': $('#getcourt').val(), '_token': $('input[name=_token]').val()},

            success: function(data){
            $('#dept').empty();
            $('#dept').append( '<option value="">Select Now</option>' ); 
            $.each(data, function(index, obj){
            $('#dept').append( '<option value="'+obj.id+'">'+obj.department+'</option>' );
            });
                
            }
        })  
    });}) ();

(function () {
    $('#getcourt').change( function(){
    //$('#processing').text('Processing. Please wait...');
        $.ajax({
            url: murl +'/new-staff/getdesignations',
            type: "post",
            data: {'courtID': $('#getcourt').val(), '_token': $('input[name=_token]').val()},
            success: function(data){
            $('#desig').empty();
            $('#desig').append( '<option value="">Select One</option>' );
            $.each(data, function(index, obj){
            $('#desig').append( '<option value="'+obj.id+'">'+obj.designation+'</option>' );
            });
                
            }
        })  
});}) ();

//get Designation
(function () {
    $('#department').change( function(){
        $('#processing').html('Processing. Please wait...');
        var grade   = $('#grade').val();
        if(grade == '')
        {
            alert('Please, select Grade Level from the list!');
            $('#grade').focus();
            $('#processing').html('');
            false;
        }
        var department  = $('#department').val();
        if(department == '')
        {
            $('#processing').html('');
            false;
        }
        if(grade == '')
        {
            $('#processing').html('');
            false;
        }
        $.ajax({
            url: murl +'/staff-registration/designation',
            type: "post",
            data: {'grade': grade, 'department': department, '_token': $('input[name=_token]').val()},
            success: function(data){
                $('#processing').html('');
                $('#designation').val(data.designation_name);
            }
        })  
});})();

//get Designation
(function () {
    $('#grade').change( function(){
        $('#processing').html('Processing. Please wait...');
        var grade   = $('#grade').val();
        var grade   = $('#grade').val();
        var department  = $('#department').val();
        if(grade == '')
        {
            alert('Please, select Grade Level from the list!');
            $('#grade').focus();
            $('#processing').html('');
            false;
        }
        if(department == '')
        {
            alert('Please, select a department from the list!');
            $('#department').focus();
            $('#processing').html('');
            false;
        }
        if(department == '')
        {
            $('#processing').html('');
            false;
        }
        if(grade == '')
        {
            $('#processing').html('');
            false;
        }
       
        $.ajax({
            url: murl +'/staff-registration/designation',
            type: "post",
            data: {'grade': grade, 'department': department, '_token': $('input[name=_token]').val()},
            success: function(data){
                $('#processing').html('');
                $('#designation').val(data.designation_name);
            }
        })  
});})();