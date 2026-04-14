@extends('layouts_procurement.app')
@section('pageTitle', 'Award Letter')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('ShareView.operationCallBackAlert')
            </div>
            
            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>Award Letters Management</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-trophy"></i> Total Awards: {{ $getList->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border hidden-print text-center">
                            <hr>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                @php $para = base64_encode($id) @endphp
                                <a href="/contracts-coments/{{$para}}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fa fa-file-alt mr-1"></i> View Minutes
                                </a>
                            </div>
                        </div>

                        <!-- Awards Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed table-bordered">
                                <thead class="text-gray-b">
                                    <tr>
                                        <th>S/N</th>
                                        <th>LOT NO.</th>
                                        <th>CONTRACT</th>
                                        <th>CONTRACTOR</th>
                                        <th>PROPOSED AMOUNT</th>
                                        <th>AWARDED AMOUNT</th>
                                        <th>CONTRACT NUMBER</th>
                                        <th>DATE ISSUED</th>
                                        <th>ACTIONS</th>
                                        <th>AGREEMENT LETTER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @foreach($getList as $list)
                                        @php
                                            $checkx = DB::table('tblaward_letter')->where('bidding_id',$list->contract_biddingID)->exists();
                                            $check = DB::table('tblaward_letter')->where('bidding_id',$list->contract_biddingID)->where('location_unit',2)->exists();
                                            $getDate = DB::table('tblaward_letter')->where('bidding_id',$list->contract_biddingID)->first();
                                            $isokay=DB::table('tblagreement_letter')->where('bidding_id',$list->contract_biddingID)->first();
                                            $para = base64_encode($list->contract_biddingID);
                                            $x = $list->contract_biddingID;
                                        @endphp
                                        <tr>
                                            <td>{{$n++}}</td>
                                            <td class="font-weight-bold">{{$list->lot_number}}</td>
                                            <td class="font-weight-bold">{{$list->contract_name}}</td>
                                            <td class="font-weight-bold">{{$list->company_name}}</td>
                                            <td class="text-right font-weight-bold">{{ number_format($list->proposed_budget, 2) }}</td>
                                            <td class="text-right font-weight-bold text-primary">{{ number_format($list->awarded_amount, 2) }}</td>
                                            <td>
                                                @if($checkx==true) 
                                                    <span class="badge badge-info">{{ $getDate->department_number }}</span>
                                                @else 
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($checkx==true) 
                                                    @php $dateissued = DB::table('tblaward_letter')->where('bidding_id',$list->contract_biddingID)->first(); @endphp
                                                    {{ date("jS M, Y", strtotime($dateissued->date_issued)) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($list->is_agreement==1)
                                                    @if($checkx==true)
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="/view-letter/{{$para}}" target="_blank" class="btn btn-info">
                                                                <i class="fa fa-eye mr-1"></i> View
                                                            </a>
                                                            <a href="/edit-letter/{{$para}}" class="btn btn-success">
                                                                <i class="fa fa-edit mr-1"></i> Edit
                                                            </a>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if($checkx==true)
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="/view-letter/{{$para}}" target="_blank" class="btn btn-info">
                                                                <i class="fa fa-eye mr-1"></i> View
                                                            </a>
                                                            <a href="/edit-letter/{{$para}}" class="btn btn-success">
                                                                <i class="fa fa-edit mr-1"></i> Edit
                                                            </a>
                                                        </div>
                                                        @if(!$check)
                                                            <button class="btn btn-outline-success btn-sm mt-1" onclick="confirmValue('{{$list->contract_biddingID}}')">
                                                                <i class="fa fa-check mr-1"></i> Award Completion
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-outline-primary btn-sm" onclick="awardLetter('{{$list->contract_biddingID}}')">
                                                            <i class="fa fa-pen mr-1"></i> Award Letter
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($list->is_agreement==1)
                                                    <span class="badge badge-warning">In Performance Evaluation</span>
                                                    <button class="btn btn-outline-warning btn-sm mt-1" onclick="recallLetter('{{$list->contract_biddingID}}')">
                                                        <i class="fa fa-undo mr-1"></i> Recall
                                                    </button>
                                                @elseif($list->is_agreement==2)
                                                    @if($isokay->is_okay==1)
                                                        <a href="/view-agreed-letter/{{$para}}" target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fa fa-file-contract mr-1"></i> View Agreement
                                                        </a>
                                                    @else
                                                        <span class="badge badge-warning">In Performance Evaluation</span>
                                                    @endif
                                                @elseif($list->is_agreement==0)
                                                    <button class="btn btn-outline-primary btn-sm" onclick="agreeLetter('{{$list->contract_biddingID}}')">
                                                        <i class="fa fa-file-signature mr-1"></i> Process Agreement
                                                    </button>
                                                    @if($list->is_agreement_reverse==1) 
                                                        <span class="badge badge-danger mt-1">Agreement Reversed</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Recall Modal -->
                                        <div class="modal fade text-left d-print-none" id="myModal{{$list->contract_biddingID}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-undo"></i> Recall Agreement
                                                        </h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{ route('recall-letter') }}" enctype="multipart/form-data">  
                                                        @csrf
                                                        <div class="modal-body text-center">
                                                            <input type="hidden" name="bid" value="{{ $list->contract_biddingID}}">
                                                            <div class="text-warning mb-3">
                                                                <i class="fa fa-exclamation-triangle fa-3x"></i>
                                                                <h4 class="mt-3">Confirm Recall</h4>
                                                                <p>Are you sure you want to recall this agreement?</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning">Yes, Recall</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Award Completion Modal -->
                                        <div class="modal fade text-left d-print-none" id="myModalx{{$list->contract_biddingID}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-check"></i> Award Completion
                                                        </h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{ route('push-to-secretary') }}" enctype="multipart/form-data">  
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="bid" value="{{ $list->contract_biddingID}}">
                                                            <div class="text-center mb-3">
                                                                <i class="fa fa-question-circle fa-3x text-success"></i>
                                                                <h4 class="mt-3">Confirm Completion</h4>
                                                                <p>Are you sure you want to mark this award as complete?</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Comment (Optional):</label>
                                                                <textarea class="form-control" rows="3" name="comment" placeholder="Enter any additional comments..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success">Yes, Complete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Award Letter Modal -->
                                        <div class="modal fade text-left d-print-none" id="awardletterModal{{$list->contract_biddingID}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-trophy"></i> Create Award Letter
                                                        </h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{ route('save-award-letter') }}" enctype="multipart/form-data">  
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="alert alert-info">
                                                                <i class="fa fa-info-circle mr-2"></i>
                                                                <strong>Awarded Amount: NGN {{ number_format($list->awarded_amount,2)}}</strong>
                                                            </div>
                                                            <input type="hidden" name="cbid" value="{{ $list->contract_biddingID}}">
                                                            <input type="hidden" name="approval_amt" value="{{ $list->awarded_amount}}">
                                                            <div class="form-group">
                                                                <label>Contract Number <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="department_number" placeholder="Enter contract number" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Award Letter Content <span class="text-danger">*</span></label>
                                                                <textarea id="tinymce_full{{$list->contract_biddingID}}" name="letter" style="width:100%; height:400px">
                                                                    <p style="text-align:right; margin-bottom:30px;">{{date('jS M, Y')}}</p>
                                                                    <p style="text-align:left; margin-bottom:70px;">SCN/PROC/REC/.../{{date('Y')}}<br/>Managing Director,</p>
                                                                    <p style="text-align:center;"><u><strong>LETTER OF AWARD</strong></u></p>
                                                                    <p style="text-align:left;">I am directed to inform you that you have been awarded contract for the <strong>{{$list->contract_name}}</strong>.</p>
                                                                    <p>2. The Cost of the contract is NGN {{ number_format($list->awarded_amount,2)}}.</p>
                                                                    <p>3. Please, note that the specifies of the contract are as per the attached proposal.</p>
                                                                    <p style="text-align: center">
                                                                        <h2 style="text-align: center">Mr John Doe</h2><br/>
                                                                        Ag. Head, Procurement <br/>
                                                                        (For: Chief Registrar)
                                                                    </p>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Create Award Letter</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Agreement Letter Modal -->
                                        <div class="modal fade text-left d-print-none" id="agreeletterModal{{$list->contract_biddingID}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-file-signature"></i> Process Agreement Letter
                                                        </h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{ route('save-agreement-letter') }}" enctype="multipart/form-data">  
                                                        @csrf
                                                        <div class="modal-body text-center">
                                                            <input type="hidden" name="cbid" value="{{ $list->contract_biddingID}}">
                                                            <div class="mb-3">
                                                                <i class="fa fa-question-circle fa-3x text-primary"></i>
                                                                <h4 class="mt-3">Process Agreement Letter?</h4>
                                                                <p>Are you sure you want to process the agreement letter for this contract?</p>
                                                            </div>
                                                            <div class="form-group text-left">
                                                                <label>Comment (Optional):</label>
                                                                <textarea class="form-control" rows="3" name="comment" placeholder="Enter any comments..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Yes, Process</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($getList->count() == 0)
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa fa-trophy fa-3x mb-3"></i>
                                <h4>No Award Letters</h4>
                                <p>No award letters available for processing.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.04);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .btn {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 15px;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    function awardLetter(x) {
        tinymce.init({
            selector: "#tinymce_full"+x,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools","media"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true
        });
        $("#awardletterModal"+x).modal('show');
    }
    
    function agreeLetter(x) {
        $("#agreeletterModal"+x).modal('show');
    }
    
    function recallLetter(x) {
        $("#myModal"+x).modal('show');
    }
    
    function confirmValue(x) {
        $("#myModalx"+x).modal('show');
    }
    
    function isValue(y) {
        alert('Award letter has not been created. Please create award letter');
    }
</script>
@endsection