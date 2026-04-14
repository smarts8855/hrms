@extends('layouts.layout')

@section('pageTitle')
All Transaction Details
@endsection

@section('content')
<div class="box-body">

    <div class="box-body hidden-print">
    <div class="row">
      <div class="col-sm-12">
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> <br />
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif

        @if(session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> <br />
          {{ session('msg') }}
        </div>                        
        @endif

        @if(session('err'))
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Operation Error !</strong> <br />
          {{ session('err') }}
        </div>                        
        @endif
      </div>
    </div><!-- /row -->
  </div><!-- /div -->


  <div class="box-body">
        
        

        
        <div class="row">
             
             <form method="post" action="{{url('/edit/account')}}" style="margin-top:10px;">
                    {{ csrf_field() }}
                    

                    <div class="row">
                        
                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">Bank</label>
                                <select name="bank" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($banks as $list)
                                    <option value="{{$list->bankID}}" @if($acct->bankId == $list->bankID) selected @endif>{{$list->bank}}</option>
                                    @endforeach
                                   
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">Account Number</label>
                               <input type="text" name="accountNo" class="form-control" value="{{$acct->account_no}}" required/>
                               <input type="hidden" name="id" class="form-control" value="{{$acct->id}}"/>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Address</label>
                                <textarea name="address" class="form-control" style="height:300px;" id="address" >
                                    {!!$acct->address!!}
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Status</label>
                               <select name="status" class="form-control">
                                   <option value="">Select One</option>
                                   <option value="1" @if($acct->status ==1) selected @endif>Active</option>
                                   <option value="0" @if($acct->status ==0) selected @endif>Inactive</option>
                               </select>
                            </div>
                        </div>
                        
                    </div>

                    <input type="submit" class="btn btn-success" name="submit" value="Update" />

                    
                </form> 
            
        </div>
        
     
    </div>
    <!-- /.row -->

  </div>

  

  @endsection

  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <style type="text/css">
    .status
    {
      font-size: 15px;
      padding: 0px;
      height: 100%;
     
    }

    .textbox { 
    border: 1px;
    background-color: #66FFBA; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

  .autocomplete-suggestions{
    color:#66FFBA;
    height:125px; 
  }
    .table,tr,th,td{
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
  </style>
  @endsection
  @section('scripts')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
   
    <script>
    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete this record?");
      if (x)
          return true;
      else
        return false;
    }
</script>    


    <script type="text/javascript">
tinymce.init({
	 width: "100%",
    plugins: "media"
});        

tinymce.init({
    selector: "#address",
    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
   
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools","media"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});


</script>
@endsection
