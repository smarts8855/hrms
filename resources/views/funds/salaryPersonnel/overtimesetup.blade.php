@extends('layouts.layout')

@section('content')
    <div style="margin: 20px">

        <h3 class="text-center"><b>OVERTIME SETUP</b></h3>

        {{-- ================= ALERTS ================= --}}
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif

        @if (session('err'))
            <div class="alert alert-danger">{{ session('err') }}</div>
        @endif

        {{-- ================= ADD FORM ================= --}}
        <div class="panel panel-default">
            <div class="panel-heading"><b>Add / Update Overtime</b></div>

            <div class="panel-body">
                <form method="POST" action="{{ url('/update-staff-overtime-setup') }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-3">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" placeholder="e.g. Special, Normal"
                                required>
                        </div>

                        <div class="col-md-3">
                            <label>Hours</label>
                            <input type="number" name="hrs" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <label>Percentage</label>
                            <input type="text" name="percentage" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <label>Months</label>
                            <input type="number" name="months" class="form-control" required>
                        </div>

                        <div class="col-md-2" style="margin-top:25px">
                            <button class="btn btn-success btn-block">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="panel panel-default">
            <div class="panel-heading"><b>Existing Overtime Setup</b></div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Hours</th>
                            <th>Percentage</th>
                            <th>Months</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($setup as $key => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->hrs }}</td>
                                <td>{{ $row->percentage }}</td>
                                <td>{{ $row->months }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs editBtn" data-id="{{ $row->id }}"
                                        data-description="{{ $row->description }}" data-hrs="{{ $row->hrs }}"
                                        data-percentage="{{ $row->percentage }}" data-months="{{ $row->months }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function() {

                document.querySelector('[name=description]').value = this.dataset.description;
                document.querySelector('[name=hrs]').value = this.dataset.hrs;
                document.querySelector('[name=percentage]').value = this.dataset.percentage;
                document.querySelector('[name=months]').value = this.dataset.months;

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
