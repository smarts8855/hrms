<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.layout')

@section('pageTitle')
    TRAINING
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Search Training Report.</em></strong> </span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div style="margin-left: 15px;">SEARCH BY:</div>
                    @includeIf('Share.message')
                    <div id="success"></div>
                    <div class="col-md-12">
                        <!--2nd col-->
                        <form method="" action="">
                            @csrf
                            <div class="row">
                                <div class="col-md-1"></div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Training Title</label>
                                        <input type="text" placeholder="title" id="title" name="title"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align: center;">OR</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="text" placeholder="2022" id="year" name="year"
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
                                            <button name="action" id="searchBtn" class="btn btn-success" type="button">
                                                Search Training <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <em class="text-warning" id="nothingFound"></em>
            <table class="table table-bordered table-striped" id="holidayTable" width="100%">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>TITLE</th>
                        <th>TRAINING DATE</th>
                        <th>YEAR</th>
                        <th>CONCLUDED</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>

            </table>

        </div>
    </div>


    <!-- Missing fields Modal -->
    <div id="missingFields" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Invalid Search Parameters</h5>
                </div>

                <div class="modal-body">
                    <p style="margin-left:30px">Please try again!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" ></script>

<script type="text/javascript">
    $(document).ready(function() {

        function fetchHolidays() {
            $.ajax({
                type: "GET",
                url: "/get-all-report",
                dataType: "json",
                success: function(response) {
                    $('tbody').html('');
                    $.each(response.data, function(key, item) {
                        $('tbody').append(`<tr>
                            <td>${key + 1}</td>
                            <td>${item.title}</td>
                            <td>${ moment(item.training_date).format('DD-MM-YYYY')}</td>
                            <td>${item.date}</td>
                            <td>${item.date_concluded}</td>
                            <td><a href="/generate-report/${item.ID}"><button type="button" value="${item.ID}" id="edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHoliday">View Selected Staff <span class="fa fa-eye"></span></button></a>
                                <a target="_blank"  href="{{ asset('/trainingAttachment/${item.attendance_attachment}') }}"><button type="button" class="btn btn-primary btn-sm"> View Attendance <span class="fa fa-print"></span></button></a>
                            </td>
                         </tr>`);
                    });
                }
            });
        }

        fetchHolidays();

        $(document).on('click', '#searchBtn', function(e) {
            e.preventDefault()

            let title = $('#title').val()
            let year = $('#year').val()
            // console.log(title)
            // console.log(year)

            if (title == '' && year == '') {
                jQuery('#missingFields').modal('show');
                // alert('Please You must search by Title Or Year');
            }

            if (title != '') {

                $.ajax({
                    type: "GET",
                    url: `search-training-by-title/${title}`,
                    dataType: "json",
                    success: function(response) {
                        if(response.byTitle.length>0){
                            $('tbody').html('');
                            $.each(response.byTitle, function(key, item) {
                                $('tbody').append(`<tr>
                                <td>${key + 1}</td>
                                <td>${item.title}</td>
                                <td>${item.training_date}</td>
                                <td>${item.date}</td>
                                <td>${item.date_concluded}</td>
                                <td><a href="/generate-report/${item.ID}"><button type="button" value="${item.ID}" id="edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHoliday">View Selected Staff <span class="fa fa-eye"></span></button></a>
                                    <a target="_blank"  href="{{ asset('/trainingAttachment/${item.attendance_attachment}') }}"><button type="button" class="btn btn-primary btn-sm"> View Attendance <span class="fa fa-print"></span></button></a>
                                </td>

                            </tr>`);
                            });
                            $('#title').val('')
                        }else{
                            $('#nothingFound').text('No training was found')
                        }
                       
                    }
                });

            } else if (year != '') {
                $.ajax({
                    type: "GET",
                    url: `search-training-by-year/${year}`,
                    dataType: "json",
                    success: function(response) {
                        if(response.byYear.length>0){
                            $.each(response.byYear, function(key, item) {
                            $('tbody').append(`<tr>
                            <td>${key + 1}</td>
                            <td>${item.title}</td>
                            <td>${item.training_date}</td>
                            <td>${item.date}</td>
                            <td>${item.date_concluded}</td>
                            <td><a href="/generate-report/${item.ID}"><button type="button" value="${item.ID}" id="edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHoliday">View Selected Staff <span class="fa fa-eye"></span></button></a>
                                <a target="_blank"  href="{{ asset('/trainingAttachment/${item.attendance_attachment}') }}"><button type="button" class="btn btn-primary btn-sm"> View Attendance <span class="fa fa-print"></span></button></a>
                            </td>

                            </tr>`);
                            });
                            $('#year').val('')
                        }else{
                            $('#nothingFound').text('No training was found')
                        }
                        $('tbody').html('');
                        
                    }
                });
            }
        });


    });
</script>
