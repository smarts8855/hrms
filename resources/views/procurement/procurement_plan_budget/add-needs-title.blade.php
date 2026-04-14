@extends('layouts_procurement.app')
@section('pageTitle', 'Create Needs Title')
@section('pageMenu', 'active')
@section('content')



    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="text-transform: uppercase; margin-top: 8px;">
                Create Needs Title
            </h4>

            <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#modalSendMail">
                Send Notification for Submission
            </button>
        </div>

        <div class="panel-body">
            {{-- <div class="text-right" style="margin-bottom: 15px;">
                All fields with <span class="text-danger">*</span> are required.
            </div> --}}

            <form class="custom-validation" action="{{ route('saveNeedsTitle') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Needs Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="needs_title" placeholder="Enter title"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="needs_date" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group" style="margin-top: 27px;">
                            <button class="btn btn-success btn-block" type="submit">Submit Form</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            {{-- <h3 class="panel-title pull-left"><b>Needs Title List</b></h3> --}}
            <h3 class="panel-title pull-left"><b>NEEDS TITLE LIST</b></h3>

            <div class="pull-right" style="font-size: 14px;">
                <i class="fa fa-list"></i> Total Needs Titles
            </div>
        </div>

        <div class="panel-body">

            <hr>

            <div class="table-responsive">
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>TITLE</th>
                            <th>DATE CREATED</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $n=1; @endphp
                        @foreach ($getList as $list)
                            <tr>
                                <td>{{ $n++ }}</td>
                                <td class="font-weight-bold">{{ $list->title }}</td>
                                <td>{{ date('jS M, Y', strtotime($list->date)) }}</td>

                                <td>
                                    @if ($list->status == 1)
                                        <a onclick="closeNeeds('{{ base64_encode($list->needs_titleID) }}')">
                                            <span class="badge badge-primary">Opened</span>
                                            <button class="btn btn-success btn-sm">Close</button>
                                        </a>
                                    @else
                                        <a onclick="openNeeds('{{ base64_encode($list->needs_titleID) }}')">
                                            <span class="badge badge-danger">Closed</span>
                                            <button class="btn btn-primary btn-sm">Open</button>
                                        </a>
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-info btn-sm"
                                        onclick="funcedit('{{ $list->needs_titleID }}','{{ $list->title }}','{{ $list->date }}')">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="funcdelete('{{ base64_encode($list->needs_titleID) }}')">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>




    <!-- Edit Modal -->
    <div class="modal fade text-left d-print-none" id="editModalx" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-edit"></i> Edit Needs Title
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('updateNeedsTitle') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="needs_title" id="needs_titlex" required>
                            <input type="hidden" class="form-control" id="cid" name="id" value="">
                        </div>
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="needs_date" id="needs_datex" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Send Mail Modal -->
    <div class="modal fade text-left d-print-none" id="modalSendMail" tabindex="-1" role="dialog"
        aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-envelope"></i> Send Email Notification
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('send-notification-for-plan') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Recipient</label>
                            <p class="text-muted">Officers with the role of <strong>Needs Submission</strong> are the only
                                ones to receive this mail.</p>
                        </div>
                        <div class="form-group">
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" rows="4" id="message-text" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
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
    </style>
@endsection

@section('scripts')
    <script>
        // function funcdelete(x) {
        //     if (confirm('Are you sure you want to delete this needs title?')) {
        //         document.location = 'delete-needs/' + x;
        //     }
        // }

        function funcdelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This needs title will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete-needs/' + id;
                }
            });
        }


        function funcedit(x, y, z) {
            document.getElementById('cid').value = x;
            document.getElementById('needs_titlex').value = y;
            document.getElementById('needs_datex').value = z;
            $("#editModalx").modal('show')
        }

        // function closeNeeds(x) {
        //     if (confirm('You are about to deactivate this needs title?')) {
        //         document.location = 'close-needs/' + x;
        //     }
        // }

        // function openNeeds(x) {
        //     if (confirm('You are about to activate this needs title?')) {
        //         document.location = 'open-needs/' + x;
        //     }
        // }

        function closeNeeds(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to deactivate this needs title.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, deactivate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'close-needs/' + id;
                }
            });
        }

        function openNeeds(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to activate this needs title.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, activate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'open-needs/' + id;
                }
            });
        }


        function sendMail() {
            $("#modalSendMail").modal('show')
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
