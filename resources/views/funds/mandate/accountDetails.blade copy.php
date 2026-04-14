@extends('layouts.layout')

@section('pageTitle')
All Transaction Details
@endsection

@section('content')
<div class="box-body">

    <div class="box-body hidden-print">
    <div class="row">
      <div class="col-sm-12">
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> <br />
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif

        @if(session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> <br />
          {{ session('msg') }}
        </div>                        
        @endif

        @if(session('err'))
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Operation Error !</strong> <br />
          {{ session('err') }}
        </div>                        
        @endif
      </div>
    </div><!-- /row -->
  </div><!-- /div -->


  <div class="box-body">
        
        

        
        <div class="row">
             
             <form method="post" action="{{url('/account/details')}}" style="margin-top:10px;">
                    {{ csrf_field() }}
                    

                    <div class="row">
                        
                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">Bank</label>
                                <select name="bank" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($banks as $list)
                                    <option value="{{$list->bankID}}">{{$list->bank}}</option>
                                    @endforeach
                                   
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">Account Number</label>
                               <input type="text" name="accountNo" class="form-control" required/>
                            </div>
                        </div>

                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">Contract Type</label>
                                <select name="contractTypeID" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($contracttypes as $list)
                                    <option value="{{$list->ID}}">{{$list->contractType}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Address</label>
                                <textarea name="address" class="form-control" style="height:200px;" id="address" ></textarea>
                            </div>
                        </div>
                        
                    </div>

                    <input type="submit" class="btn btn-success" name="submit" value="Save" />

                    
                </form> 
            
        </div>
        
     
    </div>
    <!-- /.row -->
    <div class="row">
        <h2 class="text-center"> All Account Details</h2>
        <table class="table table-responsive table-bordered" id="tableData">
          <tr class="tblborder">
            <th>SN</th>
            <th>Bank</th>
            <th>Account</th>
            <th>Contract Type</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          <?php $n = 1; ?>
          @foreach($accounts as $list)
          <tr class="{{ $list->status == 1 ? 'active-row' : 'inactive-row' }}" id="row-{{ $list->id }}">
            <td>{{$n++}}</td>
            <td>{{ $list->bank}}</td>
            <td>{{ $list->account_no}}</td>
            <td>{{ $list->contractType}}</td>
            <td>{!! $list->address !!}</td>
            <td>
                @if ($list->status == 1)
                  <span class="status-badge status-active" id="status-badge-{{ $list->id }}">Active</span>
                @else
                  <span class="status-badge status-inactive" id="status-badge-{{ $list->id }}">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ url('/edit/account/'.$list->id) }}" class="btn btn-success btn-sm">Edit</a>
                
                @if ($list->status == 1)
                  <button type="button" class="btn btn-warning btn-sm toggle-status-btn" 
                          data-id="{{ $list->id }}" 
                          data-action="deactivate">
                    Deactivate
                  </button>
                @else
                  <button type="button" class="btn btn-info btn-sm toggle-status-btn" 
                          data-id="{{ $list->id }}" 
                          data-action="activate">
                    Activate
                  </button>
                @endif
            </td>
          </tr>
          @endforeach
        </table>
    </div>
  </div>

  @endsection

  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

 <style type="text/css">
    .status {
        font-size: 15px;
        padding: 0px;
        height: 100%;
    }

    .textbox { 
        border: 1px;
        background-color: #66FFBA; 
        outline:0; 
        height:25px; 
        width: 275px; 
    } 
    
    .autocomplete-suggestions {
        color:#66FFBA;
        height:125px; 
    }
    
    .table,tr,th,td {
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
    
    .disabled-link {
        cursor: default;
        pointer-events: none;        
        text-decoration: none;
        color: grey;
    }
    
    /* Status badge styling */
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        color: white;
        min-width: 70px;
        text-align: center;
    }
    
    .status-active {
        background-color: #28a745; /* Green */
    }
    
    .status-inactive {
        background-color: #dc3545; /* Red */
    }
    
    /* Row styling based on status */
    tr.active-row {
        background-color: #f8fff8; /* Very light green */
    }
    
    tr.inactive-row {
        background-color: #fff5f5; /* Very light red */
    }
    
    tr.active-row:hover {
        background-color: #e8f7e8; /* Light green on hover */
    }
    
    tr.inactive-row:hover {
        background-color: #ffeaea; /* Light red on hover */
    }
    
    /* Button spacing */
    .btn-sm {
        margin: 2px;
        padding: 3px 8px;
        font-size: 12px;
    }
</style>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Handle toggle status button clicks
    $('.toggle-status-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const id = button.data('id');
        const action = button.data('action');
        const status = action === 'activate' ? 1 : 0;
        
        // Show confirmation dialog
        const confirmMessage = action === 'activate' 
            ? 'Are you sure you want to activate this account?' 
            : 'Are you sure you want to deactivate this account?';
        
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Disable button during processing
        button.prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: '/toggle/account/status/' + id,
            type: 'POST',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
           success: function(response) {
                  if (response.success) {
                      // Show success message
                      alert(response.message || 'Status updated successfully!');
                      
                      // Always reload the page to get fresh data from server
                      location.reload();
                  } else {
                      alert(response.message || 'Error updating status');
                      button.prop('disabled', false);
                  }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred while updating status';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                
                alert(errorMessage);
                button.prop('disabled', false);
            }
        });
    });
    
    function updateRowStatus(id, status) {
        const row = $('#row-' + id);
        const badge = $('#status-badge-' + id);
        const button = row.find('.toggle-status-btn');
        
        if (status == 1) {
            // Change to active
            row.removeClass('inactive-row').addClass('active-row');
            badge.removeClass('status-inactive').addClass('status-active').text('Active');
            
            // Update button
            button.removeClass('btn-info').addClass('btn-warning')
                  .text('Deactivate')
                  .data('action', 'deactivate');
        } else {
            // Change to inactive
            row.removeClass('active-row').addClass('inactive-row');
            badge.removeClass('status-active').addClass('status-inactive').text('Inactive');
            
            // Update button
            button.removeClass('btn-warning').addClass('btn-info')
                  .text('Activate')
                  .data('action', 'activate');
        }
    }
});
</script>
@endsection
  @endsection
  
 