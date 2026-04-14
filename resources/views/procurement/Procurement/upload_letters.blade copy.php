@extends('layouts_procurement.app')
@section('pageTitle', 'Upload Letters')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Upload Recommendation & Award Letters</b></h3>
                </div>
                <div class="pull-right">
                    <h4 style="font-size: 14px;">
                        <i class="fa fa-file-text"></i> Total Contracts: {{ $contracts->total() }}
                    </h4>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <!-- Filter/Search Section -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('upload-letters.index') }}" method="GET" class="form-inline pull-right">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control input-sm" 
                                       placeholder="Search by contract name..." value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Lot No.</th>
                                <th>Contract Name</th>
                                <th>Contractor</th>
                                <th>Contractor Email</th>
                                <th>Proposed Amount</th>
                                <th>Awarded Amount</th>
                                <th>Recommendation</th>
                                <th>Award Letter</th>
                                <th>Email Actions</th>
                                <th>Other Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $n = ($contracts->currentPage() - 1) * $contracts->perPage() + 1; @endphp
                            @forelse ($contracts as $contract)
                                @php 
                                    $hasRecommendation = !empty($contract->has_recommendation);
                                    $hasAwardLetter = !empty($contract->has_award_letter);
                                    $hasEmail = !empty($contract->contractor_email);
                                    $bidId = base64_encode($contract->contract_biddingID);
                                @endphp
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $contract->lot_number ?? 'N/A' }}</td>
                                    <td>{{ $contract->contract_name ?? 'N/A' }}</td>
                                    <td>{{ $contract->company_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($hasEmail)
                                            <span class="label label-success" style="cursor: pointer;" 
                                                  onclick="showEmailInfo('{{ $contract->contractor_email }}')">
                                                <i class="fa fa-envelope"></i> {{ $contract->contractor_email }}
                                            </span>
                                        @else
                                            <span class="label label-danger">
                                                <i class="fa fa-times-circle"></i> No Email
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right">₦{{ number_format($contract->proposed_budget ?? 0, 2) }}</td>
                                    <td class="text-right">₦{{ number_format($contract->awarded_amount ?? 0, 2) }}</td>
                                    <td class="text-center">
                                        @if($hasRecommendation)
                                            <span class="label label-success">
                                                <i class="fa fa-check-circle"></i> Uploaded
                                            </span>
                                        @else
                                            <span class="label label-danger">
                                                <i class="fa fa-times-circle"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($hasAwardLetter)
                                            <span class="label label-success">
                                                <i class="fa fa-check-circle"></i> Uploaded
                                            </span>
                                        @else
                                            <span class="label label-danger">
                                                <i class="fa fa-times-circle"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- EMAIL ACTIONS COLUMN - Dedicated email buttons -->
                                    <td style="min-width: 100px;">
                                        @if($hasEmail)
                                            <div class="btn-group-vertical btn-group-xs" style="width: 100%;">
                                                @if($hasRecommendation)
                                                    <button type="button" 
                                                            class="btn btn-warning btn-xs" 
                                                            onclick="sendEmail('{{ $contract->rec_letter_id }}', 'recommendation', '{{ $contract->contractor_email }}', '{{ $contract->company_name }}')"
                                                            style="margin-bottom: 2px; text-align: left;"
                                                            title="Send Recommendation Letter">
                                                        <i class="fa fa-envelope"></i> Send Rec Letter
                                                    </button>
                                                @endif
                                                
                                                @if($hasAwardLetter)
                                                    <button type="button" 
                                                            class="btn btn-success btn-xs" 
                                                            onclick="sendEmail('{{ $contract->award_letter_id }}', 'award', '{{ $contract->contractor_email }}', '{{ $contract->company_name }}')"
                                                            style="margin-bottom: 2px; text-align: left;"
                                                            title="Send Award Letter">
                                                        <i class="fa fa-envelope"></i> Send Award Letter
                                                    </button>
                                                @endif
                                                
                                                @if($hasRecommendation || $hasAwardLetter)
                                                    <button type="button" 
                                                            class="btn btn-primary btn-xs" 
                                                            onclick="sendBulkEmails('{{ $contract->contract_biddingID }}')"
                                                            style="text-align: left;"
                                                            title="Send All Letters">
                                                        <i class="fa fa-envelope-o"></i> Send All
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="label label-danger">
                                                <i class="fa fa-exclamation-triangle"></i> No Email
                                            </span>
                                            <button type="button" 
                                                    class="btn btn-default btn-xs" 
                                                    onclick="showNoEmailWarning()"
                                                    style="margin-top: 2px;">
                                                <i class="fa fa-info-circle"></i> Add Email
                                            </button>
                                        @endif
                                    </td>
                                    
                                    <!-- OTHER ACTIONS COLUMN - View, Download, Delete -->
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{ route('upload-letters.create', $bidId) }}" 
                                               class="btn btn-primary" title="Upload Letters">
                                                <i class="fa fa-upload"></i>
                                            </a>
                                            @if($hasRecommendation || $hasAwardLetter)
                                                <button type="button" class="btn btn-info dropdown-toggle" 
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    @if($hasRecommendation)
                                                    <li class="dropdown-header">
                                                        <i class="fa fa-file-text-o"></i> RECOMMENDATION
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="viewLetter('recommendation', '{{ $contract->contract_biddingID }}')">
                                                            <i class="fa fa-eye text-info"></i> Quick View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="previewLetter('{{ $contract->rec_letter_id }}', 'recommendation')">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> Preview
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/procurement/upload-letters/view/{{ $contract->rec_letter_id }}" target="_blank">
                                                            <i class="fa fa-external-link text-success"></i> Open in New Tab
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/procurement/upload-letters/download/{{ $contract->rec_letter_id }}">
                                                            <i class="fa fa-download text-primary"></i> Download
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteLetter('{{ $contract->rec_letter_id }}', 'recommendation')" 
                                                           style="color: #d9534f;">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </li>
                                                    @endif
                                                    
                                                    @if($hasRecommendation && $hasAwardLetter)
                                                    <li class="divider"></li>
                                                    @endif
                                                    
                                                    @if($hasAwardLetter)
                                                    <li class="dropdown-header">
                                                        <i class="fa fa-trophy"></i> AWARD LETTER
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="viewLetter('award', '{{ $contract->contract_biddingID }}')">
                                                            <i class="fa fa-eye text-info"></i> Quick View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="previewLetter('{{ $contract->award_letter_id }}', 'award')">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> Preview
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/procurement/upload-letters/view/{{ $contract->award_letter_id }}" target="_blank">
                                                            <i class="fa fa-external-link text-success"></i> Open in New Tab
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/procurement/upload-letters/download/{{ $contract->award_letter_id }}">
                                                            <i class="fa fa-download text-primary"></i> Download
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteLetter('{{ $contract->award_letter_id }}', 'award')" 
                                                           style="color: #d9534f;">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </li>
                                                    @endif
                                                    
                                                    @if($hasRecommendation || $hasAwardLetter)
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('upload-letters.email-logs', $contract->contract_biddingID) }}" target="_blank">
                                                            <i class="fa fa-history text-info"></i> View Email Logs
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle"></i> No contracts found
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $contracts->links() }}
                    </div>
                </div>

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-md-12 -->
</div> <!-- row -->

