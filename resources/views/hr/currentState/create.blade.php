@extends('layouts.layout')
@section('pageTitle', 'Create State')

@section('content')

   <div class="box box-default">
        <div class="box-header with-border hidden-print">
           <h3 class="box-title .text-uppercase"><strong>@yield('pageTitle')</strong></h3>
        </div>


        <form method="post" action="{{ route('postCurrentState') }}"  id="form1">
        {{ csrf_field() }}

            <div class="box-body">

                <div class="row col-md-offset-2">
                    <div class="col-md-10">
                        @if ((count($errors) > 0))
                          <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> <br />
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                          </div>
                        @endif
                        @if(session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Success!</strong> {{ session('message') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        @endif



                    </div>
                </div>

                <div class="row col-md-offset-2">
                    <div class="col-md-5">
                        <label>Name of State</label>
                        <input type="text" name="stateName" class="form-control" required/>
                    </div>
                    <div class="col-md-5">
                        <label>State Address</label>
                        <input type="text" name="stateAddress" class="form-control" />
                    </div>
                </div>
                <div class="row col-md-offset-2">
                    <div class="col-md-5">  <br />
                        <label>Bank Name</label>
                        <select name="bankName" class="form-control" required>
                            <option>Select</option>
                            @if(isset($currentBank))
                                @foreach($currentBank as $listBank)
                                   <option value="{{ $listBank->bankID }}">{{ $listBank->bank }}   {{ ($listBank->Bankcode ? '  -  ('. $listBank->Bankcode .')' : '') }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-5"> <br />
                        <label>Account Number</label>
                        <input type="number" name="accountNumber" class="form-control" required/>
                    </div>
                </div>
                <div class="row col-md-offset-2">
                    <div align="center" class="col-md-10">
                        <br />
                        <button type="submit" name="addNews" class="btn btn-success"><i class="fa fa-save"></i> Add New</button>
                    </div>
                </div>

            </div>
        </form>

        <hr />

        <div class="box-body">
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#f9f9f9">
                            <th><strong>S/N</strong></th>
                            <th><strong>NAME OF STATE</strong></th>
                            <th><strong>ADDRESS</strong></th>
                            <th><strong>BANK</strong></th>
                            <th><strong>ACCOUNT NO.</strong></th>
                            <th><strong>STATUS</strong></th>
                            <th colspan="2">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if(isset($currentState))
                            @foreach($currentState as $keyState=>$listState)
                                <tr>
                                    <td>{{ 1+$keyState }}</td>
                                    <td>{{ $listState->state }}</td>
                                    <td>{{ $listState->address }}</td>
                                    <td>{{ $listState->bankName }}</td>
                                    <td>{{ $listState->account_no }}</td>
                                    <td>{!! ($listState->status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Deactivated</span>') !!}</td>
                                    <td><a href="javascript:;" data-toggle="modal" data-target="#editModal{{$listState->stateID}}" class="btn btn-info"><i class="fa fa-edit"></i></a></td>
                                    <td><a href="javascript:;" data-toggle="modal" data-target="#deleteModal{{$listState->stateID}}" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                                </tr>

                                <!--EDIT Modal -->
                        		<div class="modal fade" id="editModal{{$listState->stateID}}" tabindex="-1" role="dialog" aria-labelledby="Edit Record" aria-hidden="true">
                        		  <div class="modal-dialog modal-dialog-centered" role="form">
                        		    <div class="modal-content">
                        		        <div class="modal-header">
                        		            <h4 class="modal-title" id="exampleModalLongTitle">Edit Current State</h4>
                        		        </div>
                        		        <form method="post" action="{{ route('updateCurrentState') }}"  id="form1">
                                        {{ csrf_field() }}
                                		  <div class="modal-body">

                                		        <div class="box-body">
                                    		        <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Name of State</label>
                                                            <input type="text" name="stateName" class="form-control" value="{{ $listState->state }}" required/>
                                                            <input type="hidden" name="stateID" value="{{$listState->stateID}}"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>State Address</label>
                                                            <input type="text" value="{{ $listState->address }}" name="stateAddress" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">  <br />
                                                            <label>Bank Name</label>
                                                            <select name="bankName" class="form-control" required>
                                                                <option>Select</option>
                                                                @if(isset($currentBank))
                                                                    @foreach($currentBank as $listBank)
                                                                       <option value="{{ $listBank->bankID }}" {{ (($listState->stateBankID == $listBank->bankID) ? 'selected': '') }} >{{ $listBank->bank }}   {{ ($listBank->Bankcode ? '  -  ('. $listBank->Bankcode .')' : '') }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6"> <br />
                                                            <label>Account Number</label>
                                                            <input type="number" value="{{ $listState->account_no }}" name="accountNumber" class="form-control" required/>
                                                        </div>
                                                    </div>
                                                     <div class="row">
                                                        <div class="col-md-6">  <br />
                                                            <label>Status</label>
                                                            <select name="stateStatus" class="form-control">
                                                                <option>Select</option>
                                                                <option value="1" {{ ($listState->status == 1 ? 'selected': '') }} >Active</option>
                                                                <option value="0" {{ ($listState->status == 0 ? 'selected': '') }} >Deactivate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                		        </div>

                                		  </div>
                                		  <div class="modal-footer">
                                		       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                		       <button type="submit" class="btn btn-success">Save changes</button>
                                		  </div>
                            		    </form>
                        		    </div>
                        		  </div>
                        		</div>

                        		<!--Delete Modal -->
                        		<div class="modal fade" id="deleteModal{{$listState->stateID}}" tabindex="-1" role="dialog" aria-labelledby="Edit Record" aria-hidden="true">
                        		  <div class="modal-dialog modal-dialog-centered" role="form">
                        		    <div class="modal-content">
                        		        <div class="modal-header">
                        		            <h4 class="modal-title" id="exampleModalLongTitle">Delete Record</h4>
                        		        </div>
                        		        <form method="post" action="{{ route('updateCurrentState') }}"  id="form1">
                                        {{ csrf_field() }}
                                		  <div class="modal-body">

                                		        <div class="box-body">
                                    		        <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="text-center text-danger h4">Are you sure you want to delete this record ?</div>

                                                            <div class="text-center text-success">{{ $listState->state }}</div>
                                                        </div>
                                                    </div>
                                		        </div>

                                		  </div>
                                		  <div class="modal-footer">
                                		       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                		       <a href="{{ route('deleteState', ['id'=>$listState->stateID]) }}" class="btn btn-danger">Delete Now</a>
                                		  </div>
                            		    </form>
                        		    </div>
                        		  </div>
                        		</div>

                            @endforeach
                         @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
