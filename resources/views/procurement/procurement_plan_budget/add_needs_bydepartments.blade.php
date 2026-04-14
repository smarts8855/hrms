@extends('layouts_procurement.app')
@section('pageTitle', 'Submit Needs')
@section('pageMenu', 'active')
@section('content')



    <div class="panel panel-default">
        <div class="panel-body" style="background:#FFF;">
            <div class="row">
                <div class="col-md-12">
                    @include('ShareView.operationCallBackAlert')
                </div>

                <div class="col-md-12">
                    <div class="panel-heading" style="border-bottom: 1px solid #ddd; margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="panel-title" style="font-size:18px; text-transform: uppercase;">
                                    <b>Submit Needs Assessment</b>
                                </h3>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 style="font-size: 14px; margin-top:5px;">
                                    <i class="fa fa-list"></i> Available Needs Titles
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="text-center">
                                <hr>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-bordered">
                                    <thead class="text-gray-b">
                                        <tr>
                                            <th>S/N</th>
                                            <th>TITLE</th>
                                            <th>DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n = 1; @endphp
                                        @forelse ($getList as $list)
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td class="font-weight-bold">{{ $list->title }}</td>
                                                <td>{{ date('jS M, Y', strtotime($list->date)) }}</td>
                                                <td>
                                                    @if ($list->status == 1)
                                                        <a href="submit-needs-assessment/{{ base64_encode($list->needs_titleID) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fa fa-edit"></i> Submit Needs
                                                        </a>
                                                    @else
                                                        <span class="label label-default">Closed</span>
                                                    @endif
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <img src="/images/folder.jpeg" alt="" width="120px"
                                                            height="120px">
                                                        <h5 class="text-center text-danger" style="margin-top: 15px;">
                                                            <i>
                                                                <span class="text-danger">***</span>
                                                                Please contact Procurement Unit to open needs
                                                                <span class="text-danger">***</span>
                                                            </i>
                                                        </h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div> <!-- inner panel -->
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
