@extends('layouts.layout')
@section('pageTitle')
    Promotions
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Staff Promotion.</em></strong></span></h3>
        </div>


        @if (session('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Successful!</strong> {{ session('message') }}
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Error!</strong> {{ session('error_message') }}
            </div>
        @endif


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

        <form method="post" action="{{ route('promotionCreate') }}" class="form-horizontal">
            {{ csrf_field() }}
            <div class="box-body">

                <div class="form-group" style="margin-left:10px; margin-right:10px">
                    <div class="form-group row">

                        <div class="col-lg-10"
                            style="width: 95%; height: 200px; border: 1px solid black; overflow: scroll;">
                            <br>
                            @foreach ($designation as $b)
                                <span class="btn btn-outline-success" style="border: 1px solid green; margin:2px;">
                                    <input type="checkbox" id="designation" name="designation[]"
                                        value="{{ $b->id }}">&nbsp;&nbsp;

                                    <span> {{ $b->designation }}</span>
                                </span>
                            @endforeach

                        </div>

                        <div class="col-lg-12" style="margin-top:23px;">
                            <button type="submit" class="btn btn-success btn-block" name="Save">
                                <i class="fa fa-btn fa-floppy-o"></i> Forward To Admin
                            </button>
                        </div>


                    </div>


                </div>

        </form>

        <div class="table-responsive" style="font-size: 11px; padding:5px;">
            <table class="table table-bordered table-striped table-highlight">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>
                        <!-- <th >Department</th> -->
                        <th>POSITION</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                @php $serialNum = 1; @endphp

                @foreach ($staffDetails as $b)
                    <tr>
                        <td>{{ $serialNum++ }}</td>
                        <!-- <td>{{ $b->department }} </td> -->
                        <td>{{ $b->designation }}</td>
                        <td>
                            <span promotionId="{{ $b->promotionID }}" position="{{$b->designation}}" class="btn btn-danger delBtn"
                                data-toggle="modal" data-target="#delModal">
                                <i class="fa fa-btn fa-trash"></i>
                            </span>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('position.delete')}}" method="post">
                    @csrf
                    @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Delete Warning!!!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the <strong id="delName"></strong> position?
                            <input type="hidden" name="promotionId" id="promotionId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        {{-- END Modal --}}

    </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#state").change(function(e) {

                //console.log(e);
                var state_id = e.target.value;
                //var state_id = $(this).val();

                //alert(state_id);
                //$token = $("input[name='_token']").val();
                //ajax
                $.get('../get-lga-from-state?state_id=' + state_id, function(data) {
                    $('#lga').empty();
                    //console.log(data);
                    $('#lga').append('<option value="">Select One</option>');
                    $.each(data, function(index, obj) {
                        $('#lga').append('<option value="' + obj.lgaId + '">' + obj.lga +
                            '</option>');
                    });


                })
            });

            $(".delBtn").click(function (e) {
                e.preventDefault();

                var id = $(this).attr('promotionId');
                var position = $(this).attr('position');

                $("#promotionId").val(id);
                $("#delName").html(position);
            });

        });

    </script>
@endsection
