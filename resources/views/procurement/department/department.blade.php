@extends('layouts_procurement.app')
@section('pageTitle', 'Departments')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('Bank.layouts.messages')
            </div>
            
            <div class="col-md-12">
                <!-- Create Department Card -->
                <div class="box-body" style="background:#FFF; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="" style="text-transform:uppercase">Department Management</h4>
                            <div align="right" style="margin-bottom: 15px;"> All fields with <span class="text-danger">*</span> are required.</div>
                            
                            <form class="custom-validation" method="post" action="{{route('updateDepartment')}}">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="form-group mb-0">
                                            <label>Department Name <span class="text-danger">*</span></label>
                                            <input type="hidden" name="id" id="did">
                                            <input type="text" class="form-control" id="name" placeholder="Enter department name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <div class="d-flex justify-content-end" style="margin-top: 27px;">
                                                <button class="btn btn-success" type="submit" id="button-addon2">
                                                    <i class="fa fa-plus mr-1"></i> Create Department
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Departments List -->
                <div class="box-body" style="background:#FFF;">
                    <div class="box-header with-border hidden-print">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="box-title"><b>Departments List</b></h3>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 style="font-size: 14px; text-decoration: none;">
                                    <i class="fa fa-building"></i> Total Departments: {{ $datas->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border hidden-print text-center">
                                <hr>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-bordered">
                                    <thead class="text-gray-b">
                                        <tr>
                                            <th>S/N</th>
                                            <th>DEPARTMENT NAME</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $key=>$data)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td class="font-weight-bold">{{$data->department}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm edit" data-name="{{$data->department}}" data-id="{{$data->departmentID}}">
                                                    <i class="fa fa-edit mr-1"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#deleteModal" data-name="{{$data->department}}" data-id="{{$data->departmentID}}">
                                                    <i class="fa fa-trash mr-1"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade text-left d-print-none" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-trash"></i> Delete Department
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('deleteDepartment')}}">
                    @csrf
                    <input type="hidden" id="deleteID" name="id">
                    <div class="modal-body text-center">
                        <div class="text-danger mb-3">
                            <i class="fa fa-exclamation-triangle fa-3x mb-3"></i>
                            <h4 class="font-weight-bold">Confirm Deletion</h4>
                            <p>Are you sure you want to delete this department?</p>
                            <p class="text-muted mt-3">
                                <i class="fa fa-warning text-warning mr-1"></i>
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.04);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .btn {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .form-control {
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-color: #007bff;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Edit department
        $('.edit').on('click',function(){
            var name = $(this).data('name')
            var id = $(this).data('id')
            $('#did').val(id)
            $('#name').val(name)
            $('#button-addon2').html('<i class="fa fa-edit mr-1"></i> Update Department')
            $('html, body').animate({
                scrollTop: $(".box-body").offset().top
            }, 500);
        });
        
        // Delete department
        $('.delete').on('click',function(){
            var name = $(this).data('name')
            var id = $(this).data('id')
            $('#deleteID').val(id)
        });
        
        // Reset form when creating new department
        $('#name').on('focus', function() {
            if($(this).val() === '') {
                $('#button-addon2').html('<i class="fa fa-plus mr-1"></i> Create Department')
                $('#did').val('')
            }
        });
    });
</script>
@endsection