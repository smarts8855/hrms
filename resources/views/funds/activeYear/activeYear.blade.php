@extends('layouts.layout')
@section('pageTitle')
    Active Year
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <div class="col-md-12">
                @include('funds.Share.message')
            </div>
            <div class="box-body">
                <div class="box box-default">
                    <div class="box-body box-profile">
                        <div class="box-body hidden-print">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <form class="form-horizontal" role="form" action="{{ url('/active-year') }}"
                                        method="Post">
                                        {{ csrf_field() }}
                                        <div class="">
                                            <h4 class="box-title">Active Year Setup</h4>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Contract Type</label>
                                                <select class="form-control" id="contractType" name="contractType">
                                                    <option value=''>-Select Contract Type-</option>
                                                    @foreach ($contracttype as $con)
                                                        <option value="{{ $con->ID }}"
                                                            {{ $currentContract == $con->ID ? 'selected' : '' }}>
                                                            {{ $con->contractType }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">Year</label>
                                                <select class="form-control" id="yearList" name="year">
                                                    <option value=''>-Select Year-</option>
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}"
                                                            {{ $currentYear == $year ? 'selected' : '' }}> {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-md-4">
                                                <br>
                                                <button type="submit" class="btn btn-success" name="add">
                                                    <i class="fa fa-btn fa-floppy-o"></i> Add New
                                                </button>

                                            </div>

                                        </div>



                                        <div class="table-responsive" style="font-size: 12px; padding:10px;">
                                            <table id="myTable"
                                                class="table table-bordered table-striped table-highlight">
                                                <thead>
                                                    <tr bgcolor="#c7c7c7">


                                                        <th> S/N</th>
                                                        <th>Contract</th>
                                                        <th>Year</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                @php $i=1;@endphp
                                                @foreach ($contractTable as $list)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $list->contractType }}</td>
                                                        <td>{{ $list->year }}</td>

                                                        <td>
                                                            <a style="color: blue; cursor: pointer;"
                                                                href="{{ url('/active-year/delete/' . $list->periodID) }}"
                                                                onclick="return confirm('Are you sure you want to delete this item?');">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>

                                        </div>
                                    </form>

                                </div>
                            </div>
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
                $('#myTable').DataTable();


            });
        </script>
    @endsection
