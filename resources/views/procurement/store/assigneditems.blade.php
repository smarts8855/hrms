@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Assigned Contract') }}
@endsection
@section('pageMenu', 'active')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {{-- @include('procurement.ShareView.operationCallBackAlert') --}}

                <!-- Panel Heading -->
                <div class="panel-heading text-center" style="font-size: 18px; font-weight: bold;">
                    Assigned Contract
                </div>

                <!-- Panel Body -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="datatable-buttonsx">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Lot No / Sublot No</th>
                                    <th>Contractor Name</th>
                                    <th>Contractor Address</th>
                                    <th>Email / phone No</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php $n = ($assigned->currentPage() - 1) * $assigned->perPage() + 1; @endphp
                            <tbody>
                                @foreach ($assigned as $list)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->contract_name }}</td>
                                        <td>{{ $list->contract_description }}</td>
                                        <td>{{ $list->lot_number }} / {{ $list->sublot_number }}</td>
                                        <td>{{ $list->company_name }}</td>
                                        <td>{{ $list->address }}</td>
                                        <td style="width: 150px">
                                            {{ $list->email_address }} / {{ $list->phone_number }}
                                        </td>
                                        <td class="text-center">
                                            <!-- Always show Add Items button regardless of status -->
                                            <a href="{{ route('store.itemInputPage', $list->store_id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-plus"></i> Add Items
                                            </a>

                                            <!-- View Items button -->
                                            {{-- <a href="{{ route('contracts.received-items.view', $list->store_id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View Items
                                            </a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="text-right" style="margin-top: 10px;">
                        {{ $assigned->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('styles')
    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }

        .btn-sm {
            margin: 2px;
        }
    </style>
@endsection
