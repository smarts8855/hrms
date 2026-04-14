@extends('layouts.app')
@section('pageTitle', 'Procurement')
@section('pageMenu', 'active')
@section('content')
@include('Bank.layouts.messages')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Contractor Name</th>
                        <th>Approved Amount</th>
                        <th>Approval Date</th>
                       
                        <th>Action</th>
                      
                    </tr>
                    </thead>


                    <tbody>
                        <p style="display:none">{{$counter=0}}</p>
                        @foreach($datas as $data)
                        
                   <tr>
                        <td>{{$counter=$counter+1}}</td>
                        <td>{{$data->company_name}}</td>
                       <td style="text-align:right">{{number_format($data->awarded_amount,2)}}</td>
                         
                        <td style="text-align:right">{{$data->approval_date}}</td>
                        <td><a class="btn btn-primary btn-sm" href={{'/procurement/award/'.encrypt($data->approvalID)}}> View </a></td>
                    </tr>
                        @endforeach
                    
                    

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('styles')
   
@endsection

@section('scripts')
@endsection