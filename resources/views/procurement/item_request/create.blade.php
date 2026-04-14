@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Request Items') }}
@endsection

@section('content')



    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
                    <div class="clearfix">
                        <div class="pull-right">
                            All fields with <span class="text-danger">*</span> are required.
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0; padding-left: 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="itemRequestForm" method="POST" action="{{ route('saveitem-request') }}">
                        @csrf

                        {{-- Request Information --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div style="border-bottom: 1px solid #eee; margin-bottom: 15px; padding-bottom: 8px;">
                                    <h4 style="margin: 0; font-size: 16px; font-weight: 600;">Request Information</h4>
                                    <small class="text-danger">Enter the basic details of this item request.</small>
                                </div>
                            </div>

                            {{-- Department --}}
                            <div class="form-group col-md-6">
                                <label>Department <span class="text-danger">*</span></label>

                                @if ($user->user_unit == 28 || $user->is_global == 1)
                                    <select name="departmentId" class="form-control" required>
                                        <option value="">Select department</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('departmentId') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" value="{{ $userDept->department }}" disabled class="form-control">
                                    <input type="hidden" name="departmentId"
                                        value="{{ old('departmentId', $userDept->departmentID) }}">
                                @endif
                            </div>

                            {{-- Title --}}
                            <div class="form-group col-md-6">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ old('title') }}" placeholder="Enter request title" required>
                            </div>

                            {{-- Description --}}
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control" id="description" rows="3"
                                    placeholder="Enter request description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        {{-- Requested Items --}}
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div
                                    style="border-bottom: 1px solid #eee; margin-bottom: 15px; padding-bottom: 8px; overflow: hidden;">
                                    <div class="pull-left">
                                        <h4 style="margin: 0; font-size: 16px; font-weight: 600;">Requested Items</h4>
                                        <small class="text-danger">Add one or more items for this request.</small>
                                    </div>

                                    <div class="pull-right" style="margin-top: 5px;">
                                        <button type="button" id="add-more" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="items-wrapper">

                                    @php
                                        $oldItems = old('itemId', ['']);
                                        $oldQuantities = old('quantity', ['']);
                                    @endphp

                                    @foreach ($oldItems as $index => $oldItemId)
                                        <div class="row item-row" style="margin-bottom: 15px;">
                                            <div class="form-group col-md-5">
                                                <label>Item <span class="text-danger">*</span></label>
                                                <select name="itemId[]" class="form-control item-select" required>
                                                    <option value="">Select item</option>
                                                    @foreach ($itemsList as $item)
                                                        <option value="{{ $item->itemID }}"
                                                            {{ $oldItemId == $item->itemID ? 'selected' : '' }}>
                                                            {{ $item->item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-5">
                                                <label>Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="quantity[]" class="form-control" required
                                                    min="1" placeholder="Enter quantity"
                                                    value="{{ isset($oldQuantities[$index]) ? $oldQuantities[$index] : '' }}">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label style="visibility: hidden;">Action</label>
                                                <button type="button" class="btn btn-danger remove-row btn-block">
                                                    <i class="fa fa-remove"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    Submit Request
                                </button>
                            </div>
                        </div>
                    </form>
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
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            function updateItemOptions() {
                var selectedValues = [];

                // collect all selected item values
                $('select[name="itemId[]"]').each(function() {
                    var value = $(this).val();
                    if (value) {
                        selectedValues.push(value);
                    }
                });

                // reset all options first
                $('select[name="itemId[]"]').each(function() {
                    var currentSelect = $(this);
                    var currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        var optionValue = $(this).val();

                        if (optionValue === '') {
                            $(this).prop('disabled', false).show();
                        } else if (selectedValues.indexOf(optionValue) !== -1 && optionValue !==
                            currentValue) {
                            $(this).prop('disabled', true).hide();
                        } else {
                            $(this).prop('disabled', false).show();
                        }
                    });
                });
            }

            $('#add-more').on('click', function() {
                var newRow = `
                    <div class="row item-row" style="margin-bottom: 15px;">
                        <div class="form-group col-md-5">
                            <label>Item</label>
                            <select name="itemId[]" class="form-control" required>
                                <option value="">Select item</option>
                                @foreach ($itemsList as $item)
                                    <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5">
                            <label>Quantity</label>
                            <input type="number" name="quantity[]" class="form-control" required min="1" placeholder="Enter quantity">
                        </div>

                        <div class="form-group col-md-2">
                            <label style="visibility: hidden;">Action</label>
                            <button type="button" class="btn btn-danger remove-row btn-block">
                                <i class="fa fa-remove"></i> Remove
                            </button>
                        </div>
                    </div>
                `;

                $('#items-wrapper').append(newRow);
                updateItemOptions();
            });

            $(document).on('change', 'select[name="itemId[]"]', function() {
                updateItemOptions();
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                } else {
                    // alert('At least one item row is required.');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'At least one item row is required.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal-popup',
                            title: 'swal-title'
                        },
                    });
                }
            });
            updateItemOptions();
        });
    </script>
@endsection
