@extends('layouts_procurement.app')
@section('pageTitle', 'View Submitted Needs')
@section('pageMenu', 'active')
@section('content')



    <div class="panel panel-default" style="background:#FFF;">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    @include('ShareView.operationCallBackAlert')
                </div>

                <div class="col-md-12">

                    <!-- HEADER CARD -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title">
                                        <i class="fa fa-file-text"></i> <b>View Submitted Needs</b>
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span style="font-size: 14px;">
                                        <i class="fa fa-list"></i>
                                        Total Needs Titles: {{ $getList->count() }}
                                    </span>
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

                    <!-- TABLE CARD -->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background:#f5f5f5;">
                            <h4 class="panel-title"><b>Needs Titles List</b></h4>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>NEEDS TITLE</th>
                                            <th>DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @forelse($getList as $list)
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td class="font-weight-bold">{{ $list->title }}</td>
                                                <td>{{ date('d-m-Y', strtotime($list->date)) }}</td>
                                                <td>
                                                    <a href="categorised-needs-assessment/{{ base64_encode($list->needs_titleID) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fa fa-eye"></i> View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center" style="padding: 40px;">
                                                    <i class="fa fa-folder-open fa-3x text-muted"></i>
                                                    <h4 class="text-danger">No Submitted Needs Found</h4>
                                                    <p class="text-muted">There are no needs titles available to view.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- PAGINATION -->
                        @if ($getList instanceof \Illuminate\Pagination\AbstractPaginator && $getList->hasPages())
                            <div class="panel-footer" style="background:#fafafa;">
                                <div class="row">
                                    <div class="col-md-6 text-muted">
                                        Showing {{ ($getList->currentpage() - 1) * $getList->perpage() + 1 }}
                                        to {{ $getList->currentpage() * $getList->perpage() }}
                                        of {{ $getList->total() }} entries
                                    </div>

                                    <div class="col-md-6">
                                        <div class="text-right">
                                            {{ $getList->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> <!-- END TABLE CARD -->

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
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endsection
