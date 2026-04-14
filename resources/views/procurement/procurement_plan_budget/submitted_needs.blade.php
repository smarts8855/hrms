@extends('layouts_procurement.app')
@section('pageTitle', 'Submit Needs')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('ShareView.operationCallBackAlert')
            </div>
            
            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>Submitted Needs List</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-list"></i> Total Entries: {{ $getList->count() }}
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
                                        <th>CATEGORY</th>
                                        <th>ITEM</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>JUSTIFICATION</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @forelse($getList as $list)
                                    <tr>
                                        <td>{{$n++}}</td>
                                        <td class="font-weight-bold">{{ $list->category }}</td>
                                        <td class="font-weight-bold">{{ $list->item }}</td>
                                        <td>{{ $list->description }}</td>
                                        <td>{{ $list->quantity }}</td>
                                        <td>{{ $list->brief_justification }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" onclick="funcedit('{{$list->needsID}}','{{$list->categoryID}}','{{$list->itemID}}','{{$list->description}}','{{$list->brief_justification}}','{{$list->quantity}}')">
                                                <i class="fa fa-edit mr-1"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="funcdelete('{{ base64_encode($list->needsID) }}')">
                                                <i class="fa fa-trash mr-1"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fa fa-inbox fa-3x mb-3"></i>
                                                <h4>No Needs Submitted</h4>
                                                <p>No needs have been submitted yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(($getList instanceof \Illuminate\Pagination\AbstractPaginator && $getList->hasPages()))
                            <div class="card-footer bg-transparent border-0">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="text-muted">
                                            Showing {{($getList->currentpage()-1)*$getList->perpage()+1}}
                                            to {{$getList->currentpage()*$getList->perpage()}}
                                            of {{$getList->total()}} entries
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            {{ $getList->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade text-left d-print-none" id="editModalx" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-edit"></i> Edit Needs Entry
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('updateNeedsAssessment') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="id" id="idx">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select class="form-control" id="categoryx" name="category" required>
                                        <option value="">Select Category</option>
                                        @foreach($categoryList as $list)
                                            <option value="{{ $list->categoryID}}">{{$list->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="item_labelx">Item <span class="text-danger">*</span></label>
                                    <select class="form-control select-item" id="itemx" name="item" required>
                                        <option value="">Select Item</option>
                                        @foreach($itemList as $list)
                                            <option value="{{ $list->itemID}}">{{$list->item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="descriptionx" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="servicesx">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" name="quantity" id="quantityx">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Brief Justification</label>
                                    <textarea name="brief_justification" id="brief_justificationx" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
<script>
    function funcdelete(x) {
        if(confirm('Are you sure you want to delete this needs entry?')) {
            document.location = '/delete-needs-assessment/'+x;
        }
    }

    function funcedit(x, w, y, a, b, z) {
        document.getElementById('idx').value = x;
        document.getElementById('categoryx').value = w;
        document.getElementById('itemx').value = y;
        document.getElementById('descriptionx').value = a;
        document.getElementById('brief_justificationx').value = b;
        document.getElementById('quantityx').value = z;

        // Check if category ID is 5
        if (w == 5) {
            document.getElementById('item_labelx').style.display = "none";
            document.getElementById('itemx').style.display = "none";
            document.getElementById('servicesx').style.display = "none";
        } else {
            document.getElementById('item_labelx').style.display = "block";
            document.getElementById('itemx').style.display = "block";
            document.getElementById('servicesx').style.display = "block";
        }

        $("#editModalx").modal('show');
    }

    $("#categoryx").change(function(e) {
        var category_id = e.target.value;

        if (category_id==5) {
            document.getElementById('servicesx').style.display = "none";
            document.getElementById('itemx').style.display = "none";
            document.getElementById('item_labelx').style.display = "none";
        } else {
            document.getElementById('servicesx').style.display = "block";
            document.getElementById('itemx').style.display = "block";
            document.getElementById('item_labelx').style.display = "block";
            $.get('/get-item-from-category?category_id=' + category_id, function(data) {
                $('#itemx').empty();
                $('#itemx').append('<option value="">Select Item</option>');
                $.each(data, function(index, obj) {
                    $('#itemx').append('<option value="' + obj.itemID + '">' + obj.item + '</option>');
                });
                $('#itemx').append('<option value="other_items">Others</option>');
            });
        }
    });

    // Number formatting
    $(document).ready(function () {
        $(".bidAmt").on('keyup', function(evt){
            $(this).val(function (index, value) {
                return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    });
</script>
@endsection