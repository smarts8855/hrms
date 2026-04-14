@extends('layouts_procurement.app')
@section('pageTitle', 'Contractor Registration')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <!-- Panel for Contractor Details -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contractor Details</h3>
                </div>
                <div class="panel-body">

                    <div align="right">All fields with <span class="text-danger">*</span> are required.</div>
                    <hr />

                    @include('procurement.ShareView.operationCallBackAlert')

                    <form id="contractor_form" class="custom-validation" method="POST" action="{{ route('upload-request') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <h5>
                                <div><b>Name of Contractor:</b>
                                    {{ isset($recordDetails) && $recordDetails ? $recordDetails->company_name : '' }}</div>
                                <br />
                                <div><b>Name of Contract:</b>
                                    {{ isset($recordDetails) && $recordDetails ? $recordDetails->contract_name : '' }}</div>
                            </h5>
                        </div>

                        <h4 class="text-center">
                            Job Completion Documents
                            <small class="text-warning">PNG,JPG,JPE,JPEG,PDF | Max: 10MB</small>
                        </h4>
                        <hr />

                        <div align="center">
                            <div class="attach_more_field_row">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-sm-5">
                                                <label>Select File</label>
                                                <input type="file" name="document[]" class="form-control"
                                                    data-parsley-type="file" />
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Document Description</label>
                                                <input name="description[]" type="text" class="form-control"
                                                    placeholder="File Description" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div align="left" class="margin-top-10">
                                <button type="button" id="add_more_document_field" class="btn btn-info btn-sm btn-circle">
                                    <i class="fa fa-plus"></i> More Field
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12 text-center">
                                <br /><br />
                                <input type="hidden" name="biddingID"
                                    value="{{ isset($recordDetails) && $recordDetails ? $recordDetails->biddingID : '' }}" />
                                @if (isset($editRecord) && $editRecord)
                                    <a href="{{ route('cancelEditContractor') }}" class="btn btn-default">Cancel Edit</a>
                                    <button type="submit" class="btn btn-primary">Update Now</button>
                                @else
                                    <a href="{{ Route::has('confirm-completion') ? Route('confirm-completion') : '#' }}"
                                        class="btn btn-default">Back to list</a>
                                    <button type="submit" class="btn btn-primary">Submit Now</button>
                                @endif
                            </div>
                        </div>

                    </form>

                </div>
            </div>
            <!-- End Panel -->

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
                '<div class="form-group col-sm-5">' +
                '<label>Select File <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input type="file" name="document[]" required data-parsley-type="file"  class="form-control"/>' +
                '</div>' +
                '</div>' +
                '<div class="form-group col-sm-6">' +
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
