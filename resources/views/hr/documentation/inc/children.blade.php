

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title text-success text-center">
            <i class="glyphicon glyphicon-envelope"></i> <b>Children</b>
        </h3>

    </div>

    <div class="panel-body">
        <form action="{{ url('/documentation-children') }}" method="POST">
            {{ csrf_field() }}

            {{-- Row 1 --}}
            <div class="row">
                <div class="col-md-4">
                    {{-- <label>Fullname</label>
                    <input class="form-control input-md" name="fullname[]"
                        value="{{ !empty($children[0]) ? $children[0]->fullname : old('fullname') }}"> --}}
                    @if (!empty($children[0]))
                        <label>Fullname</label>

                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ $children[0]->fullname }}">
                    @else
                        <label>Fullname</label>
                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ old('fullname') }}">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Date of Birth</label>
                    <input class="form-control input-md" name="childDateOfBirth[]"
                        value="{{ !empty($children[0]) ? date('d-m-Y', strtotime($children[0]->dateofbirth)) : old('childDateOfBirth[]') }}"> --}}

                    @if (!empty($children[0]))
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirthb"
                            value="{{ date('d-m-Y', strtotime($children[0]->dateofbirth)) }}"
                            class="form-control input-md">
                    @else
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirth2b"
                            value="{{ old('childDateOfBirth[]') }}" class="form-control input-md">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Gender</label>
                    <select class="form-control input-md" name="gender[]">
                        <option value="">Select</option>
                        <option {{ !empty($children[0]) && $children[0]->gender == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option {{ !empty($children[0]) && $children[0]->gender == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select> --}}

                    @if (!empty($children[0]))
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-md" value="">
                            <option value="" selected>Select</option>
                            <option {{ $children[0]->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                            </option>
                            <option {{ $children[0]->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                            </option>
                        </select>
                    @else
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-md" value="">
                            <option value="" selected>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    @endif
                </div>
            </div>

            <br>

            {{-- Row 2 --}}
            <div class="row">
                <div class="col-md-4">
                    {{-- <label>Fullname</label>
                    <input class="form-control input-md" name="fullname[]"
                        value="{{ !empty($children[1]) ? $children[1]->fullname : old('fullname') }}"> --}}
                    @if (!empty($children[1]))
                        <label>Fullname</label>

                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ $children[1]->fullname }}">
                    @else
                        <label>Fullname</label>
                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ old('fullname') }}">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Date of Birth</label>
                    <input class="form-control input-md" name="childDateOfBirth[]"
                        value="{{ !empty($children[1]) ? date('d-m-Y', strtotime($children[1]->dateofbirth)) : old('childDateOfBirth[]') }}"> --}}

                    @if (!empty($children[1]))
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirtha"
                            value="{{ date('d-m-Y', strtotime($children[1]->dateofbirth)) }}"
                            class="form-control input-md">
                    @else
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirth2a"
                            value="{{ old('childDateOfBirth[]') }}" class="form-control input-md">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Gender</label>
                    <select class="form-control input-md" name="gender[]">
                        <option value="">Select</option>
                        <option {{ !empty($children[1]) && $children[1]->gender == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option {{ !empty($children[1]) && $children[1]->gender == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select> --}}

                    @if (!empty($children[1]))
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-md" value="">
                            <option value="" selected>Select</option>
                            <option {{ $children[1]->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                            </option>
                            <option {{ $children[1]->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                            </option>
                        </select>
                    @else
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-md" value="">
                            <option value="" selected>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    @endif
                </div>
            </div>

            <br>

            {{-- Row 3 --}}
            <div class="row">
                <div class="col-md-4">
                    {{-- <label>Fullname</label> --}}
                    {{-- <input class="form-control input-md" name="fullname[]"
                        value="{{ !empty($children[2]) ? $children[2]->fullname : old('fullname') }}"> --}}

                    @if (!empty($children[2]))
                        <label>Fullname</label>

                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ $children[2]->fullname }}">
                    @else
                        <label>Fullname</label>
                        <input class="form-control input-md" id="fullname" name="fullname[]"
                            value="{{ old('fullname') }}">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Date of Birth</label>
                    <input class="form-control input-md" name="childDateOfBirth[]"
                        value="{{ !empty($children[2]) ? date('d-m-Y', strtotime($children[2]->dateofbirth)) : old('childDateOfBirth[]') }}"> --}}

                    @if (!empty($children[2]))
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirthy"
                            value="{{ date('d-m-Y', strtotime($children[2]->dateofbirth)) }}"
                            class="form-control input-md">
                    @else
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirth2y"
                            value="{{ old('childDateOfBirth[]') }}" class="form-control input-md">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Gender</label>
                    <select class="form-control input-md" name="gender[]">
                        <option value="">Select</option>
                        <option {{ !empty($children[2]) && $children[2]->gender == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option {{ !empty($children[2]) && $children[2]->gender == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select> --}}

                    @if (!empty($children[2]))
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-lg" value="">
                            <option value="" selected>Select</option>
                            <option {{ $children[2]->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                            </option>
                            <option {{ $children[2]->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                            </option>
                        </select>
                    @else
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-lg" value="">
                            <option value="" selected>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    @endif
                </div>
            </div>

            <br>

            {{-- Row 4 --}}
            <div class="row">
                <div class="col-md-4">
                    {{-- <label>Fullname</label>
                    <input class="form-control input-md" name="fullname[]"
                        value="{{ !empty($children[3]) ? $children[3]->fullname : old('fullname') }}"> --}}

                    @if (!empty($children[3]))
                        <label>Fullname</label>

                        <input class="form-control input-lg" id="fullname" name="fullname[]"
                            value="{{ $children[3]->fullname }}">
                    @else
                        <label>Fullname</label>
                        <input class="form-control input-lg" id="fullname" name="fullname[]"
                            value="{{ old('fullname') }}">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Date of Birth</label>
                    <input class="form-control input-md" name="childDateOfBirth[]"
                        value="{{ !empty($children[3]) ? date('d-m-Y', strtotime($children[3]->dateofbirth)) : old('childDateOfBirth[]') }}"> --}}

                    @if (!empty($children[3]))
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirthx"
                            value="{{ date('d-m-Y', strtotime($children[3]->dateofbirth)) }}"
                            class="form-control input-lg">
                    @else
                        <label>Date of Birth</label>
                        <input name="childDateOfBirth[]" id="childDateOfBirth2x"
                            value="{{ old('childDateOfBirth[]') }}" class="form-control input-lg">
                    @endif
                </div>

                <div class="col-md-4">
                    {{-- <label>Gender</label>
                    <select class="form-control input-md" name="gender[]">
                        <option value="">Select</option>
                        <option {{ !empty($children[3]) && $children[3]->gender == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option {{ !empty($children[3]) && $children[3]->gender == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select> --}}

                    @if (!empty($children[3]))
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-lg" value="">
                            <option value="" selected>Select</option>
                            <option {{ $children[3]->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                            </option>
                            <option {{ $children[3]->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                            </option>
                        </select>
                    @else
                        <label>Gender</label>
                        <select name="gender[]" id="childGender" class="form-control input-lg" value="">
                            <option value="" selected>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    @endif
                </div>
            </div>

            <hr>

            <div class="text-center">
                <a href="{{ url('/documentation-nextofkin') }}" class="btn btn-default">Previous</a>
                <button type="submit" class="btn btn-primary">Save and Continue</button>
            </div>
        </form>
    </div>
</div>

<styles>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

</styles>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

{{-- <script>
  $(document).ready(function () {
        $('input[id$=childDateOfBirthx]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirth2x]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirth2y]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirthy]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirtha]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirth2a]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirthb]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

  $(document).ready(function () {
        $('input[id$=childDateOfBirth2b]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });

</script> --}}

<script>
    $(document).ready(function() {
        // Common datepicker configuration
        const datePickerConfig = {
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
            changeMonth: true,
            changeYear: true,
            showMonthAfterYear: true,
            maxDate: '0',
            beforeShow: function(input, inst) {
                // Ensure the calendar appears above other elements
                inst.dpDiv.css({
                    marginTop: '-1px',
                    zIndex: 1000
                });
            },
            onClose: function(dateText, inst) {
                // Validate date format
                if (dateText) {
                    try {
                        $.datepicker.parseDate('dd-mm-yy', dateText);
                    } catch (e) {
                        $(this).val('');
                        alert('Please use the date picker to select a valid date');
                    }
                }
            }
        };

        // Apply datepicker to all date inputs
        $('input[id^=childDateOfBirth]').each(function() {
            $(this).datepicker(datePickerConfig);
        });
    });
</script>
