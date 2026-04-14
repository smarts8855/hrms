@extends('layouts.layout')
@section('pageTitle')
    Discipline
@endsection

@section('content')
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:10px 20px;">
            {{-- <div class="col-lg-1" style="float:right;"><img
                    {{-- src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg"
                    class="img-thumbnail" alt="NYSC LOGO"></div> --}}

            <div class="row">
                <div align="center">
                    <h3>Enter A Discipline</h3>
                </div>
                <hr />
                @includeIf('Share.message')

                <div class="row">
                    <div class="col-md-12">
                     <div class="row">
                      <div class="col-md-12">
                        <div class="box box-default">
                          <div class="box-header with-border hidden-print">
                            <h3 class="box-title">Search By First Name, Surname or File Number <span id='processing'></span></h3>
                          </div>
                          <form method="post" action="{{ url('staff/store') }}">
                            <div class="box-body">
                              <div class="form-group">
                                {{ csrf_field() }}
                               <input id="autocomplete" name="q" class="form-control dos">
                               <input type="hidden" id="nameID"  name="nameID">
                              </div>
                            </div>

                          </form>
                        </div>
                      </div><!-- /.col -->
                    </div><!-- /.row -->


                    </div><!-- /.col -->
                    </div>



                <form method="post" action="{{ url('/discipline-save') }}" class="form-horizontal">
                    @csrf
                    <div class="col-md-6">
                        <label for="staff" >Enter Staff Name</label>
                        <select name="offenderid" class="form-control" onchange="showcategory(this.value)">

                            @if(isset($staff) && $staff)
                                @foreach($staff as $stf)
                                    <option value="{{$stf->fileNo}}">

                                        {{$stf->surname}}   {{$stf->first_name}}

                                        {{-- {{$cat}}</option> --}}
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        {{-- <div class="form-outline mb-4"> --}}
                            <label for="offense" class="form-label">offense</label>
                            <textarea class="form-control" id="form6Example7" rows="4"  name="offense"></textarea>
                            {{-- <label class="form-label" for="form6Example7">Enter offense</label> --}}
                          {{-- </div> --}}
                    </div>

                    <div class="col-md-6">
                        {{-- <div class="form-outline mb-4"> --}}
                            <label for="discipline" class="form-label">Discipline</label>
                            <textarea class="form-control" id="form6Example7" rows="4" required ></textarea>
                    {{-- <label class="form-label" for="form6Example7">Enter Disciplinary Measures</label> --}}
                          {{-- </div> --}}
                    </div>


                    <div class="col-md-6">
                        <label for="pop" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startdate" name="startdate" aria-label="Server"
                            placeholder="set Start date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pop" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="pop" name="pop" aria-label="Server"
                            placeholder="set POP date" class="form-control" required>
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
            </div>
        </div>



        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Staff Name</th>
                            <th scope="col">offense</th>
                            <th scope="col">discipline</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Logged By</th>
                            <th scope="col">Status</th>
                            <th scope="col" colspan="2" class="text-center"> Actions</th>
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
                                <td>{{ $value->offenderfirstname }} {{ $value->offenderlastname }}</td>
                                <td>{{ $value->offense }}</td>
                                <td> {{$value->discipline}} </td>
                                <td>{{ \Carbon\Carbon::parse($value->startdate)->isoFormat('D MMMM Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->enddate)->isoFormat('D MMMM Y') }}</td>
                                <td>
                                    @if (\Carbon\Carbon::now()->isoFormat('MMMM Y') <
    \Carbon\Carbon::parse($value->enddate)->isoFormat('MMMM Y'))
                                        <div class="alert alert-success" role="alert">
                                            {{-- <div class="col-lg-2" style=" width:18%; float:right;"><img src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg" class="img-thumbnail" alt="NYSC LOGO"></div> --}}
                                            Inactive
                                        </div>
                                        @else Active
                                    @endif
                                </td>
                                <td><a href="{{url('/discipline-edit/'.$value->id)}}" class="btn btn-success"> <i class="fa fa-edit"></a></td>

                                </td>
                                <td>
                                    <form action="/discipline-delete/{{$value->id}}" method="POST">
                                        @csrf @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></button>
                                      </form>
                                </td>
                            </tr>
                        </tbody>


                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection


    <script type="text/javascript" src = "{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>







