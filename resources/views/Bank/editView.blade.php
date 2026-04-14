@extends('layouts.app')
@section('content')
    <!-- Material form register -->
<div class="card col-5 no-gutters" style="padding:0px">

    <h5 class="card-header black white-text text-center py-4">
        <strong>Update Bank</strong>
    </h5>

    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">

        <!-- Form -->
        <form class="text-center" style="color: #757575;" action="{{route('banks.update',$bank->bankID)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <input type="text" name="bank_name" id="bank_name" value="{{$bank->bank_name}}" class="form-control">
                        <label for="bank_name">Bank Name</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <input type="text" name="bank_code" id="bank_code" value="{{$bank->bank_code}}" class="form-control">
                        <label for="bank_code">Bank Code</label>
                    </div>
                </div>
            </div>

            <!-- E-mail -->
            <div class="md-form mt-0">
                <input type="number" name="sort_code" id="sort_code" value="{{$bank->sort_code}}" class="form-control">
                <label for="sort_code">Sort Code</label>
            </div>

            <!-- Password -->
            <div class="md-form">
                <input type="text" id="details" name="details" value="{{$bank->tbl_bank_details}}" class="form-control" aria-describedby="detailsDescription">
                <label for="details">Details</label>
                <small id="detailsHelp" class="form-text text-muted mb-4">
                    At least 8 characters long
                </small>
            </div>

  

            <!-- Sign up button -->
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Update</button>
            <hr>

            <!-- Terms of service -->
            <p>By clicking
                <em>Update</em> you agree to our
                <a href="" target="_blank">terms of service</a>

        </form>
        <!-- Form -->

    </div>

</div>
<!-- Material form register -->
@endsection