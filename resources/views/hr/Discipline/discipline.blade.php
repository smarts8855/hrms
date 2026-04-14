@extends('layouts.layout')

@section('pageTitle')
 Staff Discipline
@endsection

<style type="text/css">

    .length
    {
    	width: 80px;
    }
    .remove
    {
    	padding-top: 12px;
    	cursor: pointer;
    }

</style>
<style>
    body {
		font-family: 'Varela Round', sans-serif;
	}


	.modal-confirm {
		color: #636363;
		width: 100px;
		margin: 10px auto;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
        text-align: center;
		font-size: 14px;
	}
	.modal-confirm .modal-header {
		border-bottom: none;
        position: relative;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -10px;
	}
	.modal-confirm .close {
        position: absolute;
		top: -5px;
		right: -2px;
	}
	.modal-confirm .modal-body {
		color: #999;
	}
	.modal-confirm .modal-footer {
		border: none;
		text-align: center;
		border-radius: 5px;
		font-size: 13px;
		padding: 10px 15px 25px;
	}
	.modal-confirm .modal-footer a {
		color: #999;
	}
	.modal-confirm .icon-box {
		width: 50px;
		height: 50px;
		margin: 0 auto;
		border-radius: 50%;
		z-index: 9;
		text-align: center;
		border: 3px solid #f15e5e;
	}
	.modal-confirm .icon-box i {
		color: #f15e5e;
		font-size: 24px;
		display: inline-block;
		margin-top: 10px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #60c7c1;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		min-width: 80px;
        border: none;
		min-height: 40px;
		border-radius: 3px;
		margin: 0 5px;
		outline: none !important;
    }
	.modal-confirm .btn-info {
        background: #c1c1c1;
    }
    .modal-confirm .btn-info:hover, .modal-confirm .btn-info:focus {
        background: #a8a8a8;
    }
    .modal-confirm .btn-danger {
        background: #f15e5e;
    }
    .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }
	.trigger-btn {
		display: inline-block;
		margin: 50px auto;
	}
</style>

