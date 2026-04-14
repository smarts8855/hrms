@extends('layouts_procurement.app')
@section('pageTitle', 'Award Letter')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {{-- @include('ShareView.operationCallBackAlert') --}}

                <div class="panel-body">
                    <p>
                        <?php $para = base64_encode($id); ?>
                        <a href="/contracts-coments/{{ $para }}" target="_blank"
                            class="btn btn-success btn-xs text-white">View Minutes</a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Lot No.</th>
                                    <th>Contract</th>
                                    <th>Contractor</th>
                                    <th>Ref. No.</th>
                                    <th>Proposed Amount (NGN)</th>
                                    <th>Awarded Amount (NGN)</th>
                                    <th>Contract Number</th>
                                    <th>Date Issued</th>
                                    <th>Action</th>
                                    <th>Agreement Letter</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $n = 1; @endphp
                                @foreach ($getList as $list)
                                    <?php
                                    $checkx = DB::table('tblaward_letter')->where('bidding_id', $list->contract_biddingID)->exists();
                                    $check = DB::table('tblaward_letter')->where('bidding_id', $list->contract_biddingID)->where('location_unit', 2)->exists();
                                    $getDate = DB::table('tblaward_letter')->where('bidding_id', $list->contract_biddingID)->first();
                                    $isokay = DB::table('tblagreement_letter')->where('bidding_id', $list->contract_biddingID)->first();
                                    $para = base64_encode($list->contract_biddingID);
                                    ?>
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->lot_number }}</td>
                                        <td>{{ $list->contract_name }}</td>
                                        <td>{{ $list->company_name }}</td>
                                        <td>
                                            {{-- {{ $list->reference_number ?? 'N/A' }} --}}
                                            {{ $list->reference_number }}/{{ date('Y') }}
                                        </td>
                                        <td class="text-right">{{ number_format($list->proposed_budget, 2) }}</td>
                                        <td class="text-right">{{ number_format($list->awarded_amount, 2) }}</td>
                                        <td>
                                            @if ($checkx)
                                                {{ $getDate->department_number }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($checkx)
                                                {{ date('jS M, Y', strtotime($getDate->date_issued)) }}
                                            @endif
                                        </td>
                                        {{-- <td style="font-size:12px;">
                                            @if ($list->is_agreement == 1)
                                                @if ($checkx)
                                                    <a href="/view-letter/{{ $para }}" target="_blank"
                                                        class="btn btn-default btn-xs">View/Print</a>
                                                    <a href="/edit-letter/{{ $para }}"
                                                        class="btn btn-success btn-xs">Edit</a>
                                                @endif
                                            @else
                                                @if ($checkx)
                                                    <button class="btn btn-primary btn-xs"
                                                        onclick="awardLetter('{{ $list->contract_biddingID }}')">
                                                        <i class="fa fa-pen"></i> Award Letter
                                                    </button>
                                                @endif

                                                @if ($checkx && !$check)
                                                    <button class="btn btn-success btn-xs"
                                                        onclick="confirmValue('{{ $list->contract_biddingID }}')">
                                                        Award Completion
                                                    </button>
                                                @endif
                                            @endif
                                        </td> --}}


                                        <td style="font-size:12px; width:100px;">
                                            <div class="btn-group-vertical btn-group-xs"
                                                style="display: flex; flex-wrap: wrap; gap: 3px;">
                                                @php
                                                    $para = base64_encode($list->contract_biddingID);
                                                    $hasAwardLetter = DB::table('tblaward_letter')
                                                        ->where('bidding_id', $list->contract_biddingID)
                                                        ->exists();
                                                    $hasAgreementLetter = $list->is_agreement;
                                                @endphp

                                                {{-- Always show at least a button to process or view --}}
                                                @if ($hasAwardLetter)
                                                    <a href="/view-letter/{{ $para }}" target="_blank"
                                                        class="btn btn-default btn-xs">View/Print</a>
                                                    <a href="/edit-letter/{{ $para }}"
                                                        class="btn btn-success btn-xs">Edit</a>
                                                @else
                                                    <button class="btn btn-primary btn-xs"
                                                        onclick="awardLetter('{{ $list->contract_biddingID }}')">
                                                        <i class="fa fa-pen"></i> Award Letter
                                                    </button>
                                                @endif

                                                {{-- Show Agreement Processing if not processed --}}
                                                @if ($hasAwardLetter && $hasAgreementLetter == 0)
                                                    <button class="btn btn-success btn-xs"
                                                        onclick="agreeLetter('{{ $list->contract_biddingID }}')">
                                                        Process Agreement
                                                    </button>
                                                @elseif($hasAgreementLetter == 1)
                                                    <span class="text-success" style="font-size:11px; width:100%;">In
                                                        Performance Evaluation</span>
                                                    <button class="btn btn-success btn-xs"
                                                        onclick="recallLetter('{{ $list->contract_biddingID }}')">Recall</button>
                                                @elseif($hasAgreementLetter == 2)
                                                    <a href="/view-agreed-letter/{{ $para }}" target="_blank"
                                                        class="btn btn-primary btn-xs">View/Confirm Agreement</a>
                                                @endif
                                            </div>
                                        </td>


                                        <td style="font-size:12px; width:120px;">
                                            <div class="btn-group-vertical btn-group-xs"
                                                style="display: flex; flex-wrap: wrap; gap: 3px;">

                                                @if ($list->is_agreement == 1)
                                                    <span class="text-success" style="font-size:11px">In Performance
                                                        Evaluation for Agreement</span>
                                                    <button class="btn btn-success btn-xs"
                                                        onclick="recallLetter('{{ $list->contract_biddingID }}')">Recall</button>
                                                @elseif($list->is_agreement == 2)
                                                    @if ($isokay && $isokay->is_okay == 1)
                                                        <a href="/view-agreed-letter/{{ $para }}" target="_blank"
                                                            class="text-primary">View/Confirm Agreement Letter</a>
                                                    @else
                                                        <span class="text-success" style="font-size:11px">In Performance
                                                            Evaluation for Agreement</span>
                                                    @endif
                                                @elseif($list->is_agreement == 0)
                                                    <button class="btn btn-primary btn-xs"
                                                        onclick="agreeLetter('{{ $list->contract_biddingID }}')">Process
                                                        for
                                                        Agreement</button>
                                                    @if ($list->is_agreement_reverse == 1)
                                                        <span
                                                            style="font-size:11px;color:green;font-weight:bold;font-style:italic">Agreement
                                                            Letter Reversed</span>
                                                    @endif
                                                @endif
                                            </div>

                                        </td>
                                    </tr>

                                    <!-- Modals -->
                                    <!-- The Modal -->
                                    <div class="modal" id="myModal{{ $list->contract_biddingID }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal body -->
                                                <div class="modal-body">

                                                    <form method="post" action="{{ route('recall-letter') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <input type="hidden" class="form-control" id="bid"
                                                            name="bid" value="{{ $list->contract_biddingID }}">

                                                        <div style="background-color:#fff">
                                                            <h3>
                                                                <center>Are you sure you want to recall?</center>
                                                            </h3>
                                                        </div>

                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-success waves-effect waves-light">Yes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="myModalx{{ $list->contract_biddingID }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal body -->
                                                <div class="modal-body">

                                                    <form method="post" action="{{ route('push-to-secretary') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <input type="hidden" class="form-control" id="bid"
                                                            name="bid" value="{{ $list->contract_biddingID }}">

                                                        <div style="background-color:#fff">
                                                            <h3>
                                                                <center>Are you sure?</center>
                                                            </h3>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="comment">Comment:</label>
                                                            <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                                        </div>

                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-success waves-effect waves-light">Yes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Award Letter Modal-->
                                    <div class="modal" id="awardletterModal{{ $list->contract_biddingID }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title"> Award Letter</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <h5 class=""> Awarded Amount: NGN {{ number_format($list->awarded_amount, 2) }}</h5>
                                                    <form method="post" action="{{ route('save-award-letter') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="hidden" class="form-control" id="cbid" name="cbid" value="{{ $list->contract_biddingID }}">
                                                            <input type="hidden" class="form-control" id="approval_amt" name="approval_amt" value="{{ $list->awarded_amount }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Contract Number</label>
                                                            <input type="text" class="form-control" id="department_number" name="department_number" 
                                                                value="" placeholder="Enter Contract Number" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Type Letter</label>
                                                                                <textarea id="tinymce_full{{ $list->contract_biddingID }}" name="letter" style="width:100%; height:400px">
                                                        <p style="text-align:right; margin-bottom:30px;">
                                                            {{ date('jS M, Y') }}
                                                        </p>

                                                        <p style="text-align:left; margin-bottom:70px;">
                                                            <strong style="text-decoration: underline;">{{ $list->reference_number }}/{{ date('Y') }}</strong><br />
                                                            Managing Director, <br>
                                                            <strong>{{ $list->company_name }}</strong> <br>
                                                            {{ $list->address }}
                                                        </p>

                                                        <p style="text-align:center;">
                                                            <u><strong>{{ strtoupper($list->contract_name) }}</strong></u>
                                                        </p>

                                                       <p style="text-align:left;">
                                                            Your proposal dated 
                                                            {{ \Carbon\Carbon::parse($list->bidding_date)->format('jS F, Y') }} 
                                                            for the <strong>{{ $list->contract_name }}</strong> 
                                                            at the sum of NGN {{ number_format($list->awarded_amount, 2) }} was successful.
                                                        </p>

                                                        <p style="text-align:justify;">
                                                            You are requested to proceed with the renewal with the specification submitted in your quotation.
                                                        </p>
                                                        <p style="text-align: justify;">
                                                            Please note that the Letter of Award shall constitute the formation of a contract, after signing of Contract Agreement and upon your submission of an acceptance letter within one week from the date of this award.
                                                        </p>
                                                        <p style="text-align:justify;">
                                                            You are required to submit your documents requesting for payment stating your account details including your Company Tax Identification Number to the Chief Registrar.
                                                        </p>
                                                        <p style="text-align: left; font-weight:bold">
                                                            <br><br>
                                                            OLAYEMI NWANKWO (MRS)<br/>
                                                           DIRECTOR PROCUREMENT <br/>
                                                            FOR: CHIEF REGISTRAR
                                                        </p>
                                                            </textarea>
                                                        </div>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Create</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Agreement Letter Modal with Card Style (Bootstrap 3) -->
                                    <div class="modal fade" id="agreeletterModal{{ $list->contract_biddingID }}"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="agreeLetterLabel{{ $list->contract_biddingID }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Card Wrapper -->
                                                <div class="panel panel-default">

                                                    <!-- Modal Header as Card Header -->
                                                    <div class="panel-heading" style="background-color:#f5f5f5;">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="panel-title">Agreement Letter</h4>
                                                    </div>

                                                    <!-- Modal Body as Card Body -->
                                                    <div class="panel-body">
                                                        <form method="post"
                                                            action="{{ route('save-agreement-letter') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="cbid"
                                                                value="{{ $list->contract_biddingID }}">

                                                            <div class="form-group text-center">
                                                                <label><strong>Are you sure you want to process the
                                                                        Agreement Letter?</strong></label>
                                                            </div>

                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Enter Comment (Optional)"></textarea>
                                                            </div>

                                                            <!-- Modal Footer as Card Footer -->
                                                            <div class="panel-footer text-right">
                                                                <button type="submit"
                                                                    class="btn btn-success">Yes</button>
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">No</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-md-12 -->
    </div> <!-- row -->


    <!-- Modal  -->

    <!-- Button to Open the Modal -->
    <!-- The Modal -->
    </div>

    <!-- End Modal-->

@endsection

@section('styles')

    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>

@endsection

@section('scripts')

    {{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

    <script>
        function awardLetter(x) {
            // Check if TinyMCE is already initialized
            if (!tinymce.get('tinymce_full' + x)) {
                tinymce.init({
                    selector: "#tinymce_full" + x,
                    width: "100%",
                    height: 400,
                    plugins: "advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks fullscreen insertdatetime media table emoticons paste",
                    toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                    toolbar2: "print preview media | forecolor backcolor emoticons",
                    image_advtab: true
                });
            }

            // Show the modal
            $("#awardletterModal" + x).modal('show');
        }


        function agreeLetter(x) {

            $("#agreeletterModal" + x).modal('show');
        }

        function recallLetter(x) {

            $("#myModal" + x).modal('show');
        }
    </script>

    <script>
        function confirmValue(x) {
            //alert(x);
            //document.getElementById('contrator').value=y;
            $("#myModalx" + x).modal('show');

        }

        function isValue(y) {
            alert('Award letter has not been created. Please create award letter');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('msg') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif







@endsection
