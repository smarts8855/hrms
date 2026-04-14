@extends('layouts_procurement.app')
@section('pageTitle', 'Upload Letters - ' . ($contract->contract_name ?? ''))
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title">
                        <b>Upload Letters: {{ $contract->contract_name ?? '' }}</b>
                    </h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('upload-letters.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <!-- Contract Information Card -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Contract Information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Lot Number:</strong><br>
                                {{ $contract->lot_number ?? 'N/A' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Reference No.:</strong><br>
                                <span class="text-primary">{{ $contract->reference_number ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Contractor:</strong><br>
                                {{ $contract->company_name ?? 'N/A' }}
                            </div>
                            <div class="col-md-3">
                                <strong>Awarded Amount:</strong><br>
                                ₦{{ number_format($contract->awarded_amount ?? 0, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Multiple Letters Form -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Upload Letters</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('upload-letters.upload-multiple') }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              id="uploadForm">
                            @csrf
                            <input type="hidden" name="contract_bidding_id" value="{{ $bidding_id }}">

                            <div class="row">
                                <!-- Recommendation Letter -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Recommendation Letter</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="recommendation_letter">Upload File <span class="text-danger">*</span></label>
                                                <input type="file" 
                                                       class="form-control" 
                                                       id="recommendation_letter" 
                                                       name="recommendation_letter"
                                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                <p class="help-block">
                                                    <small>Allowed: PDF, DOC, DOCX, JPG, PNG (Max: 100KB)</small>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="recommendation_description">Description (Optional)</label>
                                                <textarea class="form-control" 
                                                          id="recommendation_description" 
                                                          name="recommendation_description" 
                                                          rows="2" 
                                                          placeholder="Enter description for recommendation letter"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Award Letter -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Award Letter</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="award_letter">Upload File <span class="text-danger">*</span></label>
                                                <input type="file" 
                                                       class="form-control" 
                                                       id="award_letter" 
                                                       name="award_letter"
                                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                <p class="help-block">
                                                    <small>Allowed: PDF, DOC, DOCX, JPG, PNG (Max: 100KB)</small>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="award_description">Description (Optional)</label>
                                                <textarea class="form-control" 
                                                          id="award_description" 
                                                          name="award_description" 
                                                          rows="2" 
                                                          placeholder="Enter description for award letter"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fa fa-upload"></i> Upload Selected Letters
                                    </button>
                                    <button type="reset" class="btn btn-default btn-lg">
                                        <i class="fa fa-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Existing Letters List -->
                @if($letters->count() > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Uploaded Letters</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Letter Type</th>
                                        <th>File Name</th>
                                        <th>Description</th>
                                        <th>Uploaded By</th>
                                        <th>Uploaded Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $m = 1; @endphp
                                    @foreach($letters as $letter)
                                    <tr>
                                        <td>{{ $m++ }}</td>
                                        <td>
                                            @if($letter->letter_type == 'recommendation')
                                                <span class="label label-info">Recommendation</span>
                                            @else
                                                <span class="label label-success">Award Letter</span>
                                            @endif
                                        </td>
                                        <td>{{ $letter->original_file_name }}</td>
                                        <td>{{ $letter->description ?? 'N/A' }}</td>
                                        <td>{{ App\Models\User::find($letter->uploaded_by)->name ?? 'N/A' }}</td>
                                        <td>{{ date('d M, Y h:i A', strtotime($letter->created_at)) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                                <a href="{{ route('upload-letters.view', $letter->letter_id) }}" 
                                                   target="_blank"
                                                   class="btn btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('upload-letters.download', $letter->letter_id) }}" 
                                                   class="btn btn-success" title="Download">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger" 
                                                        title="Delete"
                                                        onclick="deleteLetter({{ $letter->letter_id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-md-12 -->
</div> <!-- row -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this letter? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .panel-heading {
        padding: 10px 15px;
    }
    .panel-title {
        font-size: 14px;
        font-weight: bold;
    }
    .help-block {
        margin-top: 5px;
        margin-bottom: 0;
        color: #666;
    }
    .btn-group-xs > .btn {
        padding: 3px 8px;
        font-size: 11px;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    // Form validation
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const recFile = document.getElementById('recommendation_letter').files.length;
        const awardFile = document.getElementById('award_letter').files.length;
        
        if (recFile === 0 && awardFile === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'No Files Selected',
                text: 'Please select at least one file to upload!'
            });
        }
    });

    // Delete function
    function deleteLetter(letterId) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ url("procurement/upload-letters/delete") }}/' + letterId;
        $('#deleteModal').modal('show');
    }

    // File input change handler
    $('input[type="file"]').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        const fileSize = this.files[0]?.size / 1024 / 1024; // Size in MB
        
        if (fileSize > 10) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'File size cannot exceed 10MB!'
            });
            $(this).val('');
        }
    });

    // Success message with SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}'
        });
    @endif
</script>
@endsection