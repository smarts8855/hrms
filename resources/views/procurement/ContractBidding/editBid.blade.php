@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Bid')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-pencil"></i> Update Bidding Information
                            </h4>
                        </div>

                        <form method="post" action="{{ url('/bidding-update') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <!-- ADD THIS HIDDEN FIELD - IT'S MISSING! -->
                            <input type="hidden" name="bidID" value="{{ $biddingID }}">
                            
                            <!-- Card Body -->
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Contract dropdown - keep disabled but show the name -->
                                        <select class="form-control" name="contract" disabled>
                                            <option value="">Select</option>
                                            @foreach ($contract as $list)
                                                <option value="{{ $list->contract_detailsID }}"
                                                    @if ($edit->contractID == $list->contract_detailsID) selected @endif>
                                                    {{ $list->contract_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="contract" value="{{ $edit->contractID }}">
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Contractor dropdown - show all contractors but keep disabled -->
                                        <select class="form-control" name="contractor" id="contractorSelect" disabled>
                                            <option value="">Select Contractor...</option>
                                            @foreach ($allContractors as $list)
                                                <option value="{{ $list->id }}" 
                                                    data-source="{{ $list->source }}"
                                                    @if ($edit->contractorID == $list->id) selected @endif>
                                                    {{ $list->name }}
                                                    @if($list->source == 'Registration')
                                                        (Registered)
                                                    @else
                                                        (Main)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="contractor" value="{{ $edit->contractorID }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Remark -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea class="form-control" name="contractorRemark">{{ $edit->contractor_remark }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Bid Amount -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Bid Amount</label>
                                            <input type="text" name="biddingAmount" class="form-control"
                                                value="{{ number_format($edit->bidding_amount, 2) }}">
                                        </div>
                                    </div>

                                    <!-- Date Submitted -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date Submitted</label>
                                            <input type="date" name="date" class="form-control"
                                                max="{{ date('Y-m-d') }}" value="{{ $edit->date_submitted }}">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">Select</option>
                                                <option value="1" @if ($edit->bidStatus == 1) selected @endif>
                                                    Active
                                                </option>
                                                <option value="2" @if ($edit->bidStatus == 2) selected @endif>
                                                    Disabled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                </div>

                            </div> <!-- End panel-body -->
                        </form>
                    </div>



                    <form method="post" action="{{ url('/bidding-update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-file"></i> Financial Documents
                                </h4>
                            </div>

                            <!-- CARD BODY -->
                            <div class="panel-body">
                                <table class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Document Description</th>
                                            <th>Date Uploaded</th>
                                            <th width="50">Preview Document</th>
                                            <th width="10">Delete</th>
                                        </tr>
                                    </thead>

                                    @php $n = 1; @endphp
                                    <tbody>
                                        @foreach ($viewDocumentsFinancial as $key => $list)
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td>{{ $list->bid_doc_description }}</td>
                                                <td>{{ $list->updated_at ? date('jS M, Y', strtotime($list->updated_at)) : 'N/A' }}
                                                </td>

                                                <td>
                                                    @if ($list->bidDocument == null)
                                                        N/A
                                                    @else
                                                        <a href="{{ asset($list->bidDocument) }}" target="_blank"
                                                            class="btn btn-success btn-xs">
                                                            <i class="fa fa-download"></i> Preview
                                                        </a>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($list->bidDocument == null)
                                                        <a href="#" class="btn btn-success btn-xs setUpload"
                                                            title="Upload" data-toggle="modal"
                                                            data-id="{{ $list->docId }}"
                                                            data-target="#uploadCategory{{ $key }}">
                                                            <i class="fa fa-upload"></i> Upload
                                                        </a>
                                                    @else
                                                        <a href="#" class="btn btn-success btn-xs setEditId"
                                                            title="Edit"
                                                            data-id="{{ $list->contractor_bidding_documentID }}"
                                                            data-toggle="modal"
                                                            data-target="#editCategory{{ $key }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="#" class="btn btn-danger btn-xs setDeleteId"
                                                            title="Remove"
                                                            data-id="{{ $list->contractor_bidding_documentID }}"
                                                            data-toggle="modal"
                                                            data-target="#deleteCategory{{ $key }}">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal Upload -->
                                            <div class="modal fade" id="uploadCategory{{ $key }}" tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Upload
                                                                <br>{{ $list->bid_doc_description }}
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Document <span class="text-danger">*</span></label>
                                                                <input type="hidden" name="biddingID"
                                                                    value="{{ $edit->contract_biddingID }}">
                                                                <input type="hidden" name="contractorID"
                                                                    value="{{ $edit->contractorID }}">
                                                                <input type="hidden" name="contractID"
                                                                    value="{{ $edit->contractID }}">
                                                                <input type="file" name="fileUpload[]"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editCategory{{ $key }}" tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update
                                                                <br>{{ $list->bid_doc_description }}
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Document <span class="text-danger">*</span></label>
                                                                <input type="file" name="file[]"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="deleteCategory{{ $key }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Document</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <label>
                                                                Are you sure you want to delete document:
                                                                <br><strong>{{ $list->bid_doc_description }}</strong>?
                                                            </label>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- END PANEL BODY -->

                        </div>


                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-file"></i> Technical Documents
                                </h4>
                            </div>

                            <!-- CARD BODY -->
                            <div class="panel-body">
                                <table class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Document Description</th>
                                            <th>Date Uploaded</th>
                                            <th width="50">Preview Document</th>
                                            <th width="10">Delete</th>
                                        </tr>
                                    </thead>

                                    @php $n = 1; @endphp
                                    <tbody>
                                        @foreach ($viewDocumentsTechnical as $key => $list)
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td style="word-wrap: break-word; white-space: normal;">
                                                    {{ $list->bid_doc_description }}
                                                </td>
                                                <td>{{ $list->updated_at ? date('jS M, Y', strtotime($list->updated_at)) : 'N/A' }}
                                                </td>

                                                <td>
                                                    @if ($list->bidDocument == null)
                                                        N/A
                                                    @else
                                                        <a href="{{ asset($list->bidDocument) }}" target="_blank"
                                                            class="btn btn-success btn-xs">
                                                            <i class="fa fa-download"></i> Preview
                                                        </a>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($list->bidDocument == null)
                                                        <a href="#" class="btn btn-success btn-xs setUpload"
                                                            title="Upload" data-toggle="modal"
                                                            data-id="{{ $list->docId }}"
                                                            data-target="#uploadCategory{{ $key }}">
                                                            <i class="fa fa-upload"></i> Upload
                                                        </a>
                                                    @else
                                                        <a href="#" class="btn btn-success btn-xs setEditId"
                                                            title="Edit"
                                                            data-id="{{ $list->contractor_bidding_documentID }}"
                                                            data-toggle="modal"
                                                            data-target="#editCategory{{ $key }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="#" class="btn btn-danger btn-xs setDeleteId"
                                                            title="Remove"
                                                            data-id="{{ $list->contractor_bidding_documentID }}"
                                                            data-toggle="modal"
                                                            data-target="#deleteCategory{{ $key }}">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal Upload -->
                                            <div class="modal fade" id="uploadCategory{{ $key }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Upload
                                                                <br>{{ $list->bid_doc_description }}
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Document <span class="text-danger">*</span></label>
                                                                <input type="hidden" name="biddingID"
                                                                    value="{{ $edit->contract_biddingID }}">
                                                                <input type="hidden" name="contractorID"
                                                                    value="{{ $edit->contractorID }}">
                                                                <input type="hidden" name="contractID"
                                                                    value="{{ $edit->contractID }}">
                                                                <input type="file" name="fileUpload[]"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editCategory{{ $key }}" tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update
                                                                <br>{{ $list->bid_doc_description }}
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Document <span class="text-danger">*</span></label>
                                                                <input type="file" name="file[]"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="deleteCategory{{ $key }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-xs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Document</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">×</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <label>
                                                                Are you sure you want to delete document:
                                                                <br><strong>{{ $list->bid_doc_description }}</strong>?
                                                            </label>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- END PANEL BODY -->

                        </div>

                        <!-- The technical documents table stays exactly the same as above -->
                        <!-- (I did not rewrite here due to length, but the wrapper stays inside the panel) -->

                        <!-- HIDDEN INPUTS -->
                        <input type="hidden" name="contractorBidDocID" id="contractorBidDocID">
                        <input type="hidden" name="modalUpdate" id="modalUpdate">
                        <input type="hidden" name="docDescId" id="docDescId">
                        <input type="hidden" name="modalUpload" id="modalUpload">
                        <input type="hidden" name="docId" id="docId">
                        <input type="hidden" name="modalDelete" id="modalDelete">

                    </form>


                    <div class="panel-footer text-right">
                        <div class="col-md-12" style="margin-top:30px">

                            <a href="{{ url('/add-bidding') }}" class="btn btn-success btn-sm"
                                style="margin-right:10px;">
                                Add New Bid
                            </a>

                            <a href="{{ url('/view-bidding') }}" class="btn btn-success btn-sm">
                                View All Bids
                            </a>

                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>




    @endsection

    @section('styles')
        <style>
            .remove,
            .delete {
                margin-top: 30px;
                padding-top: 5px !important;
                padding-bottom: 0px !important;

                margin-bottom: 0px;
            }

            .fa-times {
                font-size: 30px;
                cursor: pointer;
            }
        </style>
        <style>
            .card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 20px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .card-body {
                padding: 20px;
            }

            .card-title {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 15px;
            }

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
        @if (session('err'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('err') }}',
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




        <script>
            $(document).ready(function() {
                $(".setEditId").on("click", function() {
                    var contractorBiddingDocumentID = $(this).data('id');
                    $("#contractorBidDocID").val(contractorBiddingDocumentID);
                    $("#modalUpdate").val("yes");
                })

                $(".clearModalAndDoc").on("click", function() {
                    $("#contractorBidDocID").val("");
                    $("#modalUpdate").val("");
                })

                $(".setUpload").on("click", function() {
                    var id = $(this).data('id');
                    $("#docDescId").val(id);
                    $("#modalUpload").val("yes");
                })

                $(".clearModalUpload").on("click", function() {
                    $("#docDescId").val("");
                    $("#modalUpload").val("");
                })

                $(".setDeleteId").on("click", function() {
                    var id = $(this).data('id');
                    $("#docId").val(id);
                    $("#modalDelete").val("yes");
                })

                $(".clearModalDelete").on("click", function() {
                    $("#docId").val("");
                    $("#modalDelete").val("");
                })

            });
        </script>

        <script>
            $(document).ready(function() {
                $("#biddingAmount").on('keyup', function(evt) {
                    //if (evt.which != 110 ){//not a fullstop
                    //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                    $(this).val(function(index, value) {
                        return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                            /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                    //$(this).val(n.toLocaleString());
                    //}
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.bn', function() {
                    //alert(0);
                    $('.wraps').last().remove();
                    var id = this.id;
                    var deleteindex = id[1];

                    // Remove <div> with id
                    $("#" + deleteindex).remove();

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#add').click(function() {
                    var total_element = $(".wraps").length;
                    var lastid = $(".wraps:last").attr("id");
                    //var split_id = lastid.split('_');
                    var n = Number(lastid) + 1;
                    //alert(nextindex);
                    $('#inputWrap').append(
                        `<div class="wraps" id="'+n+'">
                            <div class="row">
                            <div class="col-md-12">
                            <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group dynFile">
                                <label for="">Document</label>
                                <input type="file" name="document[]" class="form-control" id=''>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group dynInput">
                                <label for="">Document Description</label>
                                <input type="text" name="description[]" class="form-control" id='' >
                            </div>
                            </div>

                            </div>
                        </div>`
                    );
                });
                //end click function

                $('.delete').last().click(function() {
                    $('.wraps').last().remove();
                });

            });
        </script>

        <script>
            function confirmDelete() {
                $val = confirm('Do you actually want to delete');
                if ($val) {
                    return true
                } else {
                    return false;
                }
            }
        </script>



    @endsection
