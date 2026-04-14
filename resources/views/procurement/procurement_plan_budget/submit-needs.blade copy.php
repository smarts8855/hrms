@extends('layouts_procurement.app')
@section('pageTitle', 'Submit Needs')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            @include('ShareView.operationCallBackAlert')
            <div class="card-body">
                <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Department: {{ $userUnit->unit }}</h4>
                            </div>
                            @if($title->status==1)
                            <div class="col-md-6 text-right">
                                <p>If you can't find item, <a href="#" id="openModalLink" style="text-decoration: none; color: red">click here</a></p>
                            </div>
                            @endif
                        </div>
                    <hr>

                    @if($title->status==1)
                    <h5> {{ $title->title }}  for {{ date('d-m-Y', strtotime($title->date)) }}</h5>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="margin-bottom:30px">Create Needs Title</h4>

                            <form class="needs-validation" action="{{ route('saveNeedsAssessment') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- First column -->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="titleID" id="titleID" value="{{ $id }}">
                                                    <label for="bank_name">Category <span class="asterisks" style="color:red">*</span></label>
                                                    <select class="form-control" id="category" name="category">
                                                            <option value="">Select</option>
                                                        @foreach($categoryList as $list)
                                                            <option value="{{ $list->categoryID }}" {{ (old('category') == $list->categoryID) ? "selected" : "" }}>{{ $list->category }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="bank_code" id="item_label">Item<span class="asterisks" style="color:red">*</span></label>
                                                    <select class="form-control select-item" id="item" name="item">
                                                        <option value="">Select Item</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12" id="other_item" style="display:none">
                                                <div class="form-group">
                                                    <label for="bank_code">Other Item</label>
                                                    <input type="text" class="form-control" name="other_item" id="other_itemx" placeholder="Please enter other items">
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <!-- Second column -->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12" id="services">
                                                <div class="form-group">
                                                    <label for="bank_code">Quantity</label>
                                                    <input type="text" class="form-control" name="quantity" id="quantity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Brief Justification</label>
                                                    <textarea name="brief_justification" id="brief_justification" cols="30" rows="1" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top:27px">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table id="datatable-buttonsx" class="table table-striped table-responsive table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Brief Justification</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        @php
                        $n=1;
                        @endphp
                        <tbody>
                        @foreach($getList as $list)

                        <tr>
                            <td>{{$n++}}</td>
                            <td>{{ $list->category }}</td>
                            <td>{{ $list->item }}</td>
                            <td>{{ $list->description }}</td>
                            <td>{{ $list->quantity }}</td>
                            <td>{{ $list->brief_justification }}</td>

                            <td style="font-size:12px;">
                                <a onclick="funcedit('{{$list->needsID}}','{{$list->categoryID}}','{{$list->itemID}}','{{$list->description}}','{{$list->brief_justification}}','{{$list->quantity}}')"><button class="btn btn-info fa fa-edit btn-sm"></button></a>
                                <a onclick="funcdelete('{{ base64_encode($list->needsID) }}')"><button class="btn btn-danger fa fa-trash btn-sm"></button></a>
                            </td>

                        </tr>

                        @endforeach
                        </tbody>
                    </table>
                    @elseif($title->status==0)
                        <div class="card-body">

                            <div class="">
                                <img src="/images/folder.jpeg" alt="" width="100%" height="400px">
                            </div>

                            <h5 class="text-center">Please, contact Procurement Unit to open needs</h5>
                        </div>
                    @endif
                </div> <!-- end col -->
            </div>
        </div>
    </div> <!-- end col -->

</div> <!-- end row -->

<!-- Modal  -->

<!-- Button to Open the Modal -->
<!-- The Modal -->


  <div class="modal" id="editModalx">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form method="post" action="{{ route('updateNeedsAssessment') }}">
              @csrf

            <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="idx">
                <label for="bank_name">Category <span class="astericks" style="color:red">*</span></label>
                <select class="form-control" id="categoryx" name="category">
                        <option value="">Select</option>
                    @foreach($categoryList as $list)
                        <option value="{{ $list->categoryID}}" {{(old('category') == $list->categoryID) ? "selected" : ""}}>{{$list->category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="bank_code" id="item_labelx">Item<span class="astericks" style="color:red">*</span></label>
                <select class="form-control select-item" id="itemx" name="item">
                <option value="">Select Item</option>
                    @foreach($itemList as $list)
                        <option value="{{ $list->itemID}}" {{(old('item') == $list->itemID) ? "selected" : ""}}>{{$list->item}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" id="descriptionx" cols="30" rows="5" class="form-control"></textarea>
            </div>
              <div class="form-group" id="servicesx">
                  <label for="bank_code">Quantity</label>
                  <input type="text" class="form-control" name="quantity" id="quantityx">
              </div>
                  <div class="form-group">
                      <label for="">Brief Justification</label>
                      <textarea name="brief_justification" id="brief_justificationx" cols="30" rows="5" class="form-control"></textarea>
                  </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
          </form>
      </div>
    </div>
  </div>


<!-- Modal form to Add New Item if an Item is not found-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" action="{{ route('saveNotification') }}" method="POST">
                    @csrf
                    <div class="form-group col-md-12">
                        <label>Item Name <span class="text-danger"> * </span></label>
                        <div>
                            <input required type="text" name="item" value=""
                                class="form-control" placeholder="Enter Item" />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Reason <span class="text-danger"> * </span></label>
                        <textarea name="reason" id="" cols="" rows="" class="form-control" placeholder="Give reason why you want item to be added"></textarea>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- Add additional buttons if needed -->
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- End Modal-->

@endsection

@section('styles')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />-->

<style>

</style>

@endsection

@section('scripts')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>-->

<script>

    function alert()
    {
        alert('aasad');
    }
    function funcdelete(x)
    {
        y = confirm('Are you sure?')
        if(y==true)
        {
            document.location = '/delete-needs-assessment/'+x;
        }
    }


     // Add click event listener to the "click here" link
     document.getElementById('openModalLink').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the anchor tag
        $('#myModal').modal('show'); // Show the modal
    });


    function funcedit(x, w, y, a, b, z) {
    document.getElementById('idx').value = x;
    document.getElementById('categoryx').value = w;
    document.getElementById('itemx').value = y;
    document.getElementById('descriptionx').value = a;
    document.getElementById('brief_justificationx').value = b;
    document.getElementById('quantityx').value = z;

    // Check if category ID is 5
    if (w == 5) {
        // Hide the Item and Quantity fields
        document.getElementById('item_labelx').style.display = "none";
        document.getElementById('itemx').style.display = "none";
        document.getElementById('servicesx').style.display = "none";
    } else {
        // Show the Item and Quantity fields
        document.getElementById('item_labelx').style.display = "block";
        document.getElementById('itemx').style.display = "block";
        document.getElementById('servicesx').style.display = "block";
    }

    $("#editModalx").modal('show');
}



    function closeNeeds(x)
    {
        y = confirm('Are you sure?')
        if(y==true)
        {
            document.location = 'close-needs/'+x;
        }
    }

    function openNeeds(x)
    {
        y = confirm('Are you sure?')
        if(y==true)
        {
            document.location = 'open-needs/'+x;
        }
    }



    $("#category").change(function(e) {
        var category_id = e.target.value;

        if (category_id==5) {
            document.getElementById('services').style.display = "none";
            document.getElementById('item').style.display = "none"; // Hide the Item field
            document.getElementById('item_label').style.display = "none"; // Hide the Item label
        } else {
            document.getElementById('services').style.display = "block";
            document.getElementById('item').style.display = "block"; // Show the Item field for other categories
            document.getElementById('item_label').style.display = "block"; // Show the Item label for other categories
            $.get('/get-item-from-category?category_id=' + category_id, function(data) {
                $('#item').empty();
                $('#item').append('<option value="">Select Item</option>');
                $.each(data, function(index, obj) {
                    $('#item').append('<option value="' + obj.itemID + '">' + obj.item + '</option>');
                });
                // $('#item').append('<option value="other_items">Others</option>');
            });
        }
    });



    $("#categoryx").change(function(e) {
        var category_id = e.target.value;


        if (category_id==5) {
            document.getElementById('servicesx').style.display = "none";
            document.getElementById('itemx').style.display = "none"; // Hide the Item field
            document.getElementById('item_labelx').style.display = "none"; // Hide the Item label
        } else {
            document.getElementById('servicesx').style.display = "block";
            document.getElementById('itemx').style.display = "block"; // Show the Item field for other categories
            document.getElementById('item_labelx').style.display = "block"; // Show the Item label for other categories
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

    $("#item").change(function(e){

        //console.log(e);
        var item_id = e.target.value;
        if(item_id=='other_items')
        {
            document.getElementById('other_item').style.display="block";
        }else{
            document.getElementById('other_item').style.display="none";
        }
    });
</script>

<script>
$(document).ready(function () {
$(".bidAmt").on('keyup', function(evt){
//if (evt.which != 110 ){//not a fullstop
//var n = parseFloat($(this).val().replace(/\,/g,''),10);

    $(this).val(function (index, value) {
        return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
    //$(this).val(n.toLocaleString());
    //}
    });
});
</script>
@endsection