<!-- Quick Email Modal -->
<div class="modal fade" id="quickEmailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Quick Email</h4>
            </div>
            <div class="modal-body">
                <form id="quickEmailForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Recipient Email</label>
                        <input type="email" class="form-control" id="quickEmailRecipient" readonly>
                    </div>
                    <div class="form-group">
                        <label>Letter Type</label>
                        <input type="text" class="form-control" id="quickEmailType" readonly>
                    </div>
                    <div class="form-group">
                        <label>Additional Message (Optional)</label>
                        <textarea class="form-control" id="quickEmailMessage" rows="3" placeholder="Add a personal message..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="sendQuickEmail()">Send Email</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .label {
        font-size: 11px;
        padding: 5px 8px;
    }
    .btn-group-xs > .btn {
        padding: 3px 8px;
        font-size: 11px;
    }
    .dropdown-menu {
        min-width: 220px;
        padding: 5px 0;
        box-shadow: 0 6px 12px rgba(0,0,0,0.175);
    }
    .dropdown-header {
        color: #337ab7;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        padding: 5px 15px;
        background-color: #f5f5f5;
        margin: 2px 0;
    }
    .dropdown-menu > li > a {
        padding: 8px 15px;
        font-size: 12px;
        transition: all 0.3s;
    }
    .dropdown-menu > li > a:hover {
        background-color: #f0f0f0;
        padding-left: 20px;
    }
    .dropdown-menu > li > a i {
        margin-right: 8px;
        width: 16px;
        color: #777;
    }
    .dropdown-menu > li > a:hover i {
        color: #333;
    }
    .dropdown-menu .divider {
        margin: 5px 0;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    /* SweetAlert2 custom styling */
    .swal2-popup {
        font-size: 1.2rem !important;
    }
    .swal2-html-container {
        margin: 1em 0.5em 0.5em !important;
    }
    /* Email buttons styling */
    .btn-warning, .btn-success, .btn-primary {
        color: #fff;
        font-weight: 500;
    }
    .btn-warning {
        background-color: #f39c12;
        border-color: #e67e22;
    }
    .btn-warning:hover {
        background-color: #e67e22;
    }
    .btn-group-vertical .btn {
        border-radius: 3px !important;
        margin-bottom: 2px !important;
    }
    /* Tooltip styling */
    .tooltip {
        font-size: 11px;
    }
    /* Status labels */
    .label-success {
        background-color: #5cb85c;
    }
    .label-danger {
        background-color: #d9534f;
    }
    .label-warning {
        background-color: #f0ad4e;
        color: #fff;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Pass contracts data to JavaScript
    const contractsData = @json($contracts->items());
    
    // Function to show email info
    function showEmailInfo(email) {
        Swal.fire({
            icon: 'info',
            title: 'Contractor Email',
            html: `
                <div style="text-align: center;">
                    <p><strong>Email Address:</strong></p>
                    <p style="font-size: 16px; color: #337ab7;">${email}</p>
                    <button onclick="copyToClipboard('${email}')" class="btn btn-sm btn-default" style="margin-top: 10px;">
                        <i class="fa fa-copy"></i> Copy Email
                    </button>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true
        });
    }
    
    // Function to copy to clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Email address copied to clipboard',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }
    
    // Function to send email with confirmation
    function sendEmail(letterId, type, contractorEmail, companyName) {
        if (!letterId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Letter ID not found!'
            });
            return;
        }

        if (!contractorEmail) {
            Swal.fire({
                icon: 'warning',
                title: 'No Email Address',
                text: 'This contractor does not have an email address registered.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Send Email?',
            html: `
                <div style="text-align: left;">
                    <p>Do you want to send this <strong>${type.toUpperCase()}</strong> letter to the contractor?</p>
                    <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 15px 0;">
                        <p><strong>Contractor:</strong> ${companyName || 'N/A'}</p>
                        <p><strong>Recipient:</strong> ${contractorEmail}</p>
                        <p><strong>Letter Type:</strong> ${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                    </div>
                    <p style="color: #666; font-size: 12px;">
                        <i class="fa fa-info-circle"></i> The letter will be attached to the email.
                    </p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f39c12',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-envelope"></i> Yes, send it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/upload-letters/send-email/${letterId}`;
                form.style.display = 'none';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Function to show no email warning
    function showNoEmailWarning() {
        Swal.fire({
            icon: 'warning',
            title: 'Email Not Available',
            html: `
                <div style="text-align: left;">
                    <p>This contractor does not have an email address registered.</p>
                    <p style="margin-top: 10px;">Please update the contractor information first:</p>
                    <ul style="list-style: none; padding: 0;">
                        <li><i class="fa fa-arrow-right"></i> Go to Contractor Registration</li>
                        <li><i class="fa fa-arrow-right"></i> Edit contractor details</li>
                        <li><i class="fa fa-arrow-right"></i> Add email address</li>
                    </ul>
                </div>
            `,
            confirmButtonText: 'OK'
        });
    }

    // Function to send bulk emails
    function sendBulkEmails(contractId) {
        // Get all letter IDs for this contract
        const contract = contractsData.find(c => c.contract_biddingID == contractId);
        
        if (!contract) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Contract not found!'
            });
            return;
        }

        if (!contract.contractor_email) {
            Swal.fire({
                icon: 'warning',
                title: 'No Email Address',
                text: 'This contractor does not have an email address registered.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const letterIds = [];
        const letterTypes = [];
        
        if (contract.rec_letter_id) {
            letterIds.push(contract.rec_letter_id);
            letterTypes.push('Recommendation');
        }
        if (contract.award_letter_id) {
            letterIds.push(contract.award_letter_id);
            letterTypes.push('Award');
        }

        if (letterIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Letters',
                text: 'No letters found for this contract!'
            });
            return;
        }

        Swal.fire({
            title: 'Send All Letters?',
            html: `
                <div style="text-align: left;">
                    <p>Do you want to send all letters to the contractor?</p>
                    <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 15px 0;">
                        <p><strong>Contractor:</strong> ${contract.company_name || 'N/A'}</p>
                        <p><strong>Recipient:</strong> ${contract.contractor_email}</p>
                        <p><strong>Letters to send:</strong></p>
                        <ul style="list-style: none; padding-left: 10px;">
                            ${letterTypes.map(type => `<li><i class="fa fa-check-circle text-success"></i> ${type} Letter</li>`).join('')}
                        </ul>
                    </div>
                    <p style="color: #666; font-size: 12px;">
                        <i class="fa fa-info-circle"></i> Total: ${letterIds.length} letter(s) will be sent
                    </p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#337ab7',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-envelope-o"></i> Yes, send all!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("upload-letters.send-bulk-emails") }}';
                form.style.display = 'none';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                letterIds.forEach((id, index) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `letter_ids[${index}]`;
                    input.value = id;
                    form.appendChild(input);
                });
                
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Function to view letter details
    function viewLetter(type, biddingId) {
        const contract = contractsData.find(c => c.contract_biddingID == biddingId);
        
        if (!contract) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Contract not found!',
                timer: 2000
            });
            return;
        }
        
        let letterId, fileName, uploadedAt;
        
        if (type === 'recommendation') {
            letterId = contract.rec_letter_id;
            fileName = contract.rec_original_name;
            uploadedAt = contract.rec_uploaded_at;
        } else {
            letterId = contract.award_letter_id;
            fileName = contract.award_original_name;
            uploadedAt = contract.award_uploaded_at;
        }
        
        if (!letterId) {
            Swal.fire({
                icon: 'warning',
                title: 'No Letter Found',
                text: `No ${type} letter has been uploaded.`,
                timer: 2000
            });
            return;
        }
        
        Swal.fire({
            title: `${type.charAt(0).toUpperCase() + type.slice(1)} Letter`,
            html: `
                <div style="text-align: left;">
                    <p><strong>File:</strong> ${fileName}</p>
                    <p><strong>Uploaded:</strong> ${uploadedAt ? new Date(uploadedAt).toLocaleDateString() : 'N/A'}</p>
                    <hr>
                    <div style="text-align: center;">
                        <a href="/procurement/upload-letters/view/${letterId}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View
                        </a>
                        <a href="/procurement/upload-letters/download/${letterId}" class="btn btn-success btn-sm">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true
        });
    }
    
    // Function to preview letter
    function previewLetter(letterId, type) {
        if (!letterId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Letter ID not found!'
            });
            return;
        }
        
        Swal.fire({
            title: `${type.charAt(0).toUpperCase() + type.slice(1)} Letter Preview`,
            html: `
                <div style="width: 100%; height: 500px;">
                    <iframe src="/procurement/upload-letters/view/${letterId}" 
                            style="width:100%; height:100%; border:1px solid #ddd;"></iframe>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true,
            width: '900px'
        });
    }
    
    // Function to delete letter
    function deleteLetter(letterId, type) {
        if (!letterId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Letter ID not found!'
            });
            return;
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete this ${type} letter? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/upload-letters/delete/${letterId}`;
                form.style.display = 'none';
                
                // CSRF Token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                // Method spoofing for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';  // FIXED: was incorrectly set to csrfInput.name
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Initialize tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Handle search form validation
        $('form.form-inline').on('submit', function(e) {
            const searchValue = $(this).find('input[name="search"]').val();
            if (searchValue && searchValue.length < 2) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Search Too Short',
                    text: 'Please enter at least 2 characters.',
                    timer: 2000
                });
            }
        });
    });
    
    // Handle session messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 5000,
            showConfirmButton: true
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 5000,
            showConfirmButton: true
        });
    @endif
    
    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning!',
            text: '{{ session('warning') }}',
            timer: 5000,
            showConfirmButton: true
        });
    @endif
</script>
@endsection