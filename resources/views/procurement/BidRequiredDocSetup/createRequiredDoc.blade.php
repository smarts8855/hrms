@extends('layouts_procurement.app')
@section('pageTitle', 'Bid Documents Setup')
@section('content')


    <!-- CARD 1: BID DOCUMENT SETUP -->
    <div class="panel panel-success">
        <div class="panel-heading clearfix">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="panel-title"><b>Bid Document Setup</b></h3>
                </div>
                <div class="col-md-6 text-right">
                    <h4 style="font-size: 14px;">
                        <i class="fa fa-cog"></i> Document Configuration
                    </h4>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div align="right" style="margin-bottom: 15px;">
                All fields with <span class="text-danger">*</span> are required.
            </div>

            <form id="contractor_form" class="custom-validation" method="POST"
                action="{{ route('saveBidRequiredDocSetup') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Document Description <span class="text-danger">*</span></label>
                            <input type="text" name="docDesc" value="{{ old('docDesc') }}" required class="form-control"
                                placeholder="Enter document description">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Document Type <span class="text-danger">*</span></label>
                            <select name="docType" class="form-control" required>
                                <option value="">Select Document Type</option>
                                <option value="Financial" {{ old('docType') == 'Financial' ? 'selected' : '' }}>Financial
                                </option>
                                <option value="Technical" {{ old('docType') == 'Technical' ? 'selected' : '' }}>Technical
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save Document
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- CARD 2: REQUIRED DOCUMENT LIST -->
    <div class="panel panel-success">
        <div class="panel-heading clearfix">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="panel-title"><b>Bid Required Documents</b></h3>
                </div>
                <div class="col-md-6 text-right">
                    <h4 style="font-size: 14px;">
                        <i class="fa fa-list"></i> Total Documents: {{ $requiredDocs->count() }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="text-center">
                <hr>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>DOCUMENT TYPE</th>
                            <th>DOCUMENT DESCRIPTION</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($requiredDocs as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($item->doc_type == 'Financial')
                                        <span class="label label-success">{{ $item->doc_type }}</span>
                                    @else
                                        <span class="label label-primary">{{ $item->doc_type }}</span>
                                    @endif
                                </td>

                                <td><b>{{ $item->bid_doc_description }}</b></td>

                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target=".editCategory{{ $key }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target=".deleteCategory{{ $key }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- MODALS REMAIN SAME -->
                            <!--  Modal Edit -->
                            <div class="modal fade editCategory{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xs">
                                    <div class="modal-content">
                                        <form action="{{ route('updateBidRequiredDocSetup', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Document
                                                    Setup!</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group col-md-12">
                                                    <label>Document Description <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="text" name="docDesc"
                                                            value="{{ $item->bid_doc_description }}" required autofocus
                                                            class="form-control" placeholder="Bid Document" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Document Type <span class="text-danger">*</span></label>
                                                    <div>
                                                        <select name="docType" class="form-control" required>
                                                            <option value="">Select Document Type</option>
                                                            @php
                                                                $uniqueDocTypes = [];
                                                                foreach ($requiredDocs as $doc) {
                                                                    if (!in_array($doc->doc_type, $uniqueDocTypes)) {
                                                                        $uniqueDocTypes[] = $doc->doc_type;
                                                                    }
                                                                }
                                                            @endphp
                                                            @foreach ($uniqueDocTypes as $type)
                                                                @if ($type == 'Technical' || $type == 'Financial')
                                                                    <option value="{{ $type }}"
                                                                        {{ $type == $item->doc_type ? 'selected' : '' }}>
                                                                        {{ $type }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect"
                                                    data-dismiss="modal">Close</button>
                                                <button class="btn btn-success waves-effect waves-light">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            <!--  Modal deletion -->
                            <div class="modal fade deleteCategory{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Confirm!</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-primary">Delete: {{ $item->bid_doc_description }}</p>
                                            <p class="text-danger">Are you sure you want to delete this record?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect"
                                                data-dismiss="modal">Close</button>
                                            <form action="{{ url("/remove-bidding-required-document-setup/$item->id") }}"
                                                method="POST">
                                                @method('DELETE')
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            {{-- <a href="{{ route('deleteContractorRecord', ['id'=> base64_encode($item->contractor_registrationID) ]) }}" class="btn btn-warning waves-effect waves-light">Delete</a> --}}
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($requiredDocs->count() == 0)
                <div class="text-center" style="padding: 30px;">
                    <i class="fa fa-file-text-o fa-3x text-muted"></i>
                    <h4>No Documents Configured</h4>
                    <p>No bid documents have been set up yet. Use the form above to add documents.</p>
                </div>
            @endif
        </div>
    </div>





@endsection

@section('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #007bff;
        }

        .badge {
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 15px;
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
    <script>
        // Additional JavaScript can be added here if needed
        $(document).ready(function() {
            // Any initialization code can go here
        });
    </script>
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
