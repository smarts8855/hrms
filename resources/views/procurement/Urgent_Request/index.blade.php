@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Urgent Request') }}
@endsection

@section('content')



    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card -->
            <div class="panel panel-default" style="border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">

                <!-- Card Header -->
                <div class="panel-heading" style="background: #f7f7f7; padding: 15px; border-radius: 6px 6px 0 0;">
                    <h4 class="panel-title" style="font-weight: bold; margin: 0;">
                        @yield('pageTitle')
                    </h4>
                    <div style="float: right; margin-top: -20px;">
                        All fields with <span class="text-danger">*</span> are required.
                    </div>
                    <div style="clear: both;"></div>
                </div>

                <!-- Card Body -->
                <div class="panel-body">

                    <div>
                        @include('procurement.ShareView.operationCallBackAlert')
                    </div>

                    <div id="form-status"></div>

                    <form id="itemRequestForm" method="POST" action="{{ route('saveitem-request') }}">
                        @csrf

                        <div class="row">

                            {{-- Department --}}
                            <div class="form-group col-md-6">
                                <label>Department</label>

                                @if ($user->user_role == 2)
                                    <select name="departmentId" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->department }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control" value="{{ $userDept->department }}" disabled>
                                    <input type="hidden" name="departmentId" value="{{ $userDept->id }}">
                                @endif
                            </div>

                            {{-- Item --}}
                            <div class="form-group col-md-6">
                                <label>Item</label>
                                <select name="itemId" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach ($itemsList as $item)
                                        <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Quantity --}}
                            <div class="form-group col-md-6">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" required min="1">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-12" style="text-align: right;">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>


@endsection

@section('styles')
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}




    <script>
        $('#itemRequestForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                // url: "{{ route('saveitem-request') }}"
                url: "{{ route('urgent-request.deliver') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    // Show immediate message
                    $('#form-status').html(
                        '<div class="alert alert-success">Item request submitted successfully!</div>'
                    );
                    $('#itemRequestForm')[0].reset();
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    for (let key in errors) {
                        errorHtml += '<li>' + errors[key][0] + '</li>';
                    }
                    errorHtml += '</ul></div>';
                    $('#form-status').html(errorHtml);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.view-specification').click(function(e) {
                e.preventDefault();

                var specs = JSON.parse($(this).data('specs'));
                var content = '';

                if (specs.length > 0) {
                    specs.forEach(function(spec) {
                        content += '<p>' + spec + '</p>';
                    });
                } else {
                    content = '<p>No specifications available.</p>';
                }

                $('#specificationContent').html(content);
                $('#specificationModal').modal('show');
            });
        });
    </script>


    <script>
        $('#itemId').on('change', function() {
            let itemId = $(this).val();

            $.get('/specifications/' + itemId, function(data) {
                let specSelect = $('#specificationId');
                specSelect.empty();
                data.forEach(function(spec) {
                    specSelect.append(
                        `<option value="${spec.specificationID}">${spec.specification}</option>`
                    );
                });
            });
        });
    </script>
@endsection