@section('content')
<div class="box box-default" style="border: none;">
    <div class="box-body box-profile" style="margin:10px 20px;">
        {{-- <div class="col-lg-1" style="float:right;"><img
                src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg"
                class="img-thumbnail" alt="NYSC LOGO"></div> --}}
        <div class="row">
            <div align="center">
                <h3>Staff Discipline</h3>
            </div>
            <hr />

                    @includeIf('Share.message')
                    <div class="col-md-12">



                    {{-- start of form --}}
                    <div class="col-md-12  box box-default">
                        <form method="post" action="{{ url('/discipline-save') }}" id="formID" class="form-horizontal">
                            @csrf
                            <div  class="col-md-6">
                                {{ csrf_field() }}
                               {{-- <input id="autocomplete" name="q" class="form-control dos"> --}}
                               <label for="livesearch" id=lstaffname class="form-label">Search Staff </label>
                               <select    name="livesearch" class="form-control livesearch" id="livesearch" required>

                                </select>

                               <input type="hidden" id="nameID"  name="nameID">
                              </div>
                            {{-- <div class="col-md-6" id="statec" >
                                <label for="staffname" id=lstaffname class="form-label">Staff Name </label>
                                <input type="text"   class="form-control" id="staffname" name="staffname"  value="{{ old('staffname') }}" placeholder="state code"
                                  >
                            </div> --}}
                            <input type="hidden" id="offenderid"   value="{{ old('offenderId') }}" name="offenderId">
                            <div class="col-md-6" id="statec" >
                                <label for="staffid" id=lsstaffname class="form-label">File No </label>
                                <input type="text" class="form-control"   id="fileNo" name="fileNo"   value="{{ old('fileNo') }}"  placeholder="file No" disabled   >
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="staff">Enter Staff Name</label>
                                <select name="offenderid" class="form-control" onchange="showcategory(this.value)">

                                    @if (isset($staff) && $staff)
                                        @foreach ($staff as $stf)
                                            <option value="{{ $stf->fileNo }}">

                                                {{ $stf->surname }} {{ $stf->first_name }}


                                        @endforeach
                                    @endif
                                </select>
                            </div> --}}

                            <div class="col-md-6">
                                {{-- <div class="form-outline mb-4"> --}}
                                <label for="offense" class="form-label">offense</label>
                                <textarea class="form-control" id="form6Example7" rows="4" name="offense"> {{ old('offense') }}</textarea>
                                {{-- <label class="form-label" for="form6Example7">Enter offense</label> --}}
                                {{-- </div> --}}
                            </div>

                            <div class="col-md-6">
                                {{-- <div class="form-outline mb-4"> --}}
                                <label for="discipline" class="form-label">Discipline</label>
                                <textarea class="form-control"  value="{{ old('discipline') }}" id="form6Example7" rows="4" name="discipline" required> {{ old('discipline') }}</textarea>
                                {{-- <label class="form-label" for="form6Example7">Enter Disciplinary Measures</label> --}}
                                {{-- </div> --}}
                            </div>


                            <div class="col-md-6">
                                <label for="pop"  class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startdate"  value="{{ old('startDate') }}" name="startDate"
                                    aria-label="Server" placeholder="set discipline start date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pop" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="enddate"   value="{{ old('endDate') }}"name="endDate" aria-label="Server"
                                    placeholder="set discipline end date" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-10">
                                        <div align="center" class="form-group">
                                            <label for="month">&nbsp;</label><br />
                                            {{-- <input type="hidden" name="recordID" class="form-control" value="{{ (isset($editRecord) && $editRecord ? $editRecord->file_ID : '') }}"/> --}}
                                            <button name="action" class="btn btn-success" type="submit">
                                                Save <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- end of form --}}

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">STAFF NAME</th>
                                        <th scope="col">OFFENSE</th>
                                        <th scope="col">DISCIPLINE</th>
                                        <th scope="col">START DATE</th>
                                        <th scope="col">END DATE</th>
                                        <th scope="col">LOGGED BY</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col" colspan="2" class="text-center"> ACTION</th>
                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                                @foreach ($form as $key => $value)

                                  @php
                                        // assign variable to the value gotten from the DB to get other values

                                     //   $endDate = \Carbon\Carbon::parse($value->pop)
                                         //   ->addMonths(11)
                                       //     ->isoFormat('MMMM Y');
                                  @endphp

                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td> {{ $value->offenderfirstname }} {{ $value->offendersurname }}</td>
                                            <td>{{ $value->offense }}</td>
                                            <td> {{$value->discipline}} </td>
                                            <td>{{ \Carbon\Carbon::parse($value->startdate)->isoFormat('D MMMM Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->enddate)->isoFormat('D MMMM Y') }}</td>
                                            <td> {{ $value->loggerfirstname }} {{ $value->loggersurname }}</td>
                                            <td>
                                                @if (\Carbon\Carbon::parse($value->startdate)->isoFormat('MMMM Y') <=
                \Carbon\Carbon::parse($value->enddate)->isoFormat('MMMM Y'))
                                                    <div class="badge alert-danger" role="alert">

                                                        Inactive
                                                    </div>
                                                    @else
                                                    <div class="alert-success badge" role="alert">

                                                        Active
                                                    </div>
                                                @endif
                                            </td>
                                            <td><a href="{{url('/discipline-edit/'.$value->id)}}" class="btn btn-success"> <i class="fa fa-edit"></a></td>

                                            </td>
                                            <td>
                                                {{-- <form action="/discipline-delete/{{$value->id}}" method="POST"> --}}
                                                    {{-- @csrf @method('DELETE') --}}
                                                      {{-- <button type="submit" class="btn btn-sm btn-danger" data-href="/discipline-delete/{{$value->id}}" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-remove"></i></button> --}}
                                                  {{-- </form> --}}

                                                  {{-- <a data-toggle="modal" id="smallButton" data-target="#deleteModal" data-attr="{{ route('delete', $value->id) }}" title="Delete Discipline"> --}}
                                                    <a href="#"
                                                    data-id={{$value->id}}
                                                    class="btn btn-danger delete"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class=" fa fa-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>


                                @endforeach
                            </table>
                        </div>
                        <hr/>

                    </div>

                </div>

        </div>
    </div>



   <!-- Delete Warning Modal -->
<div class="modal  fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
    <div  class="modal-dialog modal-confirm modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
					<i class="material-icons">X</i>
				</div>

				<h4 class="modal-title">Are you sure?</h4>
                {{-- <h5 class="modal-title" id="exampleModalLabel">Delete Contact</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>



				{{-- <div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>
				<h4 class="modal-title">Are you sure?</h4> --}}
                {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}


            <form action="{{ route('discipline.delete', $value->id) }}" method="post">
                <div class="modal-body">
                @csrf
                @method('DELETE')
                <input id="id" hidden  name="id" />
                {{-- <h4 class="modal-title">Are you sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}

				<p>Do you really want to delete this record? This process cannot be undone.</p>
			</div>


            <div class="modal-footer">
                <div class="col-md-5" align="left">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
                <div class="col-md-2" align="centre"></div>
                <div div class="col-md-5" align="left">
                <button type="submit" class="btn btn-sm btn-danger">Yes, Delete </button>
                <div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
        <!-- End Delete Modal -->

{{--
 <div class="box-body">

    <div class="form-group">
      {{ csrf_field() }}
     <input type="text" id="search" name="q" class="form-control dos">
     <input type="hidden" id="nameID"  name="nameID" />
    </div>
  </div> --}}
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('assets/js/select2.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
     <script>
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});
	</script>


    {{-- <script type="text/javascript">
        $(function() {
            var route = "{{ route('staff.search') }}";
            $("#autocomplete").autocomplete({
                serviceUrl: route,
                minLength: 2,
                onSelect: function(suggestion) {

                    $('#fileNo').val(suggestion.fileNo);
                    // var fileNo = suggestion.data;
                    // //showAll();
                    $('#staffname').val(suggestion.value);
                    $('#offenderid').val(suggestion.data);


                                    } // end on select






            });
        });
    </script> --}}

<script>


    // $(document).ready(function() {
    $('.livesearch').select2({
        // var route = "{{ route('staff.search') }}";
        placeholder: 'Select staff',
        ajax: {
            url: '/discipline/staff-search',
            dataType: 'json',
            delay: 250,
            processResults: function (suggestions) {
                return {
                    results: $.map(suggestions, function (item) {
                        return {
                            "text": item.value,
                            "id": item.data,
                            "data-value": item.fileNo
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.livesearch').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data);
    $('#fileNo').val(data["data-value"]);
                    // var fileNo = suggestion.data;
                    //showAll();
                    $('#staffname').val(data.text);
                    $('#offenderid').val(data.id);
                    // $("b").attr("title");


});


// })
  </script>
  <script>
    $(document).on('click','.delete',function(){
            let id = $(this).attr('data-id');
            $('#id').val(id);
       });
</script>
@endsection
