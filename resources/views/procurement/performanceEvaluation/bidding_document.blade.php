@extends('layouts_procurement.app')
@section('pageTitle', 'List of Document')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card Equivalent -->
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">

                <!-- Panel Heading -->
                <div class="panel-heading" style="background:#fff; border-bottom:1px solid #ddd;">
                    <h4 class="panel-title" style="margin:0; font-weight:600;">Documents</h4>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">

                    @include('procurement.ShareView.operationCallBackAlert')

                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Description</th>
                                <th>Document</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp

                        <tbody>
                            @foreach ($getList as $list)
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->file_description }}</td>
                                    <td>
                                        <a href="https://procurement.njc.gov.ng/BiddingDocument/{{ $list->file_name }}"
                                            target="_blank">
                                            <i class="fa fa-file"></i> View File
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- panel-body -->

            </div> <!-- panel -->

        </div> <!-- col -->
    </div> <!-- row -->


    <!-- Modal  -->

    <!-- Button to Open the Modal -->
    <!-- The Modal -->
    </div>

    <!-- End Modal-->

@endsection

@section('styles')

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
