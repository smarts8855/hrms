@extends('layouts_procurement.app')
@section('pageTitle', 'List of Contracts')
@section('content')



    <div class="row">
        <div class="col-md-12">



            <!-- Panel instead of card -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Select Contract To Confirm</h3>
                </div>
                <div class="panel-body">

                    <hr />

                    <div class="row">
                        <div class="form-group col-md-12" align="center">
                            <table class="table table-hover table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>LOT No</th>
                                        <th>Contract's Name</th>
                                        <th>Description</th>
                                        <th>Contract Amt</th>
                                        <th>Contractor's Name</th>
                                        <th>Awarded Amt</th>
                                        <th>Category</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($getContractDetails) && is_iterable($getContractDetails))
                                        @foreach ($getContractDetails as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->lot_number }}</td>
                                                <td>{{ $item->contract_name }}</td>
                                                <td>
                                                    {{ $item->contract_description ? substr($item->contract_description, 0, 100) : ' - ' }}
                                                    @if (strlen($item->contract_description) > 100)
                                                        ... <a href="javascript:;" class="text-info" data-toggle="modal"
                                                            data-target=".viewMoreDescription{{ $key }}">View
                                                            more</a>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($item->proposed_budget, 2) }}</td>
                                                <td><b>{{ $item->company_name }}</b></td>
                                                <td class="text-right">{{ number_format($item->awarded_amount, 2) }}</td>
                                                <td>{{ $item->category_name }}</td>
                                                <td>
                                                    <a href="javascript:;" data-toggle="modal"
                                                        data-target=".viewAllFile{{ $key }}"
                                                        class="btn btn-default btn-sm">Upload -
                                                        {{ isset($getAllFiles) ? count($getAllFiles[$key]) : 0 }}
                                                        File(s)</a>
                                                </td>
                                                <td>
                                                    @if ($item->completionID == 5)
                                                        <a href="javascript:;" title="Confirmed Already"
                                                            class="btn btn-success btn-sm">Confirmed</a>
                                                    @else
                                                        <a href="javascript:;" title="Confirm Now"
                                                            class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target=".sureToConfirm{{ $key }}">Confirm
                                                            Now</a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal View Description -->
                                            <div class="modal fade viewMoreDescription{{ $key }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $item->contract_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{!! $item->contract_description !!}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Confirm -->
                                            <div class="modal fade sureToConfirm{{ $key }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm!</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-success"><span class="text-info">Confirm:</span>
                                                                {!! $item->company_name . ' <br /> ' . $item->contract_name !!}</p>
                                                            <p class="text-info">Are you sure you want to proceed to
                                                                confirm this contract?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ Route::has('createConfirmation') ? Route('createConfirmation', ['id' => $item->biddingID]) : '#' }}"
                                                                class="btn btn-success">Continue to Confirm</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal View/Add Files -->
                                            <div class="modal fade viewAllFile{{ $key }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">View/Add More File</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if (isset($getAllFiles))
                                                                @foreach ($getAllFiles[$key] as $key2 => $fileItem)
                                                                    <div class="row table table-hover table-striped">
                                                                        <div class="col-md-2">{{ 1 + $key2 }}</div>
                                                                        <div class="col-md-4">
                                                                            <a target="_blank"
                                                                                href="{{ asset('PaymentRequestDocument/' . $fileItem->file_name) }}">
                                                                                <i class="fa fa-download"></i> View
                                                                                File</a>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            {{ $fileItem->file_description }}</div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ Route::has('attachMoreFile') ? Route('attachMoreFile', ['id' => $item->biddingID]) : '#' }}"
                                                                class="btn btn-success">Attach File</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Panel -->

        </div>
    </div>



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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('message') }}',
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
