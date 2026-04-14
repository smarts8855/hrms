@extends('layouts_procurement.app')
@section('pageTitle', 'Contractor Registration')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <!-- Card header -->
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">Contractor Details</h3>
                    <span class="pull-right">
                        All fields with <span class="text-danger">*</span> are required.
                    </span>
                </div>

                <!-- Card body -->
                <div class="panel-body">

                    <div>
                        @include('procurement.ShareView.operationCallBackAlert')
                    </div>
                    <h5>
                        <div class="p-2"><b>LOT Number:</b>
                            {{ isset($recordDetails) ? $recordDetails->lot_number : '' }}
                        </div>

                        <div class="p-2"><b>Name of Contract:</b>
                            {{ isset($recordDetails) ? $recordDetails->contract_name : '' }}
                        </div>

                        <div class="p-2"><b>Name of Contractor:</b>
                            {{ isset($recordDetails) ? $recordDetails->company_name : '' }}
                        </div>

                        <div class="p-2"><b>Contract Amount:</b>
                            {{ isset($recordDetails) ? number_format($recordDetails->proposed_budget, 2) : '' }}
                        </div>

                        <div class="p-2"><b>Awarded Amount:</b>
                            {{ isset($recordDetails) ? number_format($recordDetails->awarded_amount, 2) : '' }}
                        </div>
                    </h5>

                    <h4 class="text-center alert alert-info" style="font-weight:bold;">
                        Job Completion Documents
                        <br>
                        <small class="text-danger">PNG, JPG, JPEG, PDF | Max: 10MB</small>
                    </h4>

                    <hr />

                    <form id="contractor_form" class="custom-validation" method="POST"
                        action="{{ route('postConfirmation') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group col-md-12" style="padding: 22px">





                            <!-- File Upload Section -->
                            <div>
                                <div class="attach_more_field_row col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group col-md-5">
                                                    <label>Select File</label>
                                                    <input type="file" name="document[]" class="form-control" />
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Document Description</label>
                                                    <input type="text" name="description[]" class="form-control"
                                                        placeholder="File Description" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div align="right" style="margin-right: 70px;">
                                    <button type="button" id="add_more_document_field" class="btn btn-default btn-sm">
                                        <i class="fa fa-plus"></i> More Field
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <br /><br />
                                    <div align="center">
                                        <input type="hidden" name="biddingID"
                                            value="{{ isset($recordDetails) ? $recordDetails->biddingID : '' }}" />

                                        @if (isset($editRecord))
                                            <a href="{{ route('cancelEditContractor') }}" class="btn btn-default">Cancel
                                                Edit</a>

                                            <button type="submit" class="btn btn-primary">Update Now</button>
                                        @else
                                            <a href="{{ route('contractList') }}" class="btn btn-default">Back to
                                                list</a>

                                            <button type="submit" class="btn btn-primary">Upload Now</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- FILE LIST SECTION -->
                    <div class="row" style="background:#f7f7f7; border:1px solid #ddd; margin-top:20px; padding:10px;">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered table-striped">
                                <tr>
                                    <th>SN</th>
                                    <th>File</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>

                                @if (isset($allFile))
                                    @foreach ($allFile as $keyFile => $value)
                                        <tr>
                                            <td>{{ $keyFile + 1 }}</td>
                                            <td>
                                                <a target="_blank"
                                                    href="{{ asset('PaymentRequestDocument/' . $value->file_name) }}">
                                                    <i class="fa fa-download"></i> View File
                                                </a>
                                            </td>
                                            <td>{{ ucfirst($value->file_description) }}</td>
                                            <td>
                                                <a href="javascript:;" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target=".deleteFile{{ $keyFile }}">
                                                    Remove
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- MODAL REMOVE -->
                                        <div class="modal fade deleteFile{{ $keyFile }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Confirm!</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>
                                                            <b>Remove:</b> {{ ucfirst($value->file_description) }}<br>
                                                            <span class="text-danger">
                                                                This action cannot be undone!
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>

                                                        <a href="{{ route('deleteProjectFile', ['id' => $value->payment_requestID]) }}"
                                                            class="btn btn-warning">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>





@endsection

@section('styles')
@endsection

@section('scripts')
    <script>
        //add more field or remove field
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('#add_more_document_field'); //Add button selector
            var wrapper = $('.attach_more_field_row'); //Input field wrapper
            var fieldHTML =
                '<span><div id="remove_row" class="card-not"> <a href="#" class="remove_document_field_btn pull-right align-right">Remove</a>' +
                '<div class="card-body-not">' +
                '<div class="row">' +
                '<div class="form-group col-md-5">' +
                '<label>Select File <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input type="file" name="document[]" required data-parsley-type="file"  class="form-control"/>' +
                '</div>' +
                '</div>' +
                '<div class="form-group col-md-6">' +
                '<label>Document Description <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="description[]" required type="text" class="form-control" placeholder="File Description" />' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-md-1  mt-4">' +
                '<button type="button" id="remove_document_field" class="btn-sm btn btn-circle btn-warning align-center" style="margin-top:3px;"><i class="fa fa-minus"></i></button>' +
                '</div>-->' +
                '</div>' +
                '</div>' +
                '</div></span>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper).append(fieldHTML);
                } else {
                    alert('You cannot add more than 10 fields!');
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_document_field_btn', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        //end more field
    </script>

    <script>
        //add more field or remove field
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('#add_more_bank_field'); //Add button selector
            var wrapper2 = $('.attach_more_bank_field_row'); //Input field wrapper
            var fieldHTML =
                '<span><div class="card-not"><a href="#" class="remove_bank_field_btn pull-right align-right">Remove</a>' +
                '<div class="card-body-not">' +
                '<div class="row">' +
                '<input name="bankRecordID[]" type="text"  style="display:none;" />' +
                '<div class="form-group col-sm-3">' +
                '<label>Bank Name <span class="text-danger">*</span></label>' +
                '<div>' +
                '<select  name="bankName[]" required class="form-control">' +
                '<option value="">Select</option>' +
                '@if (isset($bankList) and $bankList)' +
                '@foreach ($bankList as $item)' +
                '<option value="{{ $item->bankID }}" {{ $item->bankID == old('bankName') ? 'selected' : '' }}>{{ $item->bank }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-sm-4">' +
                '<label>Account Name <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="accountName[]" type="text" required class="form-control" placeholder="Account Name" />' +
                '</div>' +
                '</div>-->' +
                '<div class="form-group col-sm-3">' +
                '<label>Account Number <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="accountNumber[]" required maxlength="10" size="10" type="number" class="form-control" placeholder="Account No." />' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-sm-1  mt-4">' +
                '<button type="button" class="remove_bank_field_btn33 btn-sm btn btn-circle btn-warning align-center" style="margin-top:3px;"><i class="fa fa-minus"></i></button>' +
                '</div>-->' +
                '</div>' +
                '</div>' +
                '</div></span>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper2).append(fieldHTML);
                } else {
                    alert('You cannot add more than 10 fields!');
                }
            });

            //Once remove button is clicked
            $(wrapper2).on('click', '.remove_bank_field_btn', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        //end more field
    </script>

@endsection
