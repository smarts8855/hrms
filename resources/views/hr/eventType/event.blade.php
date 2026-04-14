@extends('layouts.layout')
@section('pageTitle')
Self Service
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'>
                <strong><em>Add New Event Type</em></strong> </span></h3>
        </div>

     <!-- Validation messages -->
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

                @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong>
                        {!!  session('msg') !!}
                    </div>
                @endif

                @if(session('err'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error Occured!</strong>
                        {!! session('err') !!}
                    </div>
                @endif


    <!-- End Validation Message -->


        <!--MAIN FORM --->
            <div class="box-body">
                    <form method="post" action="{{url('Type/save')}}" id="form1">
                            {{ csrf_field() }}
                            <!--hidden field for creating record-->
                    <div class="row">
                        <div class="col-md-6">
                            <label>Event Type</label>
                        	<input type="text" name="event_type" class="form-control input-lg" required/>
                        </div>
                        <div style="padding-top: 30px;">
                        	<button type="submit" name="button" class="btn btn-primary">Add Event</button>
                        </div>
                        <br>
                        <div class="col-md-6">
                            <label>Status</label>
                                <select name="status" id="status" class="form-control" required/>
                                  <option value="">Select</option>
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>
                                </select>
                        </div>


                    </div>
                    </form>
                </div>
                <!--END OF MAIN FORM-->

                <br>
                <br>
            <div class="container-fluid">
                <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" style="overflow-x:auto;">
                    <caption style="color:#219C52; font-size:large; font-weight:bold; text-align:center;">Added Event Types</caption>
                    <thead  class="thead-light" style="font-weight: bold;">
                        <tr>
                            <td>S/N</td>
                            <td>EVENT TYPE</td>
                            <td>STATUS</td>
                            <td colspan="2">ACTION</td>
                        </tr>
                    </thead>

                    <tbody>
                         @php $i = 1; @endphp
                        @foreach ($events as $event)
                        <tr>

                            <td>{{$i++}}</td>
                            <td>{{$event->event_type}}</td>
                            <td>@if($event->eventStatus==1){{'Active'}} @elseif($event->eventStatus==0) {{ 'Inactive' }} @endif</td>
                            <td>
                                <button onclick="editfunc('{{ $event->id }}', '{{ $event->event_type }}' )" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$event->id}}">Edit</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#deleteEventType{{$event->id}}">Delete</button>
                            </td>

                        </tr>

                        <!-- Modal to delete -->
                        <form action='{{url("eventType/delete-event/$event->id")}}' method="get">
                            @csrf
                            <div class="modal fade text-left d-print-none" id="deleteEventType{{ $event->id }}"
                                tabindex="-1" role="dialog" aria-labelledby="deleteEventType" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm! </h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-success text-center">
                                                <h4>Are you sure you want to delete event type {{$event->event_type}} </h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal">
                                                Cancel </button>
                                            <button type="submit" class="btn btn-success">
                                                    Confirm </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end Modal-->

                         <!--Edit Modal -->
                            <div class="modal fade" id="exampleModal{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel"> <strong>Edit Event Type</strong></h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="{{url('Type/update/id')}}" id="form2">
                                        {{ csrf_field() }}
                                        <!--hidden field for creating record-->
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                            <input type="hidden" name="eventId" class="form-control input-lg" id="eventId" value="{{$event->id}}" required />
                                            <label>Event Type</label>
                                                <input type="text" name="new_event_type" class="form-control input-lg" id= "event_type" value="{{$event->event_type}}" required />
                                            <label>Status </label>
                                                <select name="new_event_status" id="status" class="form-control" required/>
                                                    <option value="">Select</option>
                                                    <option value="1" {{ ($event->eventStatus==1)  ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ ($event->eventStatus==0) ? 'selected' : '' }}>Inactive </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </form>
                                    </div>
                                </div>
                              </div>
                            </div>
                            </div>
                            <!-- End Modal -->

                        @endforeach

                    </tbody>
                </table>
            </div>
            </div>




@endsection
@section('scripts')
<script>
function funcDelete(x)
{
  //alert(x);
  var y = confirm("Do you want to delete?")
  if(y==true)
  {
     document.location="delete-event/"+x;
  }
  else
  {
      //do nothing
  }
}
</script>

<script>

     function editfunc(r,x)
     {
         document.getElementById("idvalue").value = r;
         document.getElementById("event_type").value = x;
     }

</script>
@stop
