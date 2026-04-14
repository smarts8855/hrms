@extends('layouts.layout')


                                
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

 @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{Session::get('success')}}
    </div>
@endif
@if (Session::has('error'))
    <div class = "alert alert-danger alert-dismissible" role="alert">
        {{Session::get('error')}}
    </div>
@endif
 <div class="row">
     <div class="col-md-6">
         
             <div class = "box box-default">
                   <div class="box-body box-profile">
                       <div class="box-header with-border hidden-print">
                         <h3 class="box-title"><b>Create Language</b> <span id='processing'></span></h3>
    	               </div>
                       <form method="post" action="{{route('store-language')}}" style="margin: 20px 0px">
                        {{ csrf_field() }}
                       <div class="col-md-9">
		    		 	<div class="form-group">
		    		 		<label for="month">Language Name:</label>
		    		 		<input type="text" name="language" id="" value="{{old('language')}}" class="form-control" />
		    		 		
		    		 	</div>
		    		 	
                       <input type="submit" value="save" class="btn btn-primary">
		    		 </div>
		    		</form>
		    		
		    		 <div class='row' style="margin: 20px">
                         <div class="table-resonsive">
                             <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th>S/N</th>
                                  <th>LANGUAGE NAME</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($dataLang as $key => $lang)
                              <tr>
                                  <td>{{$key+1}}</td>
                                  <td class='text-capitalize'>{{$lang->language_name}}</td>
                                  <td><div class='btn-group'>
                                      <a class='btn btn-warning' onclick = "editLang('{{$lang->languageID}}', '{{$lang->language_name}}')" data-toggle="modal" data-target="#lang">Edit</a>
                                      <a class='btn btn-danger' onclick = "deleteLang('{{$lang->languageID}}', '{{$lang->language_name}}')" data-toggle="modal" data-target="#deleteLang">Delete</a>
                                  </div></td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                         </div>
                     </div>
                </div>
            </div>
         
     </div>
     <div class="col-md-6">
         
             <div class = "box box-default">
                   <div class="box-body box-profile">
                       <div class="box-header with-border hidden-print">
                         <h3 class="box-title"><b>Create Fluency</b> <span id='processing'></span></h3>
    	               </div>
    	               
                       <form method="post" action="{{route('store-fluency')}}" style="margin: 20px 0px">
                        {{ csrf_field() }}
                        
                       
                       <div class="col-md-9">
		    		 	<div class="form-group">
		    		 		<label for="month">Fluency Title:</label>
		    		 		<input type="text" name="fluency_title" id="" value="{{old('fluency_title')}}" class="form-control" />
		    		 	</div>
                       <input type="submit" value="save" class="btn btn-primary">
		    		 </div>
		    		</form>
		    		<div class='row' style="margin: 20px">
                         <div class="table-resonsive">
                             <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th>S/N</th>
                                  <th>FLUENCY LEVEL</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($dataFluency as $key => $fluency)
                              <tr>
                                  <td>{{$key+1}}</td>
                                  <td class='text-capitalize'>{{$fluency->fluency_title}}</td>
                                  <td><div class='btn-group'>
                                      <a class='btn btn-warning'>Edit</a>
                                      <a class='btn btn-danger'>Delete</a>
                                  </div></td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                         </div>
                     </div>
                </div>
            </div>
         
     </div>
 </div>

<!-- Edit Lang Modal -->
<div class="modal fade" id="lang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class='modal-header'>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Language</h4>
      </div>
      <div class="modal-body">
      <div class='row'>
        <form method="post" action="{{route('store-language')}}" style="margin: 20px 0px">
                  {{ csrf_field() }}
                  <input type ="hidden" name = "language_id" id="langID">
          <div class="col-md-9">
		 	    <div class="form-group">
		 	    	<label for="month">Language Name:</label>
		 	    	<input type="text" name="language" id="langName" class="form-control" />
		 	    </div>
              <input type="submit" value="save changes" class="btn btn-primary">
		 </div>
	    </form>
      </div>
     </div>
      <div class='modal-footer'>
	      Designed by <span class='text-primary'>MBR Computers</span>.
	  </div>
    </div>
  </div>
</div>

<!--Delete Lang Modal -->
<div class="modal fade" id="deleteLang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class='modal-header'>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Language</h4>
      </div>
      <div class="modal-body">
      <div class='row'>
          <div class="text-center">
              <div>Are you sure you want to delete <span id='displayDeleteLang'></span> Language?</div>
        <form method="post" action="{{route('store-language')}}" style="margin: 20px 0px">
            {{ csrf_field() }}
            <input type ="hidden" name = "delete_language_id" id="delete_langID">
            <input type="submit" value="Delete Record" class="btn btn-danger">
	    </form>
          </div>
      </div>
     </div>
      <div class='modal-footer'>
	      Designed by <span class='text-primary'>MBR Computers</span>.
	  </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    function editLang(data1, data2){
        let langID = document.getElementById('langID');
        let langName = document.getElementById('langName');
        //alert(data2);
        
        langID.value = data1;
        langName.value = data2;
    }
    
    function deleteLang(data1, data2){
        let langID = document.getElementById('delete_langID');
        let langName = document.getElementById('displayDeleteLang');
        //alert(data2);
        
        langID.value = data1;
        langName.innerHTML = data2;
    }
</script>
@endsection