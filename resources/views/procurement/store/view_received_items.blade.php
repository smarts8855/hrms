@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Item') }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap 3 panel (card) starts -->
                <div class="panel panel-default">
                    <div class="panel-heading text-center" style="font-size:18px; font-weight:bold;">
                        @if ($contract)
                            List of items received from {{ $contract->company_name ?? 'N/A' }}
                        @else
                            No contract found
                        @endif
                    </div>



                    <div class="panel-body">
                        @if ($items->isEmpty())
                            <p class="text-center">No items received yet for this contract.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item Name</th>
                                        <th>Supply Quantity</th>
                                        <th>Received Quantity</th>
                                        <th>Received Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp

                                    @foreach ($items as $item)
                                        @php
                                            $approvedQty = $item->approvedQuantity ?? 0;
                                            $pendingQty = $item->totalQuantity - $approvedQty;
                                        @endphp

                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            <td style="width: 30%">
                                                {{ $item->itemName . " - " }}

                                                @if ($item->specifications->isNotEmpty())


                                                    {{-- First specification --}}
                                                    <span class="label label-success">
                                                        {{ $item->specifications->first() }}
                                                    </span>

                                                    {{-- If more specifications exist --}}
                                                    @if ($item->specifications->count() > 1)
                                                        <span class="label label-info" data-toggle="modal"
                                                            data-target="#specModal{{ $item->id }}"
                                                            style="cursor:pointer; margin-left:6px;">
                                                            View more
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>

                                            <td>{{ $item->totalQuantity }}</td>
                                            <td>{{ $approvedQty }}</td>
                                            <td>₦{{ number_format($item->approved_total_price, 2) }}</td>

                                            <td>
                                                @if ($approvedQty > 0 && $pendingQty > 0)
                                                    <button class="btn btn-warning btn-sm edit-modal"
                                                        data-id="{{ $item->id }}">
                                                        Pending ({{ $pendingQty }})
                                                    </button>
                                                @elseif ($item->status == 1)
                                                    <button class="btn btn-primary btn-sm edit-modal"
                                                        data-id="{{ $item->id }}">
                                                        Receive
                                                    </button>
                                                @elseif ($item->status == 2)
                                                    <span class="text-success font-weight-bold">Received</span>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Specifications Modal --}}
                                        @if ($item->specifications->count() > 1)
                                            <div class="modal fade" id="specModal{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                Specifications for {{ $item->itemName }}
                                                            </h4>

                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            @foreach ($item->specifications as $spec)
                                                                <span class="label label-success" style="margin:3px;">
                                                                    {{ $spec }}
                                                                </span>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        @endif

                        <div id="dynamicModalContainer"></div>

                        <div class="text-center" style="margin-top: 20px;">
                            <a href="{{ route('assign.items') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Back to Assigned Contracts
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Bootstrap 3 panel (card) ends -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on("click", ".edit-modal", function() {
            let id = $(this).data("id");
            $.ajax({
                url: `/get-approve-modal/${id}`,
                type: "GET",
                success: function(response) {
                    $("#dynamicModalContainer").html(response);
                    $("#approveModal" + id).modal("show");
                },
                error: function() {
                    alert("Error loading modal.");
                }
            });
        });
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @elseif (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        @endif
    </script>
    {{-- <script>
        function toggleSpecs(id) {
            let el = document.getElementById('specs-' + id);

            if (el.style.display === "none") {
                el.style.display = "block";
            } else {
                el.style.display = "none";
            }
        }
    </script> --}}
@endsection
