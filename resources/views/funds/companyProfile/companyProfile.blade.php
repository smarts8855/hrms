@extends('layouts.layout')
@section('pageTitle')
Company Profile
  
@endsection

@section('content')

<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
          <div class="col-xs-12 col-sm-9">
            
          <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('/company-profile/update')}}">
            {{ csrf_field() }}
            @foreach($getAllDetails as $list)
                <div class="form-group">
                    <div class="col-sm-10">
                    <label for="companyname" class="control-label">Company Name</label>  
                    <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Enter Company Name" value="{{$list->companyName}}">
                    </div>
                </div>
               <div class="form-group">
                    <div class="col-xs-5 col-sm-4 col-md-3">
                        <label for="shortCode" class="control-label">Short Code</label>
                        <input class="form-control" id="shortCode" name="shortCode" placeholder="Short Code" value="{{$list->shortCode}}">
                    </div>
                    <div class="col-xs-7 col-sm-6 col-md-7">
                        <label for="telnum" class="control-label">Telephone Number</label>
                        <input type="tel" class="form-control" id="telnum" name="telnum" placeholder="Tel. number" value="{{$list->phoneNo}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="emailid" class="control-label">Email</label>
                        <input type="email" class="form-control" id="emailid" name="emailid" placeholder="Email" value="{{$list->emailAddress}}">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="feedback" class="control-label">Contact Address</label>
                        <input type="text" class="form-control" id="address" name="address" rows="2" value="{{$list->contactAddress}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10">
                        <label id = logoid class="control-label">Add Logo</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="file" name="logo" accept="image/*" onchange="preview_image(event)">
                        
                    </div>
                    <div id="imagewrapper" class="col-sm-4" >
                            <img id ="output_image" src="{{ asset("/profileLogo/$list->logoName") }}">
                    </div>
                </div>
                
               @endforeach
                 <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div> 
            </form>
        </div>
        
          <hr />
        </div>
       
  </div>
</div>
  </div>
</div>

@endsection
@section('styles')
<style type="text/css">
img {
    max-width: 100%;
    max-height: 100%;
}
#imagewrapper{
    width: 150px;
    height:150px;
}
#logoid{
    padding-bottom: 10px;
}
</style>
@endsection
@section('scripts')
<script type='text/javascript'>
    function preview_image(event) 
    {
     var reader = new FileReader();
     reader.onload = function()
     {
      var output = document.getElementById('output_image');
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
    }
    </script>
@stop