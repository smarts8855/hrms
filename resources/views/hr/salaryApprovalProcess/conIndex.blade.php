  @extends('layouts.layout')
  @section('pageTitle')
  PE-Card
    @endsection
  @section('content')
  <form method="POST" action="{{ url('/view-pecard') }}">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col-->
          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> 
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
          </div>
          @endif
          @if(session('message'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> 
            {{ session('message') }}
          </div>                        
          @endif
       @if(session('err'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> 
            {{ session('err') }}
          </div>                        
          @endif
        </div>
        {{ csrf_field() }}
        <div class="col-md-12">
          <div class="row">

              @if ($CourtInfo->courtstatus==1)
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Select Court</label>
                          <select name="court" id="court" class="form-control" style="font-size: 13px;">
                              <option value="">Select Court</option>
                              @foreach($courts as $court)
                                  @if($court->id == session('anycourt'))
                                      <option value="{{$court->id}}" selected="selected">{{$court->court_name}}</option>
                                  @else
                                      <option value="{{$court->id}}" @if(old('court') == $court->id) selected @endif>{{$court->court_name}}</option>
                                  @endif
                              @endforeach
                          </select>

                      </div>
                  </div>
              @else
                  <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
              @endif

              @if ($CourtInfo->divisionstatus==1)
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Select Division</label>
                          <select name="division" id="division_" class="form-control" style="font-size: 13px;">
                              <option value="">Select Division</option>
                              @foreach($courtDivisions as $divisions)
                                  <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              @else
                  <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
              @endif
                  @if ($CourtInfo->courtstatus==1)
              <div class="col-md-6">
            <div class="form-group">
              <label for="staff">STAFF NAME</label>
              <select name="staffName"  class="form-control">
                <option>Select Staff</option>
                  @foreach($staff as $lists)
                      <option value="{{$lists->ID}}"> {{$lists->surname}} {{$lists->first_name}} {{$lists->othernames}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          @else
          <div class="col-md-6">
              <div class="form-group">
                  <label for="staff">STAFF NAME</label>
                  <select name="staffName"  class="form-control">
                      <option>Select Staff </option>
                      @foreach($staff as $lists)
                          <option value="{{$lists->ID}}" @if($lists->fileNo == session::get('staff')) selected @endif>{{$lists->surname}} {{$lists->first_name}} {{$lists->othernames}} </option>
                      @endforeach
                  </select>
              </div>
          </div>
          @endif
        <div class="col-md-6">
              <div class="form-group">
               <label >Select a Year {{session::get('yr')}}</label>                       
               <select name="year" id="section" class="form-control">
              
                <option value="">Select Year</option>
               @for($i=2010;$i <= 2040;$i++)
               
                 <option value="{{$i}}" @if($i == session::get('yr')) selected @endif>{{$i}}</option>
               
                  @endfor      
              </select>
            </div>
          </div>
          </div>
          </div>
             <div class="col-md-12">
          <div class="row">

          <div class="col-md-6">
            <div class="form-group">
            <label></label>
              <div >
                <button type="submit" class="btn btn-success pull-right">Display</button>
              </div>
            </div>           
          </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>
@endsection
@section('styles')
@endsection


