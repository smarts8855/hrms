@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Bid')
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
                            <h3 class="box-title"><b>Edit Contract Bidding</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-edit"></i> Update Bid Information
                            </h4>
                        </div>
                    </div>
                </div>
                <div align="right" style="margin-bottom: 15px;"> All fields with <span class="text-danger">*</span> are required.</div>
                
                <form class="custom-validation" method="post" action="{{url('/bidding-update')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contract <span class="text-danger">*</span></label>
                                <select class="form-control" name="contract" required>
                                    <option value="">Select Contract</option>
                                    @foreach($contract as $list)
                                    <option value="{{$list->contract_detailsID}}" @if($edit->contract_detailsID == $list->contract_detailsID) selected @endif>{{$list->contract_name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="bidID" value="{{$biddingID}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contractor <span class="text-danger">*</span></label>
                                <select class="form-control" name="contractor" required>
                                    <option value="">Select Contractor</option>
                                    @foreach($contractor as $list)
                                    <option value="{{$list->contractor_registrationID}}" @if($edit->contractorID ==$list->contractor_registrationID) selected @endif>{{$list->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contractor Remark <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="contractorRemark" rows="3" placeholder="Enter contractor remarks" required>{{$edit->contractor_remark}}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bidding Amount <span class="text-danger">*</span></label>
                                <input type="text" name="biddingAmount" class="form-control bidAmt" placeholder="Enter bidding amount" value="{{number_format($edit->bidding_amount,2)}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Submitted <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}" value="{{$edit->date_submitted}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1" @if($edit->bidStatus == 1) selected @endif>Active</option>
                                    <option value="2" @if($edit->bidStatus == 2) selected @endif>Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Documents Table -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-file-alt mr-2"></i>Technical Documents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Document Description</th>
                                            <th>Date Uploaded</th>
                                            <th width="100">Preview</th>
                                            <th width="80">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($viewDocumentsTechnical as $list)
                                            @if($list->bidDocument)
                                            <tr>
                                                <td>{{$n++}}</td>
                                                <td>{{$list->doc_description ?? $list->file_description}}</td>
                                                <td>{{$list->updated_at ? date("jS M, Y", strtotime($list->updated_at)) : 'Not uploaded'}}</td>
                                                <td class="text-center">
                                                    @if($list->bidDocument)
                                                    <a href="{{asset('/BiddingDocument/'.$list->bidDocument)}}" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fa fa-eye mr-1"></i>Preview
                                                    </a>
                                                    @else
                                                    <span class="text-muted">No document</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($list->contractor_bidding_documentID)
                                                    <a href="{{url('/delete-bidding/doc/'.$list->contractor_bidding_documentID)}}" onclick="return confirmDelete();" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @if($viewDocumentsTechnical->where('bidDocument')->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">
                                                    No technical documents found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Documents Table -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-file-invoice-dollar mr-2"></i>Financial Documents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Document Description</th>
                                            <th>Date Uploaded</th>
                                            <th width="100">Preview</th>
                                            <th width="80">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($viewDocumentsFinancial as $list)
                                            @if($list->bidDocument)
                                            <tr>
                                                <td>{{$n++}}</td>
                                                <td>{{$list->doc_description ?? $list->file_description}}</td>
                                                <td>{{$list->updated_at ? date("jS M, Y", strtotime($list->updated_at)) : 'Not uploaded'}}</td>
                                                <td class="text-center">
                                                    @if($list->bidDocument)
                                                    <a href="{{asset('/BiddingDocument/'.$list->bidDocument)}}" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fa fa-eye mr-1"></i>Preview
                                                    </a>
                                                    @else
                                                    <span class="text-muted">No document</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($list->contractor_bidding_documentID)
                                                    <a href="{{url('/delete-bidding/doc/'.$list->contractor_bidding_documentID)}}" onclick="return confirmDelete();" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @if($viewDocumentsFinancial->where('bidDocument')->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">
                                                    No financial documents found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Documents Section -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-plus-circle mr-2"></i>Additional Documents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="inputWrap">
                                <!-- Dynamic content will be added here -->
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
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check mr-1"></i> Update Bid
                                </button>
                                <a href="{{url('/add-bidding')}}" class="btn btn-primary">
                                    <i class="fa fa-plus mr-1"></i> Add New Bid
                                </a>
                                <a href="{{url('/view-bidding')}}" class="btn btn-info">
                                    <i class="fa fa-list mr-1"></i> View All Bids
                                </a>
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
    
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('scripts')
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

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this document?');
    }
</script>
@endsection