@extends('layouts.layout')

@section('pageTitle')
    ARCHIVES
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>View archived Files. </em></strong></h3>
            </div>
            <div class="box-body">
                <div class="row">

                    @includeIf('Share.message')


                </div><!-- /.row -->

                <div class="box-body">
                    <div class="row">
                        <div style="margin-left: 15px;">SEARCH ARCHIVE:</div>
                        <div id="success"></div>
                        <div class="col-md-12">
                            <!--2nd col-->
                            <form method="GET" action="{{url('/search-archive')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        {{-- <div class="form-group">
                                            <label for="title">File No.</label>
                                            <input type="text" placeholder="File No." id="fileNo" name="fileNo"
                                                class="form-control" />
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="month">File No.</label>
                                            <select name="fileNo" id="fileNo" class="form-control select2">
                                            <option value="">Select One</option>
                                                @foreach($archives as $a)
                                                <option value="{{$a->fileNo}}" @if(old('fileNo') == $a->fileNo) selected @endif>{{$a->fileNo}} -- {{$a->file_description}}</option>
                                                @endforeach
    
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-2" style="text-align: center;">OR</div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Coach No.</label>
                                            <input type="text" placeholder="Coach No." id="coachNo" name="coachNo"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-9">
                                            <div align="right" class="form-group">
                                                <label for="month">&nbsp;</label><br />
                                                <button name="action" id="searchBtn" class="btn btn-success" type="submit">
                                                    Search Archives <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center"><strong> <u>ALL FILES IN ARCHIVE</u> </strong></h4>
                        <p class="card-title-desc"></p>
                        @csrf
                        <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>

                                    <th>FILE NO.</th>
                                    <th>DESCRIPTION</th>
                                    <th>VOLUME NO.</th>
                                    <th>COACH NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($archives) && $archives)
                                    @foreach ($archives as $key => $list)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $list->fileNo }}</td>
                                            <td>{{ $list->file_description }}</td>
                                            <td>{{ $list->volume_name }}</td>
                                            <td>{{ $list->shelve_number }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Modal to delete -->
                        <div class="modal fade text-left d-print-none" id="confirmPush" tabindex="-1" role="dialog"
                            aria-labelledby="confirmToSubmit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-success text-center">
                                            <h4>Are you sure you want to push this record(s)? </h4>
                                        </div>
                                        <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
                                        <input type="hidden" name="getInterviewID"
                                            value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success"> Push Now </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end Modal-->

                    </div>
                </div>
            </div>
        </div>
        <form id="getCandidateForm" method="post" action="{{ url('/get-candidate-for-interview') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="inverviewName" id="inverviewName" />
        </form>

    @endsection

    @section('styles')
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    @endsection
    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $('.select2').select2();
        </script>
    @endsection
