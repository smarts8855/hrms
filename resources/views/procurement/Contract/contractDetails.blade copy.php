@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Contract Details') }}
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="box-shadow:0 2px 8px rgba(0,0,0,0.1); border-radius:6px;">
            <div class="panel-heading" style="background-color:#f5f5f5; border-bottom:1px solid #ddd;">
                <h3 class="panel-title">Create New Contract</h3>
            </div>
            <div class="panel-body">

                <div align="right" style="margin-bottom:10px;">
                    All fields with <span class="text-danger">*</span> are required.
                </div>

                <hr />

                <form id="contractForm" class="custom-validation formFormatAmount" method="POST"
                    action="{{ route('postDetails') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Lot Number</label>
                            <input type="text" name="lotNumber"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->lot_number : old('lotNumber') }}"
                                class="form-control" placeholder="Lot Number" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Sublot Number</label>
                            <input type="text" name="sublotNumber"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->sublot_number : old('sublotNumber') }}"
                                class="form-control" placeholder="Sublot Number" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Reference Number </label>
                            <input type="text" name="referenceNumber"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->reference_number : old('referenceNumber') }}"
                                class="form-control" placeholder="Reference Number" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Contract Title <span class="text-danger">*</span></label>
                            <input type="text" name="contractTitle"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->contract_name : old('contractTitle') }}"
                                required class="form-control" placeholder="Contract Title" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Contract Type <span class="text-danger">*</span></label>
                            <select name="procurementType" class="form-control" required>
                                <option value="">Select</option>
                                @if (isset($getProcurementType) && $getProcurementType)
                                    @foreach ($getProcurementType as $item)
                                        <option value="{{ $item->procurement_typeID }}"
                                            {{ (isset($editRecord) && $editRecord->procurement_typeID == $item->procurement_typeID) || old('procurementType') == $item->procurement_typeID ? 'selected' : '' }}>
                                            {{ $item->type }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Contract Category <span class="text-danger">*</span></label>
                            <select name="contractCategory" class="form-control" required>
                                <option value="">Select</option>
                                @if (isset($getContractCategory) && $getContractCategory)
                                    @foreach ($getContractCategory as $item)
                                        <option value="{{ $item->contractCategoryID }}"
                                            {{ (isset($editRecord) && $editRecord->contractCategoryID == $item->contractCategoryID) || old('contractCategory') == $item->contractCategoryID ? 'selected' : '' }}>
                                            {{ $item->category_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label>Amount</label>
                            <input type="text" id="formatAmountOnKeyPress" name="proposedAmount"
                                value="{{ isset($editRecord) && $editRecord ? number_format($editRecord->proposed_budget, 2) : old('proposedAmount') }}"
                                class="form-control" placeholder="Amount" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Bid Opening Date</label>
                            <input type="date" name="biddingDate"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->bidding_date : old('biddingDate') }}"
                                class="form-control" placeholder="Select Date" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Close Bid Date & Time</label>
                            <input type="text" id="closeBiddingDate" name="closeBiddingDate" class="form-control"
                                placeholder="Select Date & Time"
                                value="{{ old(
                                    'closeBiddingDate',
                                    isset($editRecord) && $editRecord && $editRecord->close_bidding_date
                                        ? \Carbon\Carbon::parse($editRecord->close_bidding_date)->format('Y-m-d h:i A')
                                        : '',
                                ) }}"
                                required>
                        </div>

                        <!-- LOCATION FIELD -->
                        <div class="form-group col-md-6">
                            <label>Location <span class="text-muted">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" name="location" id="location" class="form-control"
                                    placeholder="Enter contract location (e.g., Abuja, Lagos, etc.)"
                                    value="{{ isset($editRecord) && $editRecord ? $editRecord->location : old('location') }}">
                            </div>
                            <small class="text-muted">
                                Specify the location/venue for this contract
                            </small>
                        </div>

                        <!-- MEMOIR FILE UPLOAD FIELD -->
                        <div class="form-group col-md-6">
                            <label>Memoir File (Optional)</label>
                            <div class="memoir-file-container">
                                <div class="input-group memoir-file-row">
                                    <input type="file" name="memoir_file[]" class="form-control memoir-file-input" 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" multiple>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success add-more-memoir">
                                            <i class="glyphicon glyphicon-plus"></i> Add More
                                        </button>
                                    </span>
                                </div>
                                <small class="text-muted" style="display: block; margin-top: 5px;">
                                    <i class="fa fa-info-circle"></i> 
                                    You can upload multiple files (PDF, JPG, JPEG, PNG). Max 100KB per file.
                                </small>
                            </div>
                            
                            <!-- Display existing files in edit mode -->
                            @if(isset($editRecord) && $editRecord && isset($editRecord->memoir_documents) && $editRecord->memoir_documents->count() > 0)
                                <div class="existing-memoir-files" style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                    <label style="font-weight: bold; margin-bottom: 10px; display: block;">
                                        <i class="glyphicon glyphicon-paperclip"></i> Existing Files:
                                    </label>
                                    @foreach($editRecord->memoir_documents as $index => $doc)
                                        <div class="checkbox" style="margin: 8px 0; padding-left: 20px;">
                                            <label style="font-weight: normal;">
                                                <input type="checkbox" name="keep_memoir_files[]" value="{{ $doc->file_path }}" checked>
                                                <a href="{{ $doc->file_path }}" target="_blank" class="text-primary" style="margin-left: 5px;">
                                                    <i class="glyphicon glyphicon-file"></i> 
                                                    {{ $doc->file_name }}
                                                </a>
                                                <small class="text-muted">(uncheck to remove)</small>
                                            </label>
                                        </div>
                                    @endforeach
                                    <input type="hidden" name="remove_memoir_files" value="1">
                                    <small class="text-warning">
                                        <i class="glyphicon glyphicon-alert"></i> 
                                        Uncheck any file you want to remove when updating.
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        @php
                            // Selected documents from old input or editing
                            $selectedDocs = old('contractRequireDocument', []);

                            // For editing existing record
                            if (isset($editRecord) && $editRecord && !empty($editRecord->selected_document_ids)) {
                                $selectedDocs = explode(',', $editRecord->selected_document_ids);
                                $selectedDocs = array_map('strval', $selectedDocs);
                            }
                        @endphp
                        <div class="form-group col-md-12">
                            <label for="contractRequireDocument">
                                Select Required Documents for This Contract <span class="text-danger">*</span>
                            </label>

                            <select name="contractRequireDocument[]" id="contractRequireDocument" class="form-control"
                                multiple>
                                @foreach ($requiredDocs as $doc)
                                    <option value="{{ $doc->id }}"
                                        {{ in_array((string) $doc->id, $selectedDocs) ? 'selected' : '' }}>
                                        [{{ $doc->doc_type }}] {{ $doc->bid_doc_description }}
                                    </option>
                                @endforeach

                                {{-- Add old typed tags that are not in DB --}}
                                @foreach ($selectedDocs as $val)
                                    @if (!in_array($val, $requiredDocs->pluck('id')->map(fn($id) => (string) $id)->toArray()))
                                        <option value="{{ $val }}" selected>{{ $val }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <small class="text-danger font-weight-bold mt-2">
                                You can select multiple documents from the list or type to add new ones.
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Contract Description <span class="text-danger">*</span></label>
                            <textarea required name="contractDescription" class="form-control" rows="5"
                                placeholder="Enter contract description">{{ isset($editRecord) && $editRecord ? $editRecord->contract_description : old('contractDescription') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 text-right">
                            <input type="hidden" name="recordID"
                                value="{{ isset($editRecord) && $editRecord ? $editRecord->contract_detailsID : '' }}" />

                            @if (isset($editRecord) && $editRecord)
                                <a href="{{ route('cancelEditContractDetails') }}" class="btn btn-default">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Now
                                </button>
                            @else
                                <button type="reset" class="btn btn-default">
                                    <i class="fa fa-undo"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left" style="padding-top:7px;">Newly Created Contract</h4>
                <a href="{{ route('contractReport') }}" target="_blank" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-eye"></i> View All
                </a>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div align="center" class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>LOT No.</th>
                                        <th>SUBLOT No.</th>
                                        <th>REFERENCE No.</th>
                                        <th>Contract Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th class="text-right">Amount</th>
                                        <th>Status</th>
                                        <th>Close Bidding Date</th>
                                        <th>Close Bidding Time</th>
                                        <th>Memoir Files</th>
                                        <th colspan="" class="text-">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($getContractDetails) && is_iterable($getContractDetails))
                                        @foreach ($getContractDetails as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <span class="label label-success">
                                                        {{ $item->lot_number }}
                                                    </span>
                                                </td>

                                                <td>{{ $item->sublot_number }}</td>
                                                <td>{{ $item->reference_number ?? 'N/A' }}</td>
                                                <td>{{ $item->contract_name }}</td>
                                                <td>
                                                    {{ $item->contract_description ? substr($item->contract_description, 0, 100) : ' - ' }}
                                                    @if (strlen($item->contract_description) > 100)
                                                        ... <a href="javascript:;" class="text-info"
                                                            data-toggle="modal"
                                                            data-target=".viewMoreDescription{{ $key }}">View
                                                            more</a>
                                                    @endif
                                                </td>
                                                <td>{{ $item->category_name }}</td>
                                                <td>
                                                    @if(!empty($item->location))
                                                        <span class="label label-info" title="Location">
                                                            <i class="fa fa-map-marker"></i> {{ $item->location }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    &#8358;{{ number_format($item->proposed_budget, 2) }}
                                                </td>
                                                <td>
                                                    <span class="label label-success text-uppercase">
                                                        {{ $item->status_name }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($item->close_bidding_date)
                                                        {{ \Carbon\Carbon::parse($item->close_bidding_date)->format('d M Y') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->close_bidding_date)
                                                        {{ \Carbon\Carbon::parse($item->close_bidding_date)->format('h:i A') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    @php
                                                        $memoirFiles = $item->memoir_documents ?? collect();
                                                        $fileCount = $memoirFiles->count();
                                                    @endphp
                                                    
                                                    @if($fileCount > 0)
                                                        <button type="button" class="btn btn-xs btn-info view-memoir-files" 
                                                                data-contract-id="{{ $item->contract_detailsID }}"
                                                                data-contract="{{ $item->contract_name }}">
                                                            <i class="glyphicon glyphicon-paperclip"></i> 
                                                            Files ({{ $fileCount }})
                                                        </button>
                                                    @else
                                                        <span class="text-muted">No files</span>
                                                    @endif
                                                </td>

                                                <td class="text-">
                                                    @if ($item->doc_count > 0)
                                                        <button class="btn btn-info btn-xs view-docs-btn"
                                                            style="margin-bottom: 5px"
                                                            data-contract-id="{{ $item->contract_detailsID }}"
                                                            data-contract-title="{{ $item->contract_name }}">
                                                            <i class="fa fa-file-text-o"></i> View Documents
                                                        </button>
                                                    @endif

                                                    @if ($item->status_name != 'Approved')
                                                        <a href="{{ route('editContractDetails', ['id' => base64_encode($item->contract_detailsID)]) }}"
                                                            class="btn btn-xs btn-warning">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="javascript:;" title="Delete Record"
                                                            class="btn btn-xs btn-danger" data-toggle="modal"
                                                            data-target=".deleteCategory{{ $key }}">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- View More Modal -->
                                            <div class="modal fade viewMoreDescription{{ $key }}"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel">More Details
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong>{{ $item->contract_name }}</strong>
                                                            <hr>
                                                            <p>{{ $item->contract_description }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade deleteCategory{{ $key }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" id="deleteModalLabel">Confirm
                                                                Delete</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Contract:</strong> {{ $item->contract_name }}
                                                            </p>
                                                            <p class="text-danger">Are you sure you want to delete this
                                                                record?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancel</button>
                                                            <a href="{{ route('deleteContractDetails', ['id' => base64_encode($item->contract_detailsID)]) }}"
                                                                class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="14" class="text-center text-danger">No contract found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($getContractDetails instanceof \Illuminate\Pagination\AbstractPaginator)
                            <div class="col-md-12 text-right">
                                <hr />
                                Showing
                                {{ ($getContractDetails->currentpage() - 1) * $getContractDetails->perpage() + 1 }}
                                to {{ $getContractDetails->currentpage() * $getContractDetails->perpage() }}
                                of {{ $getContractDetails->total() }} entries
                            </div>
                            <div class="col-md-12 text-right">
                                {{ $getContractDetails->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documents Modal -->
<div class="modal fade" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="documentsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="documentsModalLabel">Required Documents</h4>
            </div>
            <div class="modal-body">
                <h3><strong>Technical Documents</strong></h3>
                <ul id="technicalDocsList" class="list-group mb-3"></ul>
                <h3><strong>Financial Documents</strong></h3>
                <ul id="financialDocsList" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Memoir Files Modal with Add and Delete Functionality -->
<div class="modal fade" id="memoirFilesModal" tabindex="-1" role="dialog" aria-labelledby="memoirFilesModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="memoirFilesModalLabel">Memoir Files</h4>
            </div>
            <div class="modal-body">
                <!-- File upload form inside modal -->
                <form id="memoirUploadForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="contract_id" id="modal_contract_id" value="">
                    
                    <div class="memoir-modal-upload-container">
                        <div class="form-group">
                            <label>Add New Files:</label>
                            <div class="memoir-modal-file-row">
                                <div class="input-group">
                                    <input type="file" name="memoir_file[]" class="form-control modal-file-input" 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success add-more-modal-file">
                                            <i class="glyphicon glyphicon-plus"></i> Add More
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-file-list-container">
                            <button type="button" class="btn btn-primary btn-sm upload-modal-files" style="margin-bottom: 10px;">
                                <i class="glyphicon glyphicon-upload"></i> Upload Files
                            </button>
                            <div id="upload-progress" style="display:none; margin-bottom: 10px;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped active" 
                                         role="progressbar" style="width: 0%">
                                        <span class="sr-only">0% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <label>Existing Files:</label>
                    <div id="existingMemoirFilesList" class="list-group" style="max-height: 300px; overflow-y: auto;">
                        <!-- Existing files will be loaded here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
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
        
        .table-action-btn {
            margin-right: 5px;
        }
        
        @media (max-width: 480px) {
            .table-action-btn {
                display: block;
                margin-bottom: 5px;
            }
        }
        
        .memoir-file-row {
            margin-bottom: 10px;
        }
        
        .existing-memoir-files .checkbox:hover {
            background-color: #f0f0f0;
        }
        
        .list-group-item {
            padding: 12px 15px;
            border: 1px solid #ddd;
            margin-bottom: -1px;
            background-color: #fff;
            transition: all 0.3s ease;
        }
        
        .list-group-item:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .list-group-item:last-child {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        
        .list-group-item:hover {
            background-color: #f9f9f9;
        }
        
        .file-item {
            margin-bottom: 5px !important;
        }
        
        .delete-memoir-file {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .delete-memoir-file:hover {
            opacity: 1;
        }
        
        .memoir-modal-file-row {
            margin-bottom: 10px;
        }
        
        #upload-progress {
            margin-top: 10px;
        }
        
        .input-group-addon {
            background-color: #f5f5f5;
        }
    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />

    <style>
        .select2-container--bootstrap .select2-results__option[aria-selected="true"] {
            color: #c00;
            background-color: #fee;
            font-weight: bold;
        }

        .select2-container--bootstrap .select2-results__option[aria-selected="true"]::after {
            content: " (already selected)";
            font-style: italic;
            color: #900;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
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

    <script>
        $(document).ready(function() {
            // Number Format
            $("#formatAmountOnKeyPress").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });

            // Format amount class
            (function($, undefined) {
                "use strict";
                $(function() {
                    var $form = $(".formFormatAmount");
                    var $input = $form.find(".format-amount");
                    $input.on("keyup", function(event) {
                        var selection = window.getSelection().toString();
                        if (selection !== '') {
                            return;
                        }
                        if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                            return;
                        }
                        var $this = $(this);
                        var input = $this.val();
                        var input = input.replace(/[\D\s\._\-]+/g, "");
                        input = input ? parseInt(input, 10) : 0;
                        $this.val(function() {
                            return (input === 0) ? "" : input.toLocaleString("en-US");
                        });
                    });
                });
            })(jQuery);

            // Flatpickr for close bidding date
            flatpickr("#closeBiddingDate", {
                enableTime: true,
                dateFormat: "Y-m-d h:i K",
                time_24hr: false,
                clickOpens: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 1) {
                        let selectedDate = selectedDates[0];
                        let now = new Date();
                        selectedDate.setHours(now.getHours());
                        selectedDate.setMinutes(now.getMinutes());
                        selectedDate.setSeconds(0);
                        instance.setDate(selectedDate, false);
                        instance.close();
                    }
                }
            });

            // Select2 for required documents
            $('#contractRequireDocument').select2({
                theme: 'bootstrap',
                placeholder: 'Start typing or select documents...',
                tags: true,
                width: '100%',
                tokenSeparators: [',']
            });

            // Prevent typing duplicate entries
            $('#contractRequireDocument').on('select2:select', function(e) {
                var selectedVal = e.params.data.id;
                var currentVals = $(this).val() || [];
                var occurrences = currentVals.filter(v => String(v) === String(selectedVal)).length;

                if (occurrences > 1) {
                    var newVals = currentVals.filter(v => String(v) !== String(selectedVal));
                    newVals.push(selectedVal);
                    $(this).val(newVals).trigger('change');

                    Swal.fire({
                        icon: 'info',
                        title: 'Already selected!',
                        text: 'This document is already selected. Remove it first if you want to add it again.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            });

            // Form submit validation
            $('#contractForm').on('submit', function(e) {
                var selectedDocs = $('#contractRequireDocument').val();
                if (!selectedDocs) selectedDocs = [];

                if (selectedDocs.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required!',
                        text: 'Please select at least one required document before submitting.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    $('#contractRequireDocument').select2('open');
                }
            });

            // View documents button
            $('.view-docs-btn').on('click', function() {
                var contractId = $(this).data('contract-id');
                var contractTitle = $(this).data('contract-title');

                $('#documentsModalLabel').html('Required Documents - <strong>' + contractTitle + '</strong>');
                $('#technicalDocsList, #financialDocsList').empty();

                $.ajax({
                    url: '/contracts/' + contractId + '/documents',
                    type: 'GET',
                    success: function(data) {
                        if (data.length === 0) {
                            $('#technicalDocsList, #financialDocsList').append(
                                '<li class="list-group-item text-muted">No documents submitted.</li>'
                            );
                        } else {
                            data.forEach(function(doc) {
                                var listItem = '<li class="list-group-item">' + doc.bid_doc_description + '</li>';
                                if (doc.doc_type === 'Technical') {
                                    $('#technicalDocsList').append(listItem);
                                } else if (doc.doc_type === 'Financial') {
                                    $('#financialDocsList').append(listItem);
                                }
                            });
                        }
                        $('#documentsModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to load documents. Please try again.');
                    }
                });
            });

            // MEMOIR FILE HANDLING FOR MAIN FORM
            // Add more memoir file inputs
            $('.add-more-memoir').click(function() {
                var newRow = `
                    <div class="input-group memoir-file-row" style="margin-top: 10px;">
                        <input type="file" name="memoir_file[]" class="form-control memoir-file-input" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger remove-memoir-file">
                                <i class="glyphicon glyphicon-remove"></i> Remove
                            </button>
                        </span>
                    </div>
                `;
                $('.memoir-file-container').append(newRow);
            });
            
            // Remove memoir file input
            $(document).on('click', '.remove-memoir-file', function() {
                $(this).closest('.memoir-file-row').remove();
            });
            
            // Validate file size before upload
            $(document).on('change', '.memoir-file-input', function() {
                var files = this.files;
                var maxSize = 2 * 1024 * 1024; // 2MB in bytes
                var invalidFiles = [];
                
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > maxSize) {
                        invalidFiles.push(files[i].name);
                    }
                }
                
                if (invalidFiles.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        html: 'The following file(s) exceed the 2MB limit:<br><strong>' + 
                              invalidFiles.join('<br>') + '</strong>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    $(this).val('');
                }
            });

            // MEMOIR FILES MODAL FUNCTIONALITY
            // View memoir files - open modal
            $(document).on('click', '.view-memoir-files', function() {
                var contractId = $(this).data('contract-id');
                var contractName = $(this).data('contract');
                
                $('#memoirFilesModalLabel').html('Memoir Files - <strong>' + contractName + '</strong>');
                $('#modal_contract_id').val(contractId);
                $('#existingMemoirFilesList').empty().html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
                $('.memoir-modal-upload-container').show();
                $('#memoirFilesModal').modal('show');
                
                // Load existing files
                loadMemoirFiles(contractId);
            });

            // Function to load memoir files
            function loadMemoirFiles(contractId) {
                $.ajax({
                    url: '/contracts/' + contractId + '/memoir-documents',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        displayMemoirFiles(data);
                    },
                    error: function(xhr, status, error) {
                        $('#existingMemoirFilesList').empty().append(
                            '<div class="alert alert-danger">Failed to load files. Please try again.</div>'
                        );
                    }
                });
            }

            // Function to display memoir files
            function displayMemoirFiles(files) {
                $('#existingMemoirFilesList').empty();
                
                if (files && files.length > 0) {
                    files.forEach(function(file, index) {
                        var fileIcon = 'glyphicon-file';
                        var fileExt = file.file_name.split('.').pop().toLowerCase();
                        
                        if (fileExt.match(/(jpg|jpeg|png|gif)/)) {
                            fileIcon = 'glyphicon-picture';
                        } else if (fileExt.match(/(pdf)/)) {
                            fileIcon = 'glyphicon-file';
                        } else if (fileExt.match(/(doc|docx)/)) {
                            fileIcon = 'glyphicon-file';
                        } else if (fileExt.match(/(xls|xlsx)/)) {
                            fileIcon = 'glyphicon-stats';
                        }
                        
                        var createdDate = file.created_at ? new Date(file.created_at).toLocaleString() : '';
                        
                        var fileItem = `
                            <div class="list-group-item file-item" data-file-id="${file.id}">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <i class="glyphicon ${fileIcon}"></i> 
                                        <strong>${index + 1}.</strong> 
                                        <a href="${file.file_path}" target="_blank">${file.file_name}</a>
                                        <br>
                                        <small class="text-muted"><i class="glyphicon glyphicon-time"></i> ${createdDate}</small>
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <button type="button" class="btn btn-danger btn-xs delete-memoir-file" 
                                                data-file-id="${file.id}" 
                                                data-file-name="${file.file_name}"
                                                data-contract-id="${file.contract_detailsID}">
                                            <i class="glyphicon glyphicon-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        $('#existingMemoirFilesList').append(fileItem);
                    });
                } else {
                    $('#existingMemoirFilesList').append(
                        '<div class="list-group-item text-muted">No files available for this contract.</div>'
                    );
                }
            }

            // Add more file inputs in modal
            $(document).on('click', '.add-more-modal-file', function() {
                var newRow = `
                    <div class="memoir-modal-file-row" style="margin-top: 10px;">
                        <div class="input-group">
                            <input type="file" name="memoir_file[]" class="form-control modal-file-input" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger remove-modal-file">
                                    <i class="glyphicon glyphicon-remove"></i> Remove
                                </button>
                            </span>
                        </div>
                    </div>
                `;
                
                $('.memoir-modal-upload-container .form-group').append(newRow);
            });

            // Remove file input
            $(document).on('click', '.remove-modal-file', function() {
                $(this).closest('.memoir-modal-file-row').remove();
            });

            // Upload files from modal
            $(document).on('click', '.upload-modal-files', function() {
                var contractId = $('#modal_contract_id').val();
                var formData = new FormData();
                
                // Get all file inputs
                var fileInputs = $('.modal-file-input');
                var hasFiles = false;
                
                fileInputs.each(function() {
                    var files = this.files;
                    if (files.length > 0) {
                        hasFiles = true;
                        for (var i = 0; i < files.length; i++) {
                            formData.append('memoir_file[]', files[i]);
                        }
                    }
                });
                
                if (!hasFiles) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Files',
                        text: 'Please select at least one file to upload.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }
                
                formData.append('_token', '{{ csrf_token() }}');
                
                // Show progress bar
                $('#upload-progress').show();
                var $progressBar = $('#upload-progress .progress-bar');
                $progressBar.css('width', '0%').text('0%');
                
                $.ajax({
                    url: '/contracts/' + contractId + '/upload-memoir-files',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                $progressBar.css('width', percentComplete + '%');
                                $progressBar.text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        $('#upload-progress').hide();
                        // Clear file inputs
                        $('.modal-file-input').val('');
                        // Remove additional file rows except first
                        $('.memoir-modal-file-row:not(:first)').remove();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Files uploaded successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Reload files
                        loadMemoirFiles(contractId);
                    },
                    error: function(xhr, status, error) {
                        $('#upload-progress').hide();
                        
                        var errorMsg = 'Failed to upload files.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: errorMsg,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });

            // Delete memoir file
            $(document).on('click', '.delete-memoir-file', function() {
                var fileId = $(this).data('file-id');
                var fileName = $(this).data('file-name');
                var contractId = $(this).data('contract-id');
                var $button = $(this);
                
                Swal.fire({
                    title: 'Confirm Delete',
                    html: 'Are you sure you want to delete <strong>' + fileName + '</strong>?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        
                        $.ajax({
                            url: '/contracts/memoir-file/' + fileId + '/delete',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'File deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                // Reload files
                                loadMemoirFiles(contractId);
                            },
                            error: function(xhr, status, error) {
                                $button.prop('disabled', false).html('<i class="glyphicon glyphicon-trash"></i> Delete');
                                
                                var errorMsg = 'Failed to delete file.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Delete Failed',
                                    text: errorMsg,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    }
                });
            });

            // Validate file size for modal inputs
            $(document).on('change', '.modal-file-input', function() {
                var files = this.files;
                var maxSize = 2 * 1024 * 1024; // 2MB
                var invalidFiles = [];
                
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > maxSize) {
                        invalidFiles.push(files[i].name);
                    }
                }
                
                if (invalidFiles.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        html: 'The following file(s) exceed the 2MB limit:<br><strong>' + 
                              invalidFiles.join('<br>') + '</strong>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    $(this).val('');
                }
            });

            // Form submission validation for file size in main form
            $('#contractForm').on('submit', function(e) {
                var fileInputs = $('.memoir-file-input');
                var maxSize = 2 * 1024 * 1024; // 2MB
                var hasLargeFile = false;
                var largeFiles = [];

                fileInputs.each(function() {
                    var files = this.files;
                    for (var i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            hasLargeFile = true;
                            largeFiles.push(files[i].name);
                        }
                    }
                });

                if (hasLargeFile) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'File Size Error',
                        html: 'The following file(s) exceed the 2MB limit:<br><strong>' + 
                              largeFiles.join('<br>') + '</strong>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    </script>
@endsection