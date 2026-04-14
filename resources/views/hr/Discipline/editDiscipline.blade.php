@extends('layouts.layout')

@section('pageTitle')
    Edit Staff Discipline
@endsection

<style type="text/css">
    .length {
        width: 80px;
    }

    .remove {
        padding-top: 12px;
        cursor: pointer;
    }

</style>

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>



                    @includeIf('Share.message')



                        {{-- start of form --}}
                        <div class="col-md-12">
                            <form method="post" action="{{url('/discipline-update') }}"  id="formID" class="form-horizontal">
                                @csrf
                                <div class="col-md-6" id="statec" >
                                    <label for="staffname" id=lstaffname class="form-label">Staff Name </label>
                                    <input type="text" class="form-control" id="staffname" name="staffname" placeholder="state code"
                                    value="{{$value->offenderfirstname}} {{$value->offendersurname}}" disabled >
                                </div>
                                <input type="hidden" id="disciplineid"  name="id" value={{$value->id}}>
                                <input type="hidden" id="offenderid"  name="offenderid" value={{$value->offenderid}}>

                                <div class="col-md-6" id="statec" >
                                    <label for="staffid" id=lstaffname class="form-label">File No </label>
                                    <input type="text" class="form-control" id="fileNo" name="fileNo" placeholder="state code"
                                    value="{{$value->fileNo}}"   disabled >
                                </div>


                                <div class="col-md-6">
                                    {{-- <div class="form-outline mb-4"> --}}
                                    <label for="offense" class="form-label">offense</label>
                                    <textarea class="form-control" id="form6Example7" rows="4" name="offense" value="{{$value->offense}}" required>{{$value->offense}}</textarea>
                                    {{-- <label class="form-label" for="form6Example7">Enter offense</label> --}}
                                    {{-- </div> --}}
                                </div>

                                <div class="col-md-6">
                                    {{-- <div class="form-outline mb-4"> --}}
                                    <label for="discipline" class="form-label">Discipline</label>
                                    <textarea class="form-control" id="form6Example7" rows="4" name="discipline" value="{{$value->discipline}}" required>{{$value->discipline}}</textarea>
                                    {{-- <label class="form-label" for="form6Example7">Enter Disciplinary Measures</label> --}}
                                    {{-- </div> --}}
                                </div>


                                <div class="col-md-6">
                                    <label for="pop" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startdate" name="startdate"
                                        aria-label="Server" placeholder="set discipline start date" class="form-control" value="{{$value->startdate}}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="pop" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="enddate" name="enddate" aria-label="Server"
                                        placeholder="set discipline end date" class="form-control" value="{{$value->enddate}}"  required>
                                </div>


                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div align="right" class="col-md-6 form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <a href="{{url('discipline')}}" class="btn btn-primary">
                                        Go Back <i class="fa fa-refresh"></i>
                                    </a>
                                </div>

                            </div>

                                <div  class="col-md-6">
                                <div  align="right" class=" col-md-6 form-group">
                                    <label for="month">&nbsp;</label><br />
                                        <button name="action" class="btn btn-success" type="submit">
                                        Update <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr />
        <hr />
    </div>
    </div><!-- /.col -->
    </div><!-- /.row -->


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection


    <script type="text/javascript" src = "{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script >
    function showcategory(str) {
     if (str == "Nysc") {
        $("#statec").css('display', 'block');

        return;
     }else{
        $("#statec").css('display', 'none');
       }
      }

    $(document).ready(function(){
        let cat = $('#newCategory').val()
        if(cat == 'IT'){
            $('#statec').hide()
        }
        // console.log('good');
    })

    </script>

