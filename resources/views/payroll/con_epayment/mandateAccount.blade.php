@extends('layouts.layout')
@section('pageTitle')
    E-payment
@endsection
@section('content')
    <form method="POST" action="{{ url('/generate/mandate/account') }}" target="_self">
        <div class="box-body" style="background:#fff;">
            <div class="row">
                <div class="col-md-12">
                    <!--1st col-->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong>
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <h4 class="" style="text-transform:uppercase">Mandate Accounts Setup</h4>
                    <div class="row">

                        {{-- Bank --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bankName">BANK NAME</label>
                                <select name="bankName" id="bankName_" class="form-control" required>
                                    <option value="">Select Bank</option>
                                    @foreach ($allbanklist as $list)
                                        <option value="{{ $list->bankID }}"
                                            @if (old('bankName') == $list->bankID) selected @endif>{{ $list->bank }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="number" placeholder="00XX.....XXXX" class="form-control" name="accountNumber" required>
                            </div>
                        </div>
                     
                        {{-- Beneficiary --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" placeholder="eg: JUDICIAL STAFF UNION OF NIGERIA" class="form-control" name="beneficiary" required>
                            </div>
                        </div>

                        {{-- Ranking --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ranking</label>
                                <input type="number" class="form-control" name="rank" required>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deduction Caption</label>
                                <textarea class="form-control" placeholder="DEDUCTION" name="description" id="" cols="30" rows="5" required></textarea>
                            </div>
                        </div>

                        {{-- State --}}
					    <div class="col-md-6">
                            <label class="control-label col-sm-2" for="state">State:</label>
					    	<select name="state" id="state" class="form-control readonly">
					    		<option value="">Select a State</option>
					    		@foreach($statelist as $b)
					    		<option value="{{$b->State}}">{{$b->State}}</option>
					    		@endforeach
					    	</select>
					    </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm pull-right" id="createBtn">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- List of all Mandate Setup --}}
            <h3 style="text-align: center">Mandate Setups</h3>
            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>S/N</th>
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Address</th>
                        <th>Rank</th>
                        <th>Deduction Caption</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                        @php $i = 0 @endphp
                    <tbody>
                        @if ($mandatesAccounts !== null || ! empty($mandatesAccounts))
                            @foreach ($mandatesAccounts as $data)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$data->bank}}</td>
                                    <td>{{$data->account_no}}</td>
                                    <td>{{$data->address}}</td>
                                    <td>{{$data->rank}}</td>
                                    <td>{{$data->deduction_caption}}</td>
                                    <td>
                                        <a name="" id="editBtn" class="btn btn-success editBtn" href="#" role="button" data-toggle="modal" data-target="#editModelId" 
                                            bank="{{$data->bank}}" account="{{$data->account_no}}" beneficiary="{{$data->address}}" rank="{{$data->rank}}" description="{{$data->deduction_caption}}" dataID="{{$data->id}}" state="{{$data->state}}" >Edit</a>
                                        {{-- <a name="" id="" class="btn btn-danger delBtn" href="#" role="button" data-toggle="modal" data-target="#modelId" 
                                            bank="{{$data->bank}}" account="{{$data->account_no}}" dataID="{{$data->id}}">Delete</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <h3>No Data yet</h3>
                        @endif
                    </tbody>
            </table>
    
        </div><!-- /.col -->
        </div><!-- /.row -->
    </form>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: green; color: white;">
                    <h4 class="modal-title">Edit Mandate Account</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="{{ url('/update/mandate/account') }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="row">
                            {{ csrf_field() }}

                            {{-- Bank Name --}}
                            <div class="col-md-6">
                                <label for="bankName">Bank Name</label>
                                <select name="bankName" id="bankName_" class="form-control" required>
                                    <option value="">Select Bank</option>
                                    @foreach ($allbanklist as $list)
                                        <option value="{{ $list->bankID }}"
                                            @if (old('bankName') == $list->bankID) selected @endif>{{ $list->bank }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" id="rowId" name="id" value="">

                            {{-- Account Number --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="number" id="accountNumber" placeholder="00XX.....XXXX" class="form-control" name="accountNumber" required>
                                </div>
                            </div>
            
                            {{-- Beneficiary --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Adddress</label>
                                    <input type="text" id="beneficiary" placeholder="eg: JUDICIAL STAFF UNION OF NIGERIA" class="form-control" name="beneficiary" required>
                                </div>
                            </div>

                            {{-- Ranking --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ranking</label>
                                    <input type="number" id="rank" class="form-control" name="rank" required>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Deduction Caption</label>
                                    <textarea class="form-control" id="description" placeholder="DEDUCTION" name="description" id="" cols="30" rows="5" required></textarea>
                                </div>
                            </div>

                            {{-- State --}}
                            <div class="col-md-6">
                                <label class="control-label col-sm-2" for="editState">State:</label>
                                <select name="state" id="editState" class="form-control readonly">
                                    <option value="">Select a State</option>
                                    @foreach($statelist as $b)
                                    <option value="{{$b->State}}">{{$b->State}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    
    <!-- Delete Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red">
                    <h3 class="modal-title">Delete Prompt!!!</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                </div>
                <form action="{{ url('/delete/mandate/account') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        Are you sure you want to delete data for <br> Account Number: <span id="delAccountName"></span> <br> Bank: <span id="delBankName"></span>
                        <input type="hidden" id="delMandateID" name="mandateID" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
@endsection
@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            // When edit button is clicked
            $('.editBtn').click(function (e) { 
                e.preventDefault();
                
                let id = $(this).attr('dataID'); 
                let bank = $(this).attr('bank'); 
                let account = $(this).attr('account');
                let beneficiary = $(this).attr('beneficiary');
                let rank = $(this).attr('rank');
                let description = $(this).attr('description');
                let state = $(this).attr('state');


                $('#rowId').val(id);
                $('#accountNumber').val(account);
                $('#beneficiary').val(beneficiary);
                $('#rank').val(rank);
                $('#description').val(description);
                $('#editState').val(state);
            });


            //When delete button is clicked
            $('.delBtn').click(function (e) { 
                e.preventDefault();
                
                let id = $(this).attr('dataID');
                let bank = $(this).attr('bank'); 
                let account = $(this).attr('account');

                $('#delAccountName').html(account);
                $('#delBankName').html(bank);

                $('#delMandateID').val(id);

            });
        });
    </script>
@endsection
