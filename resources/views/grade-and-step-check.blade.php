@extends('layouts.loginlayout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading">Compare File Number, Grade and Step in Database with Excel</div>
                    <div class="panel-body">
                        <form action="/grade-and-step-check" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <input type="file" name="file" required class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-sign-in"></i> Upload
                            </button>
                        </form>

                        <hr>
                        @if (isset($mismatches) && count($mismatches) > 0)
                            <h3>Results</h3>
                            <p>Total rows checked: {{ $total_checked }}</p>
                            <p>Total mismatches: {{ count($mismatches) }}</p>

                            <div class="mb-3">
                                <button class="btn btn-primary" onclick="window.print()">Print Results</button>
                            </div>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>File Number</th>
                                        <th>Staff Name</th>
                                        <th>Excel Grade</th>
                                        <th>Excel Step</th>
                                        <th>DB Grade</th>
                                        <th>DB Step</th>
                                        <th>Issue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mismatches as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row['file_number'] }}</td>
                                            <td>{{ $row['staff_name'] ?? '-' }}</td>
                                            <td>{{ $row['excel_grade'] }}</td>
                                            <td>{{ $row['excel_step'] }}</td>
                                            <td>{{ $row['db_grade'] ?? '-' }}</td>
                                            <td>{{ $row['db_step'] ?? '-' }}</td>
                                            <td>{{ $row['issue'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            @if ($json_file)
                                <p>JSON saved for review: <a href="{{ asset($json_file) }}"
                                        target="_blank">{{ $json_file }}</a></p>
                            @endif
                        @elseif(isset($mismatches))
                            <div class="alert alert-success">All records match the database!</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
