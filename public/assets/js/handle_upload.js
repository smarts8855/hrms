$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#del_body').on('click', '*', function(){

    var id = $(this).attr('id');

    if(id && id !== undefined){

        var url = "/jippis/documents/delete/"+id;
        //console.log(id);
    
        $.ajax(url,{
            type: 'GET',
            success: function(response){
                alert('Document deleted successfully');
                location.reload();
            },
            error: function(xhr, status, error) {
                
               alert(xhr.responseText);
              }
        });
        
    }
  
 
})


