@extends('layouts.layout')

@section('pageTitle')
    New Appointment
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span
                        id='processing'><strong><em>Admin Approval.</em></strong></span></h3>
            </div>

            <div class="box-body">
                <div class="row">

                    @includeIf('Share.message')

                    <div class="col-md-12">
                        <!--2nd col-->
                        <form method="post" action="{{ url('/interview-score-sheet') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="interviewName">SELECT INTERVIEW NAME</label>
                                        <select name="interviewName" id="interviewName" required class="form-control">
                                            <option value="">Select</option>
                                            @if (isset($getInterviewName) && $getInterviewName)
                                                @foreach ($getInterviewName as $listInterview)
                                                    <option value="{{ $listInterview->interviewID }}"
                                                        {{ $listInterview->interviewID == (isset($getInterviewID) ? $getInterviewID : old('interviewName')) ? 'selected' : '' }}>
                                                        {{ $listInterview->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <br />
                                    <br />
                                </div>
                            </div>

                        </form>



                        {{-- Showing the title and the date of the selected options --}}
                        @if (isset($getRecords) && !empty($getRecords[0]))
                            <div class="row">
                                <div class="ml-3 col-md-4">
                                    <h3> For: <strong> {{ $getRecords[0]->title }} </strong> </h2>
                                        <h3> Date: <strong> {{ date('F j, Y', strtotime($getRecords[0]->date)) }} </strong>
                                            <i class="fa fa-calendar" aria-hidden="true"></i> </h2>
                                </div>
                            </div>
                        @endif

                        <hr />

                        {{-- <div class="noprint">
                                <h4>Interview Memo:
                                    @if (isset($getRecords) && !empty($getRecords[0]))
                                        <em> <a href="{{ asset('interviewMemos/' . $getRecords[0]->filename) }}"
                                                target="__blank">{{ $getRecords[0]->filename }}</a> </em>,
                                    @endif
                                </h4>
                            </div> --}}

                        <div class="noprint">
                            <h4>Interview Attachments:
                                @if (isset($interviewAttachments) && $interviewAttachments)
                                    @foreach ($interviewAttachments as $int => $attachment)
                                        <em> <a href="{{ asset("interviewAttachmentfiles/$attachment->attachment") }}"
                                                target="__blank">{{ $attachment->description . '-' . ++$int }}</a> </em>,
                                    @endforeach
                                @endif
                            </h4>
                        </div>

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->

            @if (isset($getRecords) && $getRecords->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="{{ url('/interview-score-sheet/admin-approval') }}"
                            enctype="multipart/form-data">
                            @csrf



                            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="9">

                                            <div align="right">
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-backdrop="false" data-target="#confirmApproval">FORWARD TO
                                                    CR</button>
                                                {{-- <form method="POST" action="{{ route('reject.selected.candidates') }}"
                                                    id="rejectSelectedForm">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        id="rejectAllBtn">Reject Selected</button>
                                                </form> --}}
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    id="rejectAllBtn">Reject Selected</button>

                                                <button type="button" class="btn btn-sm btn-primary noprint"
                                                    data-toggle="modal" data-backdrop="false"
                                                    data-target="#confirmComment">View
                                                    Comment</button>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>S/N</th>
                                        {{-- <th>
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmApproval">FORWARD TO
                                            CR</button>
                                    </th> --}}
                                        <th>


                                            {{-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-backdrop="false" data-target="#confirmApproval">FORWARD TO CR</button> <br> --}}
                                            <input type="checkbox" id="checkAll" />

                                            <label for="checkAll">Check All</label>
                                        </th>

                                        <th>CANDIDATE</th>
                                        <th>APPEARANCE <br> (5 MARKS)</th>
                                        <th>COMPORTMENT <br> (5 MARKS)</th>
                                        <th>5 QUESTIONS 2 MARKS EACH <br> (10 MARKS)</th>
                                        <th>TOTAL SCORES</th>
                                        <th>REMARKS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($getRecords) && $getRecords)
                                        @foreach ($getRecords as $key => $list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($list->is_approved == 1)
                                                        <div class="text-center"><span
                                                                class="fa fa-check text-success"></span>
                                                        </div>
                                                    @else
                                                        <div align="center"><input type="checkbox"
                                                                name="selectedCandidate[]"
                                                                value="{{ $list->score_sheetID }}" /></div>
                                                    @endif
                                                </td>
                                                {{-- <td>{{ $list->surname . ' ' . $list->first_name . ' ' . $list->othernames }}
                                                </td> --}}
                                                <td>
                                                    {{ $list->surname }} {{ $list->first_name }}
                                                    {{ $list->othernames }}
                                                    <br>
                                                    @if ($list->candidate_source == 'CR')
                                                        <span class="label label-success">
                                                            {{ $list->candidate_source }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $list->appearance_mark }}</td>
                                                <td>{{ $list->comportment_mark }}</td>
                                                <td>{{ $list->question_each_mark }}</td>
                                                <td>{{ $list->total_mark }}</td>
                                                <td>{{ $list->review }}</td>
                                                <td>

                                                    {{-- <a href="/edit-score-sheet/{{ $list->score_sheetID }}" target="_blank"
                                                        class="pull-right"><span class="btn btn-info btn-sm">
                                                            <span class="glyphicon glyphicon-edit"></span> &nbsp;
                                                            Edit</span></a> --}}

                                                    <a href="{{ url('/edit-score-sheet/' . $list->score_sheetID) }}?redirect={{ urlencode(url()->full()) }}"
                                                        target="_blank" class="btn btn-info btn-sm pull-right">
                                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                                    </a>

                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="rejectCandidate({{ $list->score_sheetID }})">Reject</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <!-- Modal to delete -->
                            <div class="modal fade text-left d-print-none" id="confirmApproval" tabindex="-1"
                                role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="text-success text-center">
                                                        <h4>Are you sure you want to approve this candidate(s)? </h4>
                                                    </div>
                                                    <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
                                                    <br />
                                                    <input type="hidden" name="getInterviewID"
                                                        value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal"> No.
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success"> Yes. Approve </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end Modal-->
                        </form>

                        <form method="post" action="{{ url('/interview-push-approved-score') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Modal to push -->
                            <div class="modal fade text-left d-print-none" id="confirmPush" tabindex="-1"
                                role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="text-success text-center">
                                                        <h4>Are you sure you want to forward the seleted candidate(s)? </h4>
                                                    </div>
                                                    <br />
                                                    <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
                                                    <input type="hidden" name="getInterviewID"
                                                        value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success"> Forward Now </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end Modal-->
                        </form>

                        <!-- Modal to Comment -->
                        <div class="modal fade text-left d-print-none" id="confirmComment" tabindex="-1" role="dialog"
                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Comment</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div style="max-height: 400px; overflow-x: auto;">
                                                            @if (isset($getComments) && $getComments)
                                                                @foreach ($getComments as $keyComment => $comment)
                                                                    <div class="col-md-12">
                                                                        {{ $keyComment + 1 . ' ' }}.
                                                                        {{ $comment->comment . ' - ' }} <br /> <i
                                                                            class="fa fa-calendar">
                                                                            {{ date('d-m-Y', strtotime($comment->created_at)) }}</i>
                                                                        <hr />
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end Modal-->
                    </div>
                </div>
            @else
                <div class="text-center text-muted">
                    <h4>No candidates available for this interview.</h4>
                </div>
            @endif

        </div>
    </div>
    <form id="getCandidateForm" method="post" action="{{ url('/get-candidate-for-interview') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="inverviewName" id="inverviewName" />
    </form>
@endsection

@section('style')
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
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            $("#interviewName").change(function() {
                $('#inverviewName').val($('#interviewName').val());
                $('#getCandidateForm').submit();
            });
        }); //end document
    </script>







    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('input[name="selectedCandidate[]"]');
            const rejectAllBtn = document.getElementById('rejectAllBtn');

            checkAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    if (!cb.disabled) cb.checked = checkAll.checked;
                });
            });

            rejectAllBtn.addEventListener('click', function() {
                const selected = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selected.length === 0) {
                    Swal.fire('Info', 'Please select at least one candidate', 'info');
                    return;
                }

                Swal.fire({
                    title: 'Reject Candidate(s)',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputPlaceholder: 'Enter rejection comment...',
                    inputAttributes: {
                        required: true
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    confirmButtonColor: '#d33',
                    preConfirm: (comment) => {
                        if (!comment) {
                            Swal.showValidationMessage('Comment is required');
                        }
                        return comment;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('reject.selected.candidates') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    selectedCandidates: selected,
                                    comment: result.value
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Rejected!', data.message, 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            });
                    }
                });
            });
        });
    </script>

    <script>
        // SweetAlert Toast config (reuse anywhere)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal-popup',
                title: 'swal-title'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function rejectCandidate(id) {
            Swal.fire({
                title: 'Reject Candidate',
                input: 'textarea',
                inputLabel: 'Reason for rejection',
                inputPlaceholder: 'Enter rejection comment...',
                showCancelButton: true,
                confirmButtonText: 'Reject',
                confirmButtonColor: '#d33',
                preConfirm: (comment) => {
                    if (!comment) {
                        Swal.showValidationMessage('Comment is required');
                    }
                    return comment;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/reject-candidate/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                comment: result.value
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Candidate rejected successfully'
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message || 'Failed to reject candidate'
                                });
                            }
                        })
                        .catch(() => {
                            Toast.fire({
                                icon: 'error',
                                title: 'Server error. Please try again'
                            });
                        });
                }
            });
        }
    </script>
@endsection
