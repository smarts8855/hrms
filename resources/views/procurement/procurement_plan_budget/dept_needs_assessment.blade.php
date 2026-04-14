@extends('layouts_procurement.app')
@section('pageTitle', 'Search Submitted Needs')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
                </div>

                <div class="panel-body">
                    <form class="formFormatAmount" method="POST" action="{{ route('needs.report') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-uppercase">Category</label>
                                <select name="category" class="form-control">
                                    <option value="">Select</option>
                                    @if (isset($getCategory) && $getCategory)
                                        @foreach ($getCategory as $key => $value)
                                            <option value="{{ $value->categoryID }}"
                                                {{ (string) $value->categoryID === (string) old('category', request('category')) ? 'selected' : '' }}>
                                                {{ $value->category }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-uppercase">Department </label>
                                <select name="department" class="form-control">
                                    <option value="">Select</option>
                                    @if (isset($getDepartment) && $getDepartment)
                                        @foreach ($getDepartment as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ (string) $value->id === (string) old('department', request('department')) ? 'selected' : '' }}>
                                                {{ $value->department }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 text-right">
                                <button class="btn btn-primary btn-sm">
                                    <i class="glyphicon glyphicon-search"></i> Search
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            @include('ShareView.operationCallBackAlert')
        </div>

        <div class="col-md-12">

            <!-- TABLE CARD -->
            <div class="panel panel-default">
                <div class="panel-heading" style="background:#f5f5f5;">
                    <h4 class="panel-title"><b>Submitted Needs Report</b></h4>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        @if (isset($getList) && $getList->count())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Item</th>
                                        <th class="text-right text-uppercase">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getList as $row)
                                        <tr class="text-uppercase">
                                            <td>{{ $row->item }}</td>
                                            <td class="text-right">{{ $row->total_quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="1" class="text-right text-uppercase">Grand Total</th>
                                        <th class="text-right">{{ $grandTotal }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <div class="alert alert-info">No record found for your search.</div>
                        @endif
                    </div>
                </div>
            </div> <!-- END TABLE CARD -->

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
