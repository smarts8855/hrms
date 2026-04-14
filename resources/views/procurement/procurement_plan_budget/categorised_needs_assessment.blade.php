@extends('layouts_procurement.app')
@section('pageTitle', 'Submitted Needs')
@section('pageMenu', 'active')
@section('content')



    <div class="panel panel-default" style="background:#FFF;">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    @include('ShareView.operationCallBackAlert')
                </div>

                <div class="col-md-12">

                    <!-- Header -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title">
                                        <i class="fa fa-file-text"></i> <b>Submitted Needs by Department</b>
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('get-all-needs') }}" class="btn btn-outline-primary btn-sm"
                                        style="color: #fff;">
                                        <i class="fa fa-list"></i> View All Submitted Needs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="row hidden-print">
                        <div class="col-md-12 text-center">
                            <hr>
                        </div>
                    </div>

                    <!-- Title Section Card -->
                    <div class="panel panel-default" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom:15px;">
                        <div class="panel-body" style="background:#f5f5f5;">
                            <h4 class="text-primary" style="margin:0;">
                                <i class="fa fa-file-text"></i>
                                {{ $title->title ?? 'N/A' }} for {{ date('d-m-Y', strtotime($title->date ?? '')) }}
                            </h4>
                        </div>
                    </div>

                    <!-- Table Card -->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background:#f5f5f5;">
                            <h4 class="panel-title"><b>Department Submissions</b></h4>
                        </div>

                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>DEPARTMENT</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @forelse($getList as $list)
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            {{-- <td class="font-weight-bold">{{ $list->department }}</td> --}}
                                            <td class="font-weight-bold">{{ $list->department ?? 'N/A' }}</td>

                                            <td>
                                                <a href="/view-needs/{{ base64_encode($list->departmentID) }}"
                                                    target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center" style="padding:40px;">
                                                <i class="fa fa-building fa-3x text-muted mb-3"></i>
                                                <h4 class="text-danger">No Department Submissions</h4>
                                                <p class="text-muted">No departments have submitted needs for this title
                                                    yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($getList instanceof \Illuminate\Pagination\AbstractPaginator && $getList->hasPages())
                            <div class="panel-footer" style="background:#fafafa;">
                                <div class="row">
                                    <div class="col-md-6 text-muted">
                                        Showing {{ ($getList->currentpage() - 1) * $getList->perpage() + 1 }}
                                        to {{ $getList->currentpage() * $getList->perpage() }}
                                        of {{ $getList->total() }} entries
                                    </div>
                                    <div class="col-md-6 text-right">
                                        {{ $getList->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> <!-- END Table Card -->

                </div>
            </div>

        </div>
    </div>


@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: #2c3e50;
            font-weight: 600;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endsection
