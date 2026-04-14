@extends('layouts_procurement.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{-- <h3 class="panel-title">Add items supplied by the {{ $contract->company_name }}</h3> --}}
                        <h3 class="panel-title">
                            Add items supplied by {{ $contract->company_name }}
                            <span style="font-size:14px; color:#555;">({{ $contract->contract_name }})</span>
                        </h3>
                    </div>

                    <div class="panel-body">
                        <form id="itemForm" action="{{ route('store.saveItemQty', $contract->id) }}" method="POST">
                            @csrf

                            <div id="itemRowsContainer">
                                <div class="row item-row"
                                    style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee;">


                                    <div class="col-md-2">
                                        <label>Select Item</label>

                                        <select name="item_id[]" class="form-control item-select" required>
                                            <option value="">-- Select Item --</option>

                                            @foreach ($items as $item)
                                                {{-- <option value="{{ $item->itemID }}"
                                                    data-specs='@json($item->specs)'>
                                                    {{ $item->item }}
                                                    @if (count($item->specs))
                                                        — {{ implode(', ', $item->specs) }}
                                                    @else
                                                        — No specs
                                                    @endif
                                                </option> --}}
                                                <option value="{{ $item->itemID }}"
                                                    data-specs='@json($item->specs)'>
                                                    {{ $item->item }}
                                                    @if (count($item->specs) > 0)
                                                        ({{ implode(', ', $item->specs) }})
                                                    @else
                                                        (No specs)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    {{-- <div class="col-md-3">
                                            <label>Specifications</label>
                                            <div class="specification-tags-container"
                                                style="border: 1px solid #ddd;  height: 33px; border-radius: 2px; background-color: #f9f9f9;">
                                                <div class="tags-wrapper">

                                                </div>
                                            </div>
                                        </div> --}}

                                    <div class="col-md-2">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity[]" value="0" class="form-control quantity"
                                            min="0" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unit_price[]" class="form-control unit-price text-right"
                                            required>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Total Price</label>
                                        <input type="text" name="total_price[]"
                                            class="form-control total-price text-right" readonly>
                                    </div>

                                    <div class="col-md-1" style="padding-top: 25px;">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="removeRow(this)">−</button>
                                    </div>


                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Items</button>
                        </form>

                        <hr>





                        <div class="modal fade" id="globalSpecModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="specModalTitle">Specifications</h4>
                                    </div>

                                    <div class="modal-body" id="specModalBody">
                                        <!-- JS will insert specifications here -->
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Saved Items</h3>
                    </div>

                    <div class="panel-body">
                        @if ($savedItems->isEmpty())
                            <p class="text-muted">No items added yet.</p>
                        @else
                            <div class="table-responsive">
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

                                        @foreach ($savedItems as $item)
                                            @php
                                                $approvedQty = $item->approvedQuantity ?? 0;
                                                $pendingQty = $item->totalQuantity - $approvedQty;
                                            @endphp

                                            <tr>
                                                <td>{{ $i++ }}</td>



                                                {{-- <td style="width: 30%">
                                                    <span class="item-name" data-item="{{ $item->itemName }}"
                                                        data-specs='@json($item->specifications)'
                                                        style="cursor:pointer; color:#337ab7;">
                                                        {{ $item->itemName }}
                                                    </span>
                                                </td> --}}

                                                <td style="width: 30%">
                                                    <span class="item-name" data-item="{{ $item->itemName }}"
                                                        data-specs='@json($item->specifications)'
                                                        style=" color:#337ab7; display:inline-block;">
                                                        {{ $item->itemName }}
                                                    </span>

                                                    {{-- ✓ Display specs beside item --}}
                                                    @if (!empty($item->specifications) && count($item->specifications) > 0)
                                                        <small style="color:#555; margin-left:6px;">
                                                            ({{ implode(', ', $item->specifications) }})
                                                        </small>
                                                    @else
                                                        <small class="text-muted" style="margin-left:6px;">(No
                                                            specs)</small>
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
                                        @endforeach

                                    </tbody>
                                </table>
                        @endif







                        <div id="dynamicModalContainer"></div>

                        {{-- <div class="text-center" style="margin-top: 20px;">
                            <a href="{{ route('assign.items') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Back to Assigned Contracts
                            </a>
                        </div> --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Add this once at the bottom of your page -->
    <div id="specPopup"
        style="
    position:absolute;
    display:none;
    background:#fff;
    border:1px solid #ccc;
    border-radius:6px;
    padding:10px;
    min-width:200px;
    max-width:300px;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    z-index:9999;
">
        <div id="specPopupTitle" style="font-weight:bold; margin-bottom:8px;"></div>
        <div id="specPopupBody"></div>
    </div>
@endsection

@section('styles')
    <style>
        .spec-tag {
            display: inline-block;
            padding: 5px 10px;
            margin: 3px;
            background-color: #17a2b8;
            color: white;
            border-radius: 3px;
            font-size: 10px;
            border: 1px solid #138496;
            cursor: default;
            /* Changed to default cursor since not clickable */
        }

        .item-select {
            /* border: 2px solid #3c8dbc; */
            padding: 7px;
            border-radius: 6px;
            background: #f9f9f9;
            font-weight: 500;
        }

        .item-select option {
            padding: 10px;
            font-size: 13px;
            border-radius: 4px;
        }

        #specPopup::after {
            content: "";
            position: absolute;
            top: 10px;
            left: -6px;
            border-width: 6px;
            border-style: solid;
            border-color: transparent #ccc transparent transparent;
        }

        .spec-tag.info {
            background-color: #17a2b8;
        }

        .spec-tag.warning {
            background-color: #ffc107;
            color: #212529;
            border-color: #d39e00;
        }

        .spec-tag.success {
            background-color: #28a745;
            border-color: #1e7e34;
        }

        /* .specification-tags-container {
                                                                                                                                                                                                        border: 1px solid #ddd;
                                                                                                                                                                                                        padding: 10px;
                                                                                                                                                                                                        border-radius: 4px;
                                                                                                                                                                                                        background-color: #f9f9f9;
                                                                                                                                                                                                        max-height: 80px;
                                                                                                                                                                                                        overflow-y: auto;
                                                                                                                                                                                                    } */

        .tags-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        #specModalBody {
            display: flex;
            flex-wrap: wrap;
            /* 🔥 Forces inline wrapping */
            gap: 6px;
            /* Space between items */
            padding: 10px;
        }

        .spec-badge {
            display: inline-block;
            padding: 5px 10px;
            background: #44a8c7;
            /* Bootstrap info color */
            color: white;
            border-radius: 3px;
            font-size: 10px;
            white-space: nowrap;
            /* Avoid breaking inside text */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('itemForm');

            function formatNumberWithCommas(value) {
                const number = parseFloat(value.replace(/,/g, ''));
                if (isNaN(number)) return '';
                return number.toLocaleString('en-US', {
                    minimumFractionDigits: 2
                });
            }

            function updateTotalPrice(row) {
                const qty = parseFloat(row.querySelector('.quantity').value.replace(/,/g, '')) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price').value.replace(/,/g, '')) || 0;
                const total = qty * unitPrice;
                row.querySelector('.total-price').value = total ? formatNumberWithCommas(total.toString()) : '';
            }


            function renderSpecificationTags(row, specifications) {
                const select = row.querySelector('.item-select');
                select.setAttribute('data-specs', JSON.stringify(specifications));
            }






            window.addRow = function() {
                const container = document.getElementById('itemRowsContainer');
                const firstRow = container.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                // Clear values
                newRow.querySelectorAll('input, select').forEach(el => {
                    if (el.type !== 'hidden') el.value = '';
                });

                // Reset tags
                // newRow.querySelector('.tags-wrapper').innerHTML =
                //     '<span class="text-muted">Select an item to view specifications</span>';

                // console.log(select.getAttribute('data-specs'));

                container.appendChild(newRow);
            }

            window.removeRow = function(button) {
                const container = document.getElementById('itemRowsContainer');
                const row = button.closest('.item-row');
                if (container.querySelectorAll('.item-row').length > 1) {
                    container.removeChild(row);
                }
            }

            // Input event for live formatting & total price calculation
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                    const row = e.target.closest('.item-row');

                    // Live format unit price while typing
                    if (e.target.classList.contains('unit-price')) {
                        const cursorPos = e.target.selectionStart;
                        e.target.value = formatNumberWithCommas(e.target.value);
                        e.target.setSelectionRange(cursorPos, cursorPos); // keep cursor position
                    }

                    updateTotalPrice(row);
                }
            });

            // Clean commas before submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                form.querySelectorAll('.unit-price, .total-price').forEach(input => {
                    input.value = input.value.replace(/,/g, '');
                });
                form.submit();
            });

            // Load specs when item is selected
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('item-select')) {
                    const row = e.target.closest('.item-row');
                    const itemId = e.target.value;


                    if (!itemId) {
                        select.removeAttribute('data-specs');
                        return;
                    }

                    fetch(`/get-specs/${itemId}`)
                        .then(res => res.json())
                        .then(data => {
                            renderSpecificationTags(row, data); // THIS WILL FINALLY WORK
                        })

                }
            });
        });
    </script>

    {{-- // item specs input --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const popup = document.getElementById('specPopup');
            const popupTitle = document.getElementById('specPopupTitle');
            const popupBody = document.getElementById('specPopupBody');
            let hoverTimer;

            /* -----------------------------------------
               HOVER POPUP FOR SELECT ITEM (.item-select)
            ------------------------------------------*/
            document.addEventListener('mouseover', function(e) {

                const select = e.target.closest('.item-select');
                if (!select) return;

                hoverTimer = setTimeout(() => {

                    let specs = select.getAttribute('data-specs');

                    try {
                        specs = JSON.parse(specs);
                    } catch {
                        specs = [];
                    }

                    popupTitle.innerText = select.options[select.selectedIndex]?.text ||
                        "Specifications";

                    let html = "";
                    if (specs.length > 0) {
                        specs.forEach(s => {
                            html +=
                                `<div style="padding:4px 0; border-bottom:1px solid #eee;">• ${s.specification}</div>`;
                        });
                    } else {
                        html = `<div class="text-muted">No specifications</div>`;
                    }

                    popupBody.innerHTML = html;

                    const rect = select.getBoundingClientRect();
                    popup.style.top = (rect.top + window.scrollY + 35) + "px";
                    popup.style.left = (rect.left + window.scrollX + 20) + "px";

                    popup.style.display = "block";

                }, 300);
            });

            document.addEventListener('mouseout', function(e) {
                clearTimeout(hoverTimer);
                popup.style.display = 'none';
            });

        });
    </script>

    {{-- // end spec input --}}


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('specPopup');

            // Select all items
            const items = document.querySelectorAll('.item-name');

            items.forEach(item => {
                let hoverTimer;

                item.addEventListener('mouseenter', function(e) {
                    hoverTimer = setTimeout(() => {
                        const itemName = e.target.getAttribute('data-item');

                        let specs = e.target.getAttribute('data-specs');

                        // Make sure it's parsed as array
                        try {
                            specs = JSON.parse(specs);
                        } catch (err) {
                            specs = [];
                        }

                        document.getElementById('specPopupTitle').innerText = itemName;

                        let html = '';
                        if (specs.length > 0) {
                            specs.forEach(spec => {
                                html +=
                                    `<div style="padding:4px 0; border-bottom:1px solid #eee;">• ${spec}</div>`;
                            });
                        } else {
                            html = `<div class="text-muted">No specifications</div>`;
                        }

                        document.getElementById('specPopupBody').innerHTML = html;

                        // Position popup near item
                        const rect = e.target.getBoundingClientRect();
                        popup.style.top = (rect.top + window.scrollY + 25) + 'px';
                        popup.style.left = (rect.left + window.scrollX + 20) + 'px';

                        popup.style.display = 'block';
                    }, 200); // small delay
                });

                item.addEventListener('mouseleave', function(e) {
                    clearTimeout(hoverTimer);

                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 100);
                });
            });

            // Keep popup open if mouse moves over it
            popup.addEventListener('mouseenter', function() {
                popup.style.display = 'block';
            });

            popup.addEventListener('mouseleave', function() {
                popup.style.display = 'none';
            });
        });
    </script> --}}

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
@endsection
