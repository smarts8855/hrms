function ReloadForm(){
    //alert('here');
    inp = document.getElementById('numvalue').value;
    if(inp == ''){
        alert('Please select a valid File Number');
    } else {
        var form = document.getElementById('form1');
        form.submit();
    }
    return false;
}

$('#changeStatus').change( function(){
    var getStatus = $('#changeStatus').val();

    if(getStatus == 'Married')
    {
        $('#showIfMarried').css('display', 'block');
        
      
    }else{
        $('#showIfMarried').css('display', 'none');
        //clear fields
       
        $("#maritalStatus").validate({ 
            ignore:  ":hidden:not(#showIfMarried)"
         });
    }
}); 




$('#datepicker1').datepicker({
    dateFormat: 'yy-mm-dd'
});

$('#datepicker2').datepicker({
    dateFormat: 'yy-mm-dd'
});

$('.datepickerX').datepicker({
    dateFormat: 'yy-mm-dd'
});









