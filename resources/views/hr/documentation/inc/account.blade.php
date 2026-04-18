{{-- <form action="{{ url('/documentation-account') }}" method="POST">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step2">
        <div class="col-md-offset-0">
            <h3 class="text-success text-center">
                <i class="glyphicon glyphicon-user"></i> <b>Account Information</b>
            </h3>

        </div>
        <br />
        <p>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Name <span class="text-danger"><big>*</big></span></label>
                            @if ($staffInfo !== '')
                                <select required type="text" id="bankName" name="bankName"
                                    class="form-control input-lg" required>
                                    <option value="">Select Bank</option>
                                    @foreach ($BankList as $b)
                                        <option value="{{ $b->bankID }}"
                                            {{ $staffInfo->bankID == $b->bankID || old('bankName') == $b->bankID ? 'selected' : '' }}>
                                            {{ $b->bank }} </option>
                                    @endforeach
                                </select>
                            @else
                                <select required type="text" id="bankName" name="bankName"
                                    class="form-control input-lg">
                                    <option>Select State</option>
                                    @foreach ($BankList as $b)
                                        <option value="{{ $b->bankID }}"
                                            {{ old('bankName') == $b->bankID ? 'selected' : '' }}>{{ $b->bankID }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Account Number <span class="text-danger"><big>*</big></span></label>
                            @if ($staffInfo !== '')
                                <input type="number" name="accountNumber" class="form-control input-lg" required
                                    value="{{ $staffInfo->AccNo }}">
                            @else
                                <input type="number" name="accountNumber" class="form-control input-lg" required
                                    value="{{ old('accountNumber') }}">
                            @endif
                        </div>
                    </div>

                </div>
            </div><!--//row 2-->
        </div>
        </p>
        <hr />
        <div align="center">
            <ul class="list-inline">
                <li>
                    <a href="{{ url('/staff-documentation-attachment') }}" class="btn btn-default">Previous</a>
                </li>
                <li>
                    <button type="submit" class="btn btn-primary">Save and continue</button><!--next-step-->
                </li>
            </ul>
        </div>
    </div>
</form> --}}

<form action="{{ url('/documentation-account') }}" method="POST">
    {{ csrf_field() }}

    <div class="tab-pane" role="tabpanel" id="step2">

        <!-- Card Wrapper -->
        <div class="col-md-12">

            <div class="panel panel-primary">

                <!-- Card Header -->
                <div class="panel-heading">
                    <h3 class="panel-title text-center">
                        <i class="glyphicon glyphicon-user"></i>
                        <b>Account Information</b>
                    </h3>
                </div>

                <!-- Card Body -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Bank Name

                                </label>

                                @if ($staffInfo !== '')
                                    <select id="bankName" name="bankName" class="form-control input-md" required>
                                        <option value="">Select Bank</option>
                                        @foreach ($BankList as $b)
                                            <option value="{{ $b->bankID }}"
                                                {{ $staffInfo->bankID == $b->bankID || old('bankName') == $b->bankID ? 'selected' : '' }}>
                                                {{ $b->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select id="bankName" name="bankName" class="form-control input-md" required>
                                        <option value="">Select Bank</option>
                                        @foreach ($BankList as $b)
                                            <option value="{{ $b->bankID }}"
                                                {{ old('bankName') == $b->bankID ? 'selected' : '' }}>
                                                {{ $b->bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Account Number

                                </label>

                                @if ($staffInfo !== '')
                                    <input type="number" name="accountNumber" class="form-control input-md" required
                                        value="{{ $staffInfo->AccNo }}">
                                @else
                                    <input type="number" name="accountNumber" class="form-control input-md" required
                                        value="{{ old('accountNumber') }}">
                                @endif
                            </div>

                        </div>
                    </div> <!-- end row -->

                </div> <!-- end panel-body -->

                <!-- Card Footer -->
                <div class="panel-footer text-center">
                    <ul class="list-inline">
                        <li>
                            <a href="{{ url('/staff-documentation-attachment') }}" class="btn btn-default">
                                Previous
                            </a>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary">
                                Save and Continue
                            </button>
                        </li>
                    </ul>
                </div>

            </div><!-- panel -->

        </div><!-- col -->

    </div><!-- tab-pane -->

</form>
