@extends('layouts_procurement.app')
@section('pageTitle', 'Add Bid')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
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
                    {{ session('msg') }}
                </div>                        
                @endif
                @if(session('err'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Input Error!</strong> 
                    {{ session('err') }}
                </div>                        
                @endif
            </div>
            
            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>Add Contract Bidding</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-gavel"></i> New Bid Submission
                            </h4>
                        </div>
                    </div>
                </div>
                <div align="right" style="margin-bottom: 15px;"> All fields with <span class="text-danger">*</span> are required.</div>
                
                <form class="custom-validation" method="post" action="{{url('/add-bidding')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contract <span class="text-danger">*</span></label>
                                <select class="form-control" name="contract" required>
                                    <option value="">Select Contract</option>
                                    @foreach($contract as $list)
                                    <option value="{{$list->contract_detailsID}}" @if($list->contract_detailsID == session('contractSess')) selected @endif>{{$list->contract_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contractor <span class="text-danger">*</span></label>
                                <select class="form-control" name="contractor" required>
                                    <option value="">Select Contractor</option>
                                    @foreach($contractor as $list)
                                    <option value="{{$list->contractor_registrationID}}" @if($list->contractor_registrationID == session('contractorSess')) selected @endif>{{$list->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contractor Remark <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="contractorRemark" rows="3" placeholder="Enter contractor remarks" required>{{session('contractRemarkSess')}}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bidding Amount <span class="text-danger">*</span></label>
                                <input type="text" name="biddingAmount" class="form-control bidAmt" placeholder="Enter bidding amount" value="{{session('amountSess')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Submitted <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}" value="{{session('dateSess')}}" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Documents Section -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-file-alt mr-2"></i>Supporting Documents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="inputWrap">
                                <div class="wraps" id="1">
                                    <div class="row">
                                        <div class="col-md-12 text-right mb-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-doc" style="display: none;">
                                                <i class="fa fa-times mr-1"></i> Remove
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Document</label>
                                                <input type="file" name="document[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Document Description</label>
                                                <input type="text" name="description[]" class="form-control" placeholder="Enter document description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="button" id="add" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-plus mr-1"></i> Add More Documents
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check mr-1"></i> Submit Bid
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .remove-doc {
        transition: all 0.3s ease;
    }
    
    .btn {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .form-control {
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-color: #007bff;
    }
    
    .card {
        border-radius: 8px;
    }
</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery.3.4.1.slim.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Number formatting for bidding amount
        $(".bidAmt").on('keyup', function(evt){
            $(this).val(function (index, value) {
                return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        // Add more documents
        $('#add').click(function() {
            var total_element = $(".wraps").length;
            var n = total_element + 1;
            
            $('#inputWrap').append(
                `<div class="wraps mt-3" id="` + n + `">
                    <div class="row">
                        <div class="col-md-12 text-right mb-2">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-doc">
                                <i class="fa fa-times mr-1"></i> Remove
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Document</label>
                                <input type="file" name="document[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Document Description</label>
                                <input type="text" name="description[]" class="form-control" placeholder="Enter document description">
                            </div>
                        </div>
                    </div>
                </div>`
            );
            
            // Show remove button on first document when multiple exist
            if ($(".wraps").length > 1) {
                $(".remove-doc").show();
            }
        });

        // Remove document section
        $(document).on('click', '.remove-doc', function(){
            if ($(".wraps").length > 1) {
                $(this).closest('.wraps').remove();
            }
            
            // Hide remove button if only one document remains
            if ($(".wraps").length === 1) {
                $(".remove-doc").hide();
            }
        });
    });
</script>
@endsection