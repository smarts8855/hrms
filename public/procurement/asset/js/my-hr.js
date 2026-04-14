function showAll() {
  $.ajax({
  url: murl +'/profile/searchUser/showAll',
  type: "post",
  data: {'nameID': $('#nameID').val(), '_token': $('input[name=_token]').val()},
  success: function(data){
    $('#nextofkinHref').attr('href', ""+murl+"/update/next-of-kin/" + data[0].fileNo ); //next of kin url

    //fileNo = data[0].fileNo;
    $('#fullName').html(data[0].surname+', '+data[0].first_name);
    $('#fileNo').html(data[0].fileNo);
    $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
    $('#surname').html(data[0].surname);
    $('#first_name').html(data[0].first_name);
    $('#othernames').html(data[0].othernames);
    $('#decoration').html(data[0].title);
    //
    if(typeof data[0].fullname != 'undefined' || data[0].fullname != null)
    {
      $('#nextofkinName1').html(data[0].fullname);
      $('#nextofkinAddr1').html(data[0].address);
      $('#nextofkinRelationship1').html(data[0].relationship);
    }
    if(typeof data[1].fullname != 'undefined' || data[1].fullname != null)
    {
      $('#nextofkinName2').html(data[1].fullname);
      $('#nextofkinAddr2').html(data[1].address);
      $('#nextofkinRelationship2').html(data[1].relationship);
    }    
    
  }
})  //end of first ajax call for profile
} //end of function showAll