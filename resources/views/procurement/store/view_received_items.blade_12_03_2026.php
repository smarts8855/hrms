@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Item') }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if ($contract)
                                        <h1>List of items received from {{ $contract->company_name ?? 'N/A' }}</h1>
                                    @else
                                        <p>No contract found </p>
                                    @endif
                                </div>
                            </div>
                            <hr>

                            @if ($items->isEmpty())
                                <p>No items received yet for this contract.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Name</th>
                                            <th>Specification</th>
                                            <th>Received Quantity</th>
                                            <th>Approved Quantity</th>
                                            <th>Approved Total Price</th>
                                            <th>Action</th>
                                            {{-- <th>Created At</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->itemName }}</td>
                                                <td>{{ $item->specificationName }}</td>
                                                <td>{{ $item->totalQuantity }}</td>
                                                <td>{{ $item->approvedQuantity }}</td>
                                                <td>{{ $item->approved_total_price }}</td>
                                                {{-- <td>

                                                    @if ($item->status == 1)
                                                        <button class="btn btn-primary btn-sm edit-modal"
                                                            data-id="{{ $item->id }}">
                                                            Approve
                                                        </button>
                                                    @else
                                                        <span class="text-muted">Approved</span>
                                                    @endif

                                                </td> --}}
                                                <td>
                                                    @php
                                                        $approvedQty = $item->approvedQuantity ?? 0;
                                                        $pendingQty = $item->totalQuantity - $approvedQty;
                                                    @endphp

                                                    @if ($approvedQty > 0 && $pendingQty > 0)
                                                        <button class="btn btn-warning btn-sm edit-modal"
                                                            data-id="{{ $item->id }}">
                                                            Pending ({{ $pendingQty }})
                                                        </button>
                                                    @elseif ($item->status == 1)
                                                        <button class="btn btn-primary btn-sm edit-modal"
                                                            data-id="{{ $item->id }}">
                                                            Approve
                                                        </button>
                                                    @elseif ($item->status == 2)
                                                        <span class="text-success font-weight-bold">Approved</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <div id="dynamicModalContainer"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection

@section('scripts')
    <script>
        $(document).on("click", ".edit-modal", function() {
            let id = $(this).data("id");

            console.log({
                id
            });

            $.ajax({
                url: `/get-approve-modal/${id}`,
                type: "GET",
                success: function(response) {
                    $("#dynamicModalContainer").html(response);
                    $("#approveModal" + id).modal("show");
                    // $("#exampleEditModalScrollable" + id).offcanvas("show");
                },
                error: function() {
                    alert("Error loading loan type modal.");
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
@endsection
