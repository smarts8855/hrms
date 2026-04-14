@extends('layouts.layout')

@section('pageTitle')
  Outgoing Letter
@endsection
<style type="text/css">
	.table {
   
        overflow-x: auto;
    }
</style>
@section('content')
<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Error!</strong> @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach </div>
          @endif
          
          @if(session('msg'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Success!</strong> {{ session('msg') }} </div>
          @endif
          
          @if(session('err'))
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Not Allowed ! </strong> {{ session('err') }} </div>
          @endif </div>
        {{ csrf_field() }}
        <div class="col-md-12"><!--2nd col-->
          
          <!-- /.row -->
          <form method="post" action="{{ url('/open-file-registry/saveoutgoing')}}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Full Name (Sender)</label>
                  <input type="text" name="sender" id="name" class="form-control" value="{{old('sender')}}"/>
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Name (Recipient)</label>
                  <input type="text" name="recipient" id="name" class="form-control" value="{{old('recipient')}}"/>
                  
                </div>
              </div>
            </div>
            <div class="row" style="margin-top: 6px;">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Details</label>
                  <textarea class="form-control" name="detail" id="detail"> {{old('date')}}</textarea>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Phone of Recipient</label>
                  <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}"/>
                  
                </div>
              </div>
              
            </div>
            <hr />
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3">
                  <div align="left" class="form-group">
                    <label for="month">&nbsp;</label>
                    <br />
                    <a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a> </div>
                </div>
                <div class="col-md-9">
                  <div align="right" class="form-group">
                    <label for="month">&nbsp;</label>
                    <br />
                    <button name="action" class="btn btn-success" type="submit"> Add New <i class="fa fa-save"></i> </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <hr />
        </div>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <div class="row">
      <div class="col-md-12">
          
          <div class="wrap" style="margin-bottom:20px;">
          <div class="search row">
            <div class="col-md-9">
            <input type="text" id="autocomplete" name="q" class="form-control searchTerm c" placeholder="Search By Owner Name ">
            <input type="hidden" id="ownername"  name="name" >
            </div>
            <div class="col-md-3" style="padding-top:0px;">
            <button type="submit" class="searchButton btn btn-success "> <i class="fa fa-search"></i> </button>
            </div>
          </div>
        </div>
          
        <table class="table table-striped table-condensed table-bordered">
          <thead>
            <th>S/N</th>
            <th>Sender Name</th>
            <th>Recipient Name</th>
            <th>Detail</th>
            <th>Recipient Phone</th>
            <th></th>
          </thead>
          <tbody>
          
          @php $key = 1; @endphp
          @foreach ($details as $list)
          <tr>
            <td>{{$key ++}}</td>
            <td>{{$list->owner_name}}</td>
            <td>{{ $list->collector_name }}</td>
            <td>{{ $list->details}}</td>
            <td>{{ $list->phone }}</td>
            <td><a href="javascript:void()" class="edit" sender="{{$list->owner_name }}" detail="{{$list->details}}" recipient="{{$list->collector_name}}" recipientPhone="{{$list->phone}}" id="{{$list->Id}}">Edit</a></td>
          </tr>
          @endforeach
          </tbody> 
        </table>
  
        <div class="">{{ $details->links() }}</div>
      </div>
    </div>
    
  </div>
</div>

<!-- Bootsrap Modal for Conversion and Advancemnet-->

<form method="post" action="{{url('/update/outgoing-letter')}}">
{{ csrf_field() }}
<div id="editModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
                <p id="message"></p>
            </div>
            <div class="modal-body">
                
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Full Name (Sender)</label>
                  <input type="text" name="sender" id="sender" class="form-control"/>
                  <input type="hidden" name="id" id="itemID" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Name (Recipient)</label>
                  <input type="text" name="recipient" id="recipient" class="form-control"/>
                  
                </div>
              </div>
            </div>
            <div class="row" style="margin-top: 6px;">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Details</label>
                  <textarea class="form-control" name="detail" id="details"></textarea>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label for="month">Phone of Recipient</label>
                  <input type="text" name="phone" id="phones" class="form-control"/>
                  
                </div>
              </div>
              
            </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary adv" id="adv">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>

<!-- //// Bootsrap Modal for Conversion and Advancemnet-->

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts') 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script> 
<!-- autocomplete js--> 
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script> 
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script> 
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script>

<script type="text/javascript">
  $(function() {
      $('#searchName').attr("disabled", true);
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/open-file-registry/searchoutgoing',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#ownername').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            //showAll();
        }
      });
  });
</script> 

<script>
    $(document).ready(function(){
  
    $("table tr td .edit").click(function(){
      var sender = $(this).attr('sender');
      var recipient = $(this).attr('recipient');
      var detail = $(this).attr('detail');
      var phone = $(this).attr('recipientPhone');
      var id = $(this).attr('id');
       $("#sender").val(sender);
       $("#phones").val(phone);
       $("#details").val(detail);
       $("#recipient").val(recipient);
      $("#itemID").val(id);
       $("#editModal").modal('show');
       
    });
});
</script>
 
@endsection