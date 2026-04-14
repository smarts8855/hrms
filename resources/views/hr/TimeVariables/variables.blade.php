@extends('layouts.layout')
@section('pageTitle')
    <strong>Time Variables</strong>
@endsection
@section('content')
<div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
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

				@if(session('success'))
		                    <div class="alert alert-success alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Success!</strong>
					{{ session('success') }}
				    </div>
		                @endif

		                @if(session('err'))
		                    <div class="alert alert-warning alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Not Allowed ! </strong>
								{{ session('err') }}
						    </div>
		                @endif

		            </div>
     <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title mb-4" style="margin-left:30px">Create Time Variable</h3>

                                        <form class="row gy-2 gx-3 align-items-center" style="padding:30px;"method="POST" action="/create-time-variables">
                                            {{ csrf_field() }}
                                            <div class="col-sm-6 mb-4">
                                                <label class="" for="autoSizingInput">Variable Name</label>
                                                <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Time Variable Name" name="name" value="{{old('name')}}">
                                            </div>
                                           <div class="col-sm-3 mb-4">
                                                <label class="" for="autoSizingSelect">Period</label>
                                                <select class="form-control" id="autoSizingInput" name="unit" value="{{old('unit')}}">
                                                    <option value="1">Days</option>
                                                     <option value="2">Months</option>
                                                      <option value="3">Years</option>
                                                </select>

                                            </div>
                                            <div class="col-sm-3 mb-4">
                                                <label class="" for="autoSizingSelect">Duration</label>
                                                <input type="number" class="form-control" id="autoSizingInput" placeholder="Enter duration" name="period" value="{{old('period')}}">

                                            </div>



                                            <div class="col-sm-4 mb-4" style="margin-top:30px">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                        <h4 style="margin-left:30px"><strong>Variables</strong></h4>
                                        <p style="margin-left:30px" class="card-title-desc">View All Variables</p>

                                            <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>SN</th>

                                                        <th data-priority="1">VARIABLE NAME</th>
                                                        <th data-priority="3">PERIOD</th>
                                                        <th data-priority="3">DURATION</th>


                                                        <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($variables))
                                                    @foreach($variables as $key=>$variable)
                                                    <tr>
                                                        <th>{{$key + 1}}</th>
                                                        <td>{{$variable->name}}</td>
                                                        <td>{{$variable->period}}</td>
                                                        <td>{{$variable->unit_name}}</td>

                                                        <td class="row align-items-center">
                                                            <a href="#" data-toggle="modal" data-target="#edit" class="text-primary module"
                                                            data-name="{{$variable->name}}" data-period="{{$variable->period}}"
                                                            data-unit="{{$variable->unit}}"
                                                            data-id = "{{$variable->id}}">Edit | </a>
                                                            <a href="#" data-toggle="modal" data-target="#delete" class="text-danger delete_module" data-toggle="modal" data-target="#delete" data-id = "{{$variable->id}}">Delete</a>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                   @endif
                                                    </tbody>
                                                </table>



</div></div>
</div>
    <!-- Edit Modal -->
    <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Update Variable</h5>

                                                        </div>
                                                        <div class="modal-body">
                            <form class="row gy-2 gx-3 align-items-center" method="POST" action="/edit-time-variables">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="id" name="id">
                                            <div class="col-sm-4 mb-3">
                                                <label class="" for="autoSizingInput">Time Variable Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                            </div>
                                              <div class="col-sm-3 mb-4">
                                                <label class="" for="autoSizingSelect">Period</label>
                                                <select class="form-control" id="unit" name="unit" value="{{old('unit')}}">
                                                    <option value="1">Days</option>
                                                     <option value="2">Months</option>
                                                      <option value="3">Years</option>
                                                </select>

                                            </div>
                                            <div class="col-sm-5 mb-3">
                                                <label class="" for="autoSizingSelect">Duration</label>
                                                <input type="number" class="form-control" id="period" name="period" value="{{old('period')}}">

                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                                        </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
    <!-- End Edit Modal -->

<!-- Delete Modal -->
    <div id="delete" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Delete Variable</h5>

                                                        </div>


                                                        <div class="modal-body">
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="/delete-time-variables">
                                                                {{ csrf_field() }}
                                                                <p style="margin-left:30px">Are you sure you would like to delete this Variable </p>
                                                                <input type="hidden" name="id" id="delete_id">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>

                                                        </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    <!-- End Delete Modal -->


     @endsection
    @section('scripts')
    <script type='text/javascript'>
        $('.module').on('click',function(){
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var period = $(this).attr('data-period');
            var unit = $(this).attr('data-unit');


            $('#name').val(name);
            $('#id').val(id);
            $('#period').val(period);
            $('#unit').val(unit);




        })

        $('.delete_module').on('click',function(){
            var id = $(this).attr('data-id');

            $('#delete_id').val(id);


        })

    </script>
    @endsection
