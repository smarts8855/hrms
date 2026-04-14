@extends('layouts.layout')

@section('pageTitle')
    Edit Youth Corper/Intern
@endsection

<style type="text/css">
    .length {
        width: 80px;
    }

    .remove {
        padding-top: 12px;
        cursor: pointer;
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

                    @includeIf('Share.message')

                    <div class="col-md-12">
                        <!--2nd col-->


                        <form method="Post" action="{{ url('/nysc-update') }}">
                            @csrf
                            <input type="hidden" class="form-control" name="recordid" value="{{ $value->id }}" required>
                            <!-- Modal -->
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstname" placeholder="First name"
                                    aria-label="First name" value="{{ $value->firstname }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Last name"
                                    aria-label="Last name" value="{{ $value->lastname }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="staticEmail2" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="staticEmail2"  value="{{ $value->email }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="staticEmail2" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="staticEmail2" value="{{ $value->phone }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword2" class="form-label">Course</label>
                                <input type="text" class="form-control" id="inputPassword2" name="course" placeholder="course"
                                  value="{{$value->course}}"  required>
                            </div>

                            <div class="col-md-6">
                                <label for="category" >Category</label>
                                <select name="category" class="form-control" id="newCategory"   onchange="showcategory(this.value)">
                                    @if(isset($category) && $category)
                                        @foreach($category as $cat)
                                        <option value="{{$cat}}" {{ $cat == (isset($value) && $value->category?$value->category : '') ? 'selected' : ''}}>
                                            @if($cat=="IT")
                                            Internship
                                            @else
                                            {{$cat}}
                                            @endif

                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>



                            <div class="col-md-6" id="statec" >
                                <label for="statecode" id=lstatecode class="form-label">State Code </label>
                                <input type="text" class="form-control" id="statecode" name="statecode" placeholder="state code"
                                 value="{{$value->statecode}}"   >
                            </div>


                            <div class="col-md-6">

                                <div class="row">
                                <div class="col-md-6">
                                    <label for="pop" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startdate" name="startdate" aria-label="Server"
                                        placeholder="set Start date" class="form-control" value="{{$value->startdate}}" required>
                                </div>
                                
                                    <div class="col-md-6">
                                        <label for="pop" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="pop" name="pop" aria-label="Server"
                                            placeholder="set POP date" class="form-control" value="{{$value->pop}}" required>
                                    </div>
                                </div>
                                
                            </div>


                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div align="right" class="form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <a href="{{url('nysc')}}" class="btn btn-primary">
                                        Go Back <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div align="left" class="form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <input type="hidden" name="recordID" class="form-control" value="{{ (isset($editRecord) && $editRecord ? $editRecord->file_ID : '') }}"/>
                                    <button name="action" class="btn btn-success" type="submit">
                                        Update <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr />
        <hr />
    </div>
    </div><!-- /.col -->
    </div><!-- /.row -->

    </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection


    <script type="text/javascript" src = "{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script >
    function showcategory(str) {
     if (str == "Nysc") {
        $("#statec").css('display', 'block');
        // $('.popDiv').hide()
        return;
     }else{
        $("#statec").css('display', 'none');
        // $('.popDiv').show()
       }
      }

    $(document).ready(function(){
        let cat = $('#newCategory').val()
        if(cat == 'IT'){
            $('#statec').hide()
        }
        // else{
        //     $('.popDiv').hide()
        // }
        // console.log('good');
    })

    </script>

