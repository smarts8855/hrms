@extends('layouts.layout')
@section('pageTitle')
    NYSC
@endsection
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
            <div class="col-lg-1" style="float:right;"><img
                    src="https://upload.wikimedia.org/wikipedia/en/7/71/National_Youth_Service_Corps_logo.jpg"
                    class="img-thumbnail" alt="NYSC LOGO"></div>
            <div class="row">
                <div align="center">
                    <h3>Register Youth Corper/ Internship</h3>
                </div>
                <hr />
                @includeIf('Share.message')





                <form method="post" action="{{ url('/nysc-save') }}" class="form-horizontal">
                    @csrf

                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}"
                            aria-label="Last name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="staticEmail2" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="staticEmail2" value="{{old('email')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="staticEmail2" class="form-label">Phone</label>
                        <input type="tel" class="form-control" name="phone" id="phone" value="{{old('phone')}}">
                    </div>

                    <div class="col-md-6">
                        <label for="inputPassword2" class="form-label">Course</label>
                        <input type="text" class="form-control" id="inputPassword2" name="course" value="{{old('course')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="category">Category</label>
                        <select name="category" class="form-control" onchange="showcategory(this.value)">
                            <option value=""> --Choose Category-- </option>
                            @if (isset($category) && $category)
                                @foreach ($category as $cat)
                                    <option value="{{ $cat }}" {{ $cat == old('category') ? 'selected' : '' }}>
                                        @if ($cat == 'IT')
                                            Internship
                                        @else
                                            {{ $cat }}
                                        @endif
                                        {{-- {{$cat}}</option> --}}
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6" id="statec">
                        <label for="statecode" id=lstatecode class="form-label">State Code </label>
                        <input type="text" class="form-control" id="statecode" name="statecode" value="{{old('statecode')}}">
                    </div>
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="pop" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startdate" name="startdate"
                                    aria-label="Server" placeholder="set Start date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="pop" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="pop" name="pop" aria-label="Server"
                                    placeholder="set POP date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary mb-3">register</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <label>Category</label>
                    <select name="grade" id="cate" class="form-control" required>
                        <option value="" selected>Select Category</option>
                        @foreach ($category as $cat)
                            <option value="{{ $cat }}">
                                @if ($cat == 'IT')
                                    Internship
                                @else
                                    {{ $cat }}
                                @endif
                            </option>

                            {{-- <option value="{{ $i }}" {{ ($grade) == $i ? "selected":"" }}>{{$i}}</option> --}}
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Year</label>
                    <select name="ald" id="newYear" class="form-control" required>
                        <option value="" selected>Select year</option>
                        @for ($i = date('Y'); $i >= 2010; $i--)
                            <option value="{{ $i }}" {{ $i == old('category') ? 'selected' : '' }}>
                                {{ $i }}</option>
                            {{-- <option value="{{ $i }}" >{{$i}}</option> --}}
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <br>
                    <button type="submit" class="btn btn-success" id="searchBtn" name="Search">
                        Search
                    </button>
                </div>

            </div>
            <div class="table-responsive" id="tableID">
                @include('Nysc.nysctable')

            </div>
        </div>
    </div>



    

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection


<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
    function showcategory(str) {
        if (str == "Nysc") {
            $("#statec").css('display', 'block');
            // $('.popDiv').hide();
            return;
        } else {
            $("#statec").hide().css('display', 'none');
            // $('.popDiv').show();
        }
    }




    $(document).ready(function() {

        console.log('timely');
        //  $('.js-example-basic-single').select2();
        $('#searchBtn').click(function() {
            console.log("hello");
            let category = $('#cate').val();
            let year = $('#newYear').val();
            console.log('hi Gift');
            console.log(year);
            //   if (category == "" && year == "") {
            console.log('timely');

            $.ajax({
                url: "/nysc?category=" + category + "&search_year=" + year,
                success: function(data) {


                    $('#tableID').html(data);


                }
            });
            //     window.location.href = "/nysc";
            //     //  "{{ route('viewNysc') }}";

            // } else if (category !== "" && year !== "") {

            //     console.log('timely1');
            //     window.location.href = "/nysc?category=" + category + "&search_year=" + year;
            // } else if (category !== "" && year == "") {
            //     window.location.href = "/nysc?category=" + category;
            //     console.log('timely2');

            // } else {
            //     window.location.href = "/nysc?search_year=" + year;
            //     console.log('timely3');

            // }

        });
    });
</script>
