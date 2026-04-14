<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<form action="{{ url('/documentation-basic-infox') }}" method="POST">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step2">
        <div class="col-md-offset-0">
            <h3 class="text-success text-center">
                <i class="glyphicon glyphicon-user"></i> <b>Basic Information</b>
            </h3>
            <div class="text-danger" align="right" style="margin-top: -35px;">
                Field with <span class="text-danger"><big>*</big></span> is required
            </div>
        </div>
        <br />

    </div>
    <div class="row col-md-offset-1">

        <div class="col-md-2">
            <label>File Number</label>
            @if ($staffInfo != '')
                <input type="text" class="form-control input-lg" id="fileNox" name="fileNox"
                    value="{{ isset($mainStaffFileNo) ? $mainStaffFileNo : '' }}">
                <input readonly type="hidden" class="form-control input-lg" id="fileNo" name="fileNo"
                    value="{{ $fileNo }}">
                <!---->
            @else
                <input type="text" class="form-control input-lg" id="fileNox" name="fileNox"
                    placeholder="{{ isset($mainStaffFileNo) ? $mainStaffFileNo : '' }}">
                <input readonly type="hidden" class="form-control input-lg" id="fileNo" name="fileNo"
                    value="{{ $fileNo }}">
            @endif
            <!---->
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Surname</label>
                @if ($staffInfo != '')
                    <input readonly type="text" name="surname" id="surname" class="form-control input-lg"
                        value="{{ $staffInfo->surname }}" required />
                @else
                    <input readonly type="text" name="surname" id="surname" class="form-control input-lg"
                        value="{{ old('surname') }}" required />
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>First name</label>
                @if ($staffInfo != '')
                    <input readonly type="text" name="firstName" id="firstName" class="form-control input-lg"
                        value="{{ $staffInfo->first_name }}" required />
                @else
                    <input readonly type="text" name="firstName" id="firstName" class="form-control input-lg"
                        value="{{ old('firstName') }}" required />
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Other Names</label>
                @if ($staffInfo != '')
                    <input readonly type="text" name="otherNames" id="otherNames" class="form-control input-lg"
                        value="{{ $staffInfo->othernames }}" />
                @else
                    <input readonly type="text" name="otherNames" id="otherNames" class="form-control input-lg"
                        value="{{ old('otherNames') }}" />
                @endif
            </div>

        </div>
    </div>

    <div class="row col-md-offset-1">
        <div class="col-md-2">
            <div class="form-group">
                <label>Title <span class="text-danger"><big>*</big></span></label>
                @if ($staffInfo != '')
                    <select name="title" id="title" class="form-control input-lg formex" required>
                        <option value="">Select</option>
                        <option value="MR." {{ $staffInfo->title === 'MR.' ? 'selected' : '' }}>Mr.</option>
                        <option value="MRS." {{ $staffInfo->title === 'MRS.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="MISS" {{ $staffInfo->title === 'MISS' ? 'selected' : '' }}>Miss</option>
                        <option value="HON. JUSTICE" {{ $staffInfo->title === 'HON. JUSTICE' ? 'selected' : '' }}>Hon.
                            Justice</option>
                    </select>
                @else
                    <select name="title" id="title" class="form-control input-lg formex">
                        <option value="">Select</option>
                        <option value="MR." {{ old('title') == 'MR.' ? 'selected' : '' }}>Mr.</option>
                        <option value="MRS." {{ old('title') == 'MRS.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="MISS" {{ old('title') == 'MISS' ? 'selected' : '' }}>Miss</option>
                        <option value="HON. JUSTICE" {{ old('title') == 'HON. JUSTICE' ? 'selected' : '' }}>Hon.
                            Justice</option>
                    </select>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Gender <span class="text-danger"><big>*</big></span></label>
                @if ($staffInfo != '')
                    <select name="gender" id="gender" class="formex form-control input-lg" required>
                        <option value="">Select</option>
                        <option value="Male"
                            {{ $staffInfo->gender === 'Male' || $staffInfo->gender === 'MALE' || old('gender') === 'Male' ? 'selected' : '' }}>
                            Male</option>
                        <option value="Female"
                            {{ $staffInfo->gender === 'Female' || $staffInfo->gender === 'FEMALE' || old('gender') === 'Female' ? 'selected' : '' }}>
                            Female</option>
                    </select>
                @else
                    <select name="gender" id="gender" class="formex form-control input-lg" required>
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Date of Birth</label>
                @if ($staffInfo != '')
                    <input readonly="readonly" placeholder="Date of Birth" type="date" name="dateofBirth"
                        id="dob" class="form-control input-lg"
                        value="{{ $staffInfo->dob ? date('Y-m-d', strtotime($staffInfo->dob)) : '' }}" />
                @else
                    <input type="date" readonly="readonly" name="dateofBirth" id="dob2"
                        placeholder="Date of Birth" class="form-control input-lg"
                        value="{{ old('dateOfBirth') }}" />
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Place of Birth <span class="text-danger"><big>*</big></span></label>
                @if ($staffInfo !== '')
                    <select type="text" id="states" name="placeofBirth" class="formex form-control input-lg"
                        required>
                        <option value="">Select State</option>
                        @foreach ($StateList as $b)
                            <option value="{{ $b->StateID }}"
                                {{ $staffInfo->placeofbirth == $b->StateID || old('state') == $b->StateID ? 'selected' : '' }}>
                                {{ $b->State }} </option>
                        @endforeach
                    </select>
                @else
                    <select type="text" id="states" name="placeofBirth" class="formex form-control input-lg"
                        required>

                        <option value="">Select State</option>
                        @foreach ($StateList as $b)
                            <option value="{{ $b->StateID }}" {{ old('state') == $b->StateID ? 'selected' : '' }}>
                                {{ $b->State }} </option>
                        @endforeach
                    </select>


                @endif
            </div>
        </div>


        <p>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employment Type<span class="text-danger"><big>*</big></span></label>

                        @if ($staffInfo !== '')
                            <select type="text" id="hremploymentType" name="hremploymentType"
                                class="formex form-control input-lg" required>
                                <option value="">Select State</option>
                                @foreach ($hrEmploymentType as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $StaffNames->hremploymentType == $b->id || old('employmentType') == $b->id ? 'selected' : '' }}
										>
                                        {{ $b->name }} </option>
                                @endforeach
                            </select>
                        @else
                            <select name="hremploymentType" id="hremploymentType" class="form-control input-lg" required>
                                <option value="">Select Employment Type</option>

                                @foreach ($hrEmploymentType as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('hremploymentType') == "$type->id" ? 'selected' : '' }}
										>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Employment Type Category<span class="text-danger"><big>*</big></span></label>

                        @if ($staffInfo !== '')
                            <select type="text" id="employmentType" name="employmentType"
                                class="formex form-control input-lg" required>
                                <option value="">Select State</option>
                                @foreach ($employmentType as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $StaffNames->employee_type == $b->id || old('employmentType') == $b->id ? 'selected' : '' }}>
                                        {{ $b->employmentType }} </option>
                                @endforeach
                            </select>
                        @else
                            <select name="employmentType" id="employmentType" class="form-control input-lg" required>
                                <option value="">Select Employment Type</option>

                                @foreach ($employmentType as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('employmentType') == "$type->id" ? 'selected' : '' }}>
                                        {{ $type->employmentType }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div> --}}
                <div class="col-md-8">
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label>Grade Level <span class="text-danger"><big>*</big></span></label>
                            <select name="grade" id="grade" class="form-control input-lg" required>
                                @if ($staffInfo != '')
                                    <option value="{{ $staffInfo->grade }}">{{ $staffInfo->grade }}</option>
                                @else
                                    <option value="">Select Grade</option>
                                @endif
                                @for ($i = 1; $i <= 17; $i++)
                                @if($i != 11)
                                    <option value="{{ $i }}" {{ old('grade') == "$i" ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endif
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Step <span class="text-danger"><big>*</big></span></label>
                            <select name="step" id="step" class="form-control input-lg" required>
                                @if ($staffInfo != '')
                                    <option value="{{ $staffInfo->step }}">{{ $staffInfo->step }}</option>
                                @else
                                    <option value="">Select Step</option>
                                @endif
                                @for ($i = 1; $i <= 15; $i++)
                                    <option value="{{ $i }}" {{ old('step') == "$i" ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Department <span class="text-danger"><big>*</big></span></label>

                        @if ($staffInfo !== '')
                            <select name="department" id="department" class="form-control input-lg" required>
                                <option value="">Select</option>
                                @foreach ($departments as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $StaffNames->departmentID == $b->id || old('department') == $b->id ? 'selected' : '' }}>
                                        {{ $b->department }} </option>
                                @endforeach
                            </select>
                        @else
                            <select name="department" id="department" class="form-control input-lg" required>
                                <option value="">Select</option>

                                @foreach ($departments as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('department') == "$type->id" ? 'selected' : '' }}>
                                        {{ $type->department }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Designation</label>
                        <select class="form-control input-lg" id="designation" name="designation" required>
                            {{-- @if (!empty($fillUpForm))
                                <option value="{{ $fillUpForm->departmentID }}">{{ $fillUpForm->designation }}
                                </option>
                            @else
                                <option value="">-No Record-</option>
                            @endif --}}

                            @foreach ($designation as $list)
                                {{-- @if ($list->id == old('designation')) --}}
                                    <option value="{{ $list->id }}"
                                        {{ $StaffNames->designationID == $list->id ? 'selected' : '' }}>
                                        {{ $list->designation }}</option>
                                {{-- @else
                                @endif --}}
                            @endforeach

                        </select>
                        <span id='processing'></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date of Appointment <span class="text-danger"><big>*</big></span></label>
                        @if ($staffInfo != '')
                            <input type="date" readonly name="presentAppointment2" id="presentAppointment1"
                                class="form-control input-lg"
                                value="{{ $staffInfo->date_present_appointment ? date('Y-m-d', strtotime($staffInfo->date_present_appointment)) : '' }}"
                                required />
                            <input type="hidden" name="presentAppointment" id="presentAppointment"
                                value="{{ $staffInfo->date_present_appointment }}">
                        @else
                            <input type="date" name="presentAppointment2" id="presentAppointment2"
                                class="form-control input-lg" value="{{ old('presentAppointment2') }}" required />
                            <input type="hidden" name="presentAppointment" id="presentAppointment"
                                value="{{ old('presentAppointment') }}" />
                        @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Date of first Appointment <span class="text-danger"><big>*</big></span></label>
                        @if ($staffInfo != '')
                            <input type="text" readonly name="firstAppointment2" id="firstAppointment1"
                                class="form-control input-lg"
                                value="{{ $staffInfo->appointment_date ? date('Y-m-d', strtotime($staffInfo->appointment_date)) : '' }}" required />
                            <input type="hidden" name="firstAppointment" id="firstAppointment"
                                value="{{ $staffInfo->appointment_date }}">
                        @else
                            <input type="date" name="firstAppointment2" id="firstAppointment2"
                                class="form-control input-lg" value="{{ old('firstAppointment2') }}" required />
                            <input type="hidden" name="firstAppointment" id="firstAppointment"
                                value="{{ old('firstAppointment') }}" />
                        @endif

                    </div>
                </div>
            </div><!--//row 2-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Effective Date of Assumption <span class="text-danger"><big>*</big></span></label>
                        @if ($staffInfo != '')
                            <input type="text" readonly name="dateofResumption2" id="dateofResumption1"
                                class="form-control input-lg"
                                value="{{ $staffInfo->resumption_date ? date('Y-m-d', strtotime($staffInfo->resumption_date)) : '' }}" required />
                            <input type="hidden" name="dateofResumption" id="dateofResumption"
                                value="{{ $staffInfo->resumption_date }}">
                        @else
                            <input type="date" name="dateofResumption2" id="dateofResumption2"
                                class="form-control input-lg" value="{{ old('dateofResumption2') }}" required />
                            <input type="hidden" name="dateofResumption" id="dateofResumption"
                                value="{{ old('dateofResumption') }}" />
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </p>
    </p>
    <hr />
    <div align="center">
        <ul class="list-inline">

            <li>
                <button type="submit" class="btn btn-primary">Save and continue</button><!--next-step-->
            </li>
        </ul>
    </div>
    </div>
</form>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {

        $("#department").change(function(e) {

            //console.log(e);
            var dept_id = e.target.value;
            // var state_id = $(this).val();

            //alert(dept_id);
            //$token = $("input[name='_token']").val();
            //ajax
            $.get('get-designation?dept_id=' + dept_id, function(data) {
                $('#designation').empty();
                //console.log(data);
                //$('#lga').append( '<option value="">Select</option>' );
                $.each(data, function(index, obj) {
                    $('#designation').append('<option value="' + obj.id + '">' + obj
                        .designation + '</option>');
                });


            })
        });


    });
</script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("input[type='date'], #dob, #dob2, #presentAppointment1, #presentAppointment2, #firstAppointment1, #firstAppointment2, #dateofResumption1, #dateofResumption2", {
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today",
            yearSelectorType: "scroll",
        });
    });
</script>

{{-- <script>
    $(document).ready(function() {
        $('input[id$=presentAppointment1]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });


    $(document).ready(function() {
        $('input[id$=presentAppointment2]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=firstAppointment1]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=firstAppointment2]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=dob]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=dob2]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });
</script> --}}
