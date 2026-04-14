@extends('layouts.layout')
@section('pageTitle')
    VAT And WHT Payee
@endsection

@section('content')
    <div class="box-body">
        <div class="box box-default">
            <div class="box-body box-profile">
                <div class="box-header with-border hidden-print text-uppercase">
                    <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
                </div>
                <div class="box box-success">
                    <div class="box-body">
                        @include('funds.Share.message')
                        <form class="form-horizontal" role="form" action="{{ url('/vat-wht-payee') }}" method="Post">
                            {{ csrf_field() }}
                            <!--hidden field for updating record-->
                            @if (!empty($payeeRecord))
                                <input type="hidden" class="form-control" name="updateID" value="{{ $payeeRecord->ID }}" />
                            @else
                                <input type="hidden" class="form-control" name="updateID" />
                            @endif

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">Payee</label>
                                    @if (!empty($payeeRecord))
                                        <input type="text" class="form-control" id="payee" name="payee"
                                            placeholder="Enter Payee" value="{{ $payeeRecord->payee }}" />
                                    @else
                                        <input type="text" class="form-control" id="payee" name="payee"
                                            placeholder="Enter Payee" />
                                    @endif

                                </div>


                                <div class="col-md-4">
                                    <label class="control-label">Address</label>
                                    @if (!empty($payeeRecord))
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address" value="{{ $payeeRecord->address }}">
                                    @else
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address">
                                    @endif

                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank Branch</label>
                                    @if (!empty($payeeRecord))
                                        <input type="text" class="form-control" id="bank_branch" name="bank_branch"
                                            placeholder="Enter bank" value="{{ $payeeRecord->bank_branch }}">
                                    @else
                                        <input type="text" class="form-control" id="bank_branch" name="bank_branch"
                                            placeholder="Enter bank">
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank</label>
                                    <select class="form-control" id="bankid" name="bankid">
                                        @if (!empty($getBankNameID))
                                            <option value="{{ $getBankNameID->bankID }}">
                                                {{ $getBankNameID->bank }}
                                            </option>
                                        @else
                                            <option value="">--Please choose an option--</option>
                                        @endif
                                        @forelse($banklist as $list)
                                            <option value="{{ $list->bankID }}">{{ $list->bank }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Account Number</label>
                                    @if (!empty($payeeRecord))
                                        <input type="text" class="form-control" id="accountno" name="accountno"
                                            placeholder="Enter acct no" value="{{ $payeeRecord->accountno }}">
                                    @else
                                        <input type="text" class="form-control" id="accountno" name="accountno"
                                            placeholder="Enter acct no">
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Sort Code</label>
                                    @if (!empty($payeeRecord))
                                        <input type="text" class="form-control" id="sort_code" name="sort_code"
                                            placeholder="Enter sort code" value="{{ $payeeRecord->sort_code }}">
                                    @else
                                        <input type="text" class="form-control" id="sort_code" name="sort_code"
                                            placeholder="Enter sort code">
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <br>

                                    @if (!empty($payeeRecord))
                                        <button type="submit" class="btn btn-primary" name="add" value="submit">
                                            <i class="fa fa-btn fa-floppy-o"></i> Update Record
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success" name="add" value="submit">
                                            <i class="fa fa-btn fa-floppy-o"></i> Add New Record
                                        </button>
                                    @endif

                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- ========================= TABLE CARD ========================= -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title text-uppercase">VAT And WHT Payee List</h4>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive" style="font-size: 12px; padding:10px;">
                            <table id="mytable" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th> S/N</th>
                                        <th>Payee</th>
                                        <th>Address</th>
                                        <th>Bank Branch</th>
                                        <th>Bank</th>
                                        <th>Account Number</th>
                                        <th>Sort code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php $i=1;@endphp
                                @foreach ($getDB as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->payee }} <br> 
                                            <span class="label label-{{ $list->payee_status == 1 ? 'success' : 'danger' }}">{{ $list->payee_status == 1 ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>{{ $list->address }}</td>
                                        <td>{{ $list->bank_branch }}</td>
                                        <td>{{ $list->bank }}</td>
                                        <td>{{ $list->accountno }}</td>
                                        <td>{{ $list->sort_code }}</td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-danger btn-sm"
                                                href="{{ url('/vat-wht-payee/delete/' . $list->ID) }}"
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="glyphicon glyphicon-trash"></i> Delete
                                            </a>
                                            <a style="cursor: pointer;" class="btn btn-primary btn-sm"
                                                href="{{ url('/edit-vat-wht-for-payee/' . $list->ID) }}">Edit
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        .modal-dialog {
            width: 10cm
        }

        .modal-header {

            background-color: #006600;

            color: #FFF;

        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable();
        });
    </script>
@endsection
