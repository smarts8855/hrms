@extends('layouts.app')
@section('pageTitle', 'Bank')
@section('pageMenu', 'active')
@section('content')
@include('Bank.layouts.messages')
@include('Bank.create')
 
<div class="row" style="margin-top:150px;">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Bank Name</th>
                        <th>Bank Code</th>
                        <th>Sort Code</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                @foreach($banks as $bank)
                    <tr>
                                                <th scope="row align-items-center">{{$bank->bankID}}</th>
                              <td>{{$bank->bank}}</td>
                              <td>{{$bank->bank_code}}</td>
                              <td>{{$bank->sort_code}}</td>
                              <td class="row align-items-center"><div class="modal fade" id={{$bank->bank}} tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                          aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Edit Bank</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body mx-3">
                                <form class="text-center" style="color: #757575;" action="{{route('banks.update',$bank->bankID)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row" style="margin-bottom:30px;">
                                        <div class="col">
                                            <!-- Bank Name -->
                                            <div class="md-form">
                                                <label for="bank_name" class="float-left">Bank Name <span class="astericks" style="color:red">*</span></label>
                                                <input type="text" name="bank_name" id="bank_name" value="{{$bank->bank}}" class="form-control">
                                                
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Bank Code -->
                                            <div class="md-form">
                                                <label for="bank_code" class="float-left">Bank Code</label>
                                                <input type="text" name="bank_code" id="bank_code" value="{{$bank->bank_code}}" class="form-control">
                                                
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Sort Code -->
                                    <div class="md-form mt-0">
                                        <label for="sort_code" class="float-left">Sort Code <span class="astericks" style="color:red">*</span></label>
                                        <input type="text" name="sort_code" id="sort_code" value="{{$bank->sort_code}}" class="form-control">
                                        
                                    </div>
                        
                        
                          
                        
                                    <!-- Update button -->
                                    <button class="btn btn-outline-success btn-rounded my-4 waves-effect z-depth-0" type="submit">Update</button>
                                    <hr>
                        
                                   
                        
                                </form>
                                <!-- Form -->
                        
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        
                        <div class="text-center">
                          <a href="" style="margin-left:15px; margin-right:15px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target={{'#'.$bank->bank}}>Edit</a>
                        </div>
                                <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target={{'#delete'.$bank->bank}}>
                                         Delete
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id={{'delete'.$bank->bank}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$bank->bank}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                               Are you sure you want to delete {{$bank->bank}}
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{route('banks.destroy',$bank->bankID)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary">Delete Bank</button>
                                                </form>
                                                
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                               
                              </td>
                    </tr>
                @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

                                                

@endsection

@section('styles')
   
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>
@endsection