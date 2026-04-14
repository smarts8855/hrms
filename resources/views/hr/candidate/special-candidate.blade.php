@extends('layouts.layout')
@section('pageTitle')
    <strong>Special Candidate</strong>
@endsection

@section('content')
    <!-- Page Header -->
    @include('hr.partials.page-header')
    <!-- End Page Header -->

    <div style="padding-bottom: 20px;">
        <div class="box box-default">
            <div class="box-header with-border hidden-print">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">@yield('pageTitle') <span id="processing"></span></h3>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{ url('/interview') }}">
                            <button type="button" class="btn btn-danger btn-sm">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                            </button>
                        </a>
                    </div>

                </div>
            </div>

            <div class="box box-success">
                <div class="box-body">
                    @includeIf('hr.Share.message')
                    <div class="row">
                        <div class="col-md-12">

                            <form action="{{ route('cr.import') }}" method="POST" enctype="multipart/form-data"
                                class="form-horizontal">
                                @csrf
                                <div class="form-group" style="margin-left:10px; margin-right:10px">
                                    <div class="form-group row">
                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <label for="selected_interview" class="form-label">Select Interview </label>
                                                <select name="selected_interview" id="selected_interview"
                                                    class="form-control">
                                                    <option value="">-- Select interview --</option>
                                                    @foreach ($interviews as $int)
                                                        <option value="{{ $int->interviewID }}">
                                                            - {{ $int->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">
                                                    Choose interview category here to apply to all
                                                    rows in excel uploaded.</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <label for="excel_file" class="form-label">
                                                    Excel File (.xlsx, .xls, .csv) -

                                                </label>
                                                <input type="file" class="form-control" name="excel_file"
                                                    accept=".xlsx,.xls,.csv" required>
                                                <a href="{{ asset('samples/CR_Candidates_Template.xlsx') }}"
                                                    class="btn btn-secondary">Download
                                                    Template Sample
                                                </a>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <label for="" style="visibility: hidden">upload</label>
                                            <button type="submit" class="btn btn-primary">Upload Candidates</button>
                                        </div>
                                        <div class="col-lg-1">

                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        {{-- end copy  --}}
        <div class="box box-primary custom-card">
            <div class="box-header with-border">
                <h3 class="box-title">Special Candidate List</h3>
            </div>

            <div class="box-body">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <form action="{{ route('cr-candidate.bulk-approve') }}" method="POST" id="approveForm">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>Selected Candidates:</strong> <span id="selectedCount">0</span>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Approve Selected
                                </button>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th width="1%">S/N</th>
                                    <th>Interview Title</th>
                                    <th>FULLNAME</th>
                                    <th>EMAIL</th>
                                    <th>SEX</th>
                                    <th>ADDRESS</th>
                                    <th>STATE</th>
                                    <th>LGA</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $serialNum = 1; @endphp
                                @foreach ($interviewList as $b)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_candidates[]"
                                                value="{{ $b->candidateID }}" class="candidate-checkbox">
                                        </td>
                                        <td>{{ $serialNum++ }}</td>
                                        <td>{{ $b->interview_title }}</td>
                                        <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}</td>
                                        <td>{{ $b->email }}</td>
                                        <td>{{ $b->sex }}</td>
                                        <td>{{ $b->address }}</td>
                                        <td>{{ $b->state_name }}</td>
                                        <td>{{ $b->lga_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#confirmToDelete{{ $b->candidateID }}">
                                                <i class="glyphicon glyphicon-trash"></i> Delete
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#confirmToEdit{{ $b->candidateID }}">
                                                <i class="glyphicon glyphicon-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>

                    <div class="d-flex justify-content-center">
                        {{ $interviewList->links() }}
                    </div>
                </div>
            </div>

            {{-- DELETE & EDIT MODALS OUTSIDE THE TABLE AND FORM --}}
            @foreach ($interviewList as $b)
                {{-- Delete Modal --}}
                <div class="modal fade text-left" id="confirmToDelete{{ $b->candidateID }}" tabindex="-1" role="dialog"
                    aria-labelledby="confirmToDelete" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title text-white">Confirm Deletion</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-center text-danger">
                                <h4>Are you sure you want to delete candidate <strong>{{ $b->surname }}
                                        {{ $b->first_name }} {{ $b->othernames }}</strong>?</h4>
                            </div>
                            <form action="{{ route('cr-candidate.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="candidateID" value="{{ $b->candidateID }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-info"
                                        data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade text-left" id="confirmToEdit{{ $b->candidateID }}" tabindex="-1" role="dialog"
                    aria-labelledby="confirmToEdit" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title text-white">Edit Candidate Details</h4>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('cr-candidate.edit') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="candidate_id" value="{{ $b->candidateID }}">
                                    <input type="hidden" name="interviewID" value="{{ $b->interview_titleID }}">
                                    <div class="form-group" style="margin-left:10px; margin-right:10px">
                                        <div class="row form-group">
                                            <div class="col-lg-6 mb-3">
                                                <label>Title</label>
                                                <select class="form-control input-sm" name="title">
                                                    @foreach (['Mr', 'Ms', 'Mrs', 'Miss'] as $title)
                                                        <option value="{{ $title }}"
                                                            {{ $b->candidate_title == $title ? 'selected' : '' }}>
                                                            {{ $title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Surname</label>
                                                <input class="form-control input-sm" type="text" name="surname"
                                                    value="{{ $b->surname }}">
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>First Name</label>
                                                <input class="form-control input-sm" type="text" name="first_name"
                                                    value="{{ $b->first_name }}">
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Othernames</label>
                                                <input class="form-control input-sm" type="text" name="othernames"
                                                    value="{{ $b->othernames }}">
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Email</label>
                                                <input class="form-control input-sm" type="email" name="email"
                                                    value="{{ $b->email }}">
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Phone No.</label>
                                                <input class="form-control input-sm" type="text" name="phoneNo"
                                                    value="{{ $b->phoneNo }}">
                                            </div>

                                            {{-- Right Column --}}
                                            <div class="col-lg-6 mb-3">
                                                <label>Sex</label>
                                                <select name="sex" class="form-control input-sm">
                                                    <option value="">- Select -</option>
                                                    <option value="Male" {{ $b->sex == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female" {{ $b->sex == 'Female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Marital Status</label>
                                                <select name="maritalStatus" class="form-control input-sm">
                                                    @foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $status)
                                                        <option value="{{ $status }}"
                                                            {{ $b->maritalStatus == $status ? 'selected' : '' }}>
                                                            {{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>State of Origin</label>
                                                <select name="state" class="form-control input-sm state-select">
                                                    <option value="">- Select State -</option>
                                                    @foreach ($state as $s)
                                                        <option value="{{ $s->StateID }}"
                                                            {{ $b->state == $s->StateID ? 'selected' : '' }}>
                                                            {{ $s->State }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>LGA</label>
                                                <select name="lga" class="form-control input-sm lga-select">
                                                    @if (!empty($b->lga))
                                                        <option value="{{ $b->lgaId }}" selected>
                                                            {{ $b->lga_name ?? $b->lga }}</option>
                                                    @else
                                                        <option value="">- Select LGA -</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label>Address</label>
                                                <textarea class="form-control input-sm" name="address" rows="4">{{ $b->address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                                                    class="fa fa-times"></i> Close</button>
                                            <button type="submit" class="btn btn-success btn-sm"><i
                                                    class="fa fa-floppy-o"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    {{-- Optional: JS to dynamically update LGA based on State --}}
    <script>
        $(document).ready(function() {
            $('.state-select').change(function() {
                var stateId = $(this).val();
                var lgaSelect = $(this).closest('.modal-body').find('.lga-select');

                if (stateId) {
                    $.ajax({
                        url: '/get-lgas/' + stateId, // create a route to return LGAs
                        type: 'GET',
                        success: function(data) {
                            lgaSelect.empty();
                            lgaSelect.append('<option value="">- Select LGA -</option>');
                            $.each(data, function(key, value) {
                                lgaSelect.append('<option value="' + value.lgaId +
                                    '">' + value.lga + '</option>');
                            });
                        }
                    });
                } else {
                    lgaSelect.empty().append('<option value="">- Select LGA -</option>');
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '.state-select', function() {
            var state_id = $(this).val();
            var modal = $(this).closest('.modal');
            var lgaSelect = modal.find('.lga-select');

            if (!state_id) {
                lgaSelect.empty().append('<option value="">- Select -</option>');
                return;
            }

            $.ajax({
                url: '/get-lga-from-state',
                type: 'GET',
                data: {
                    state_id: state_id
                },
                success: function(data) {
                    lgaSelect.empty().append('<option value="">Select LGA</option>');
                    $.each(data, function(index, obj) {
                        lgaSelect.append('<option value="' + obj.lgaId + '">' + obj.lga +
                            '</option>');
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching LGAs:', xhr.responseText);
                    alert('Error loading LGAs. Please check your connection or backend route.');
                }
            });
        });
    </script>


    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.candidate-checkbox').forEach(cb => cb.checked = isChecked);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.candidate-checkbox');
            const selectedCount = document.getElementById('selectedCount');

            function updateCount() {
                const count = document.querySelectorAll('.candidate-checkbox:checked').length;
                selectedCount.textContent = count;
            }

            // Individual checkbox changes
            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCount);
            });

            // Select All toggle
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateCount();
            });
        });
    </script>
@endsection
