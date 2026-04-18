{{-- <form action="{{ url('save-attachment') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step3">
        <div class="col-md-offset-0">
            <h3 class="text-success text-center">
                <i class="glyphicon glyphicon-envelope"></i> <b>Document Attachment</b>
            </h3>
            <div align="right" style="margin-top: -35px;">
                Field with <span class="text-danger"><big>*</big></span> is important
            </div>
        </div>
        <div class="col-xs-12">
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
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Submission Successful!</strong>
                    {{ session('message') }}
                </div>
            @endif

        </div>

        <p>&nbsp;</p>
        <p>
        <div class="row">
            <input type="hidden" id="staffid" name="fileNo" value="{{ $fileNo }}" class="form-control">


            <div class="col-md-6">
                <label for="desc">File Description <span style="color:red">*</span></label>

                @php
                    $filedescs = [
                        'Application Letter',
                        'Letter of Appointment',
                        'Birth Certificate',
                        'Certificate of Indigene',
                        'GEN 75',
                        'NIN Slip',
                    ];
                @endphp

                <select id="desc" name="description" class="form-control input-lg" required>
                    <option value="">-- Select --</option>

                    @foreach ($filedescs as $filedesc)
                        <option value="{{ $filedesc }}" {{ old('description') == $filedesc ? 'selected' : '' }}>
                            {{ $filedesc }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-6">
                <label for="title">Attach Document<span style="color:red">*</span></label>

                <input class="form-control input-lg" type="file" name="filename" multiple required>

            </div>
            <p>&nbsp;</p>
            <div style="" class="col-md-2"><button type="submit" class="btn btn-success form-control"
                    style="cursor:pointer">Upload</button></div>

        </div>
</form> --}}

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-envelope"></i>
            <b>Document Attachment</b>
        </h3>
    </div>

    <div class="panel-body">

        <form action="{{ url('save-attachment') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-xs-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <strong>Submission Successful!</strong> {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>

            <input type="hidden" id="staffid" name="fileNo" value="{{ $fileNo }}">

            <div class="row">

                <div class="col-md-6">
                    <label for="desc">File Description <span class="text-danger">*</span></label>

                    @php
                        $filedescs = [
                            'Application Letter',
                            'Letter of Appointment',
                            'Birth Certificate',
                            'Certificate of Indigene',
                            'GEN 75',
                            'NIN Slip',
                        ];
                    @endphp

                    <select id="desc" name="description" class="form-control input-md" required>
                        <option value="">-- Select --</option>
                        @foreach ($filedescs as $filedesc)
                            <option value="{{ $filedesc }}" {{ old('description') == $filedesc ? 'selected' : '' }}>
                                {{ $filedesc }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="title">Attach Document <span class="text-danger">*</span></label>
                    <input class="form-control input-md" type="file" name="filename" multiple required>
                </div>

                <div class="col-md-2" style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary btn-md form-control">
                        Upload
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<br>
{{-- <br> --}}
{{-- <div class="row">
    <div class="table-responsive col-md-8 col-md-offset-2">
        <table id="mytable" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr bgcolor="#c7c7c7">
                    <th>S/N</th>

                    <th>ATTACHMENT</th>


                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp


                @foreach ($staffDETAILS as $p)
                    <tr>
                        <td>{{ $i++ }}</td>

                        <td>
                            <a href="{{ $p->filepath }}" target='_blank'> <span class="fa fa-file"></span>
                                {{ $p->filedesc }}</a> |
                            <a onclick="deleteFunction('{{ $p->id }}')" style="color:red;cursor:pointer"><i
                                    class="fa fa-trash"></i> Remove</a>
                        </td>

                        </a>
                        </td>

                    </tr>
                @endforeach


            </tbody>

        </table>
        <div class="hidden-print"></div>
    </div>
</div>
</div>
</p>


</div> --}}

<div class="row">
    <div class="col-md-12">

        <!-- Bootstrap 3 Card (Panel) -->
        <div class="panel panel-primary">

            <!-- Card Header -->
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-paperclip"></i>
                    Staff Attachments
                </h3>
            </div>

            <!-- Card Body -->
            <div class="panel-body table-responsive">

                <table id="mytable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr style="background:#c7c7c7;">
                            <th>S/N</th>
                            <th>Attachment</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $i = 1; @endphp

                        @foreach ($staffDETAILS as $p)
                            <tr>
                                <td>{{ $i++ }}</td>

                                <td>
                                    <a href="{{ $p->filepath }}" target="_blank">
                                        <span class="fa fa-file"></span>
                                        {{ $p->filedesc }}
                                    </a>
                                    &nbsp; | &nbsp;

                                    <a onclick="deleteFunction('{{ $p->id }}')"
                                        style="color:red; cursor:pointer;">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div> <!-- panel-body -->

        </div> <!-- panel -->

    </div>
</div>

<form action="{{ url('/documentation-attachment') }}" method="POST">
    {{ csrf_field() }}
    </p>
    <hr />
    <div align="center">
        <ul class="list-inline">
            <li><a href="{{ url('/documentation-previous-employment') }}" class="btn btn-default">Previous</a></li>
            <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
        </ul>
    </div>
    </div>

    <input type="hidden" id="appt_count" name="appt_count" value=1>
</form>

<styles>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

</styles>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

<script>
    function deleteFunction(id) {

        var y = confirm("Do you want to delete this file?");
        if (y == true) {
            document.location = 'delete-attachement/' + id;
        }
    }

    $(document).ready(function() {
        $('input[id$=fromPrevEmpy]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmp2y]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmpy]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmp2y]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmpx]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmp2x]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmpx]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmp2x]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmpa]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmp2a]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmpa]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmp2a]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmpb]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=fromPrevEmp2b]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmpb]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });

    $(document).ready(function() {
        $('input[id$=toPrevEmp2b]').datepicker({
            dateFormat: 'dd-mm-yy' // Date Format "dd-mm-yy"
        });
    });
</script>

<script>
    function addRows() {
        var count = document.getElementById('appt_count').value;
        var app = [];
        for (i = 0; i < count; i++) {
            try {
                var json_arr = {};
                json_arr["countid"] = i;
                json_arr["name"] = document.getElementById('appname' + i).value;
                json_arr["address"] = document.getElementById('appaddress' + i).value;
                json_arr["phoneno"] = document.getElementById('appphoneno' + i).value;
                json_arr["email"] = document.getElementById('appemail' + i).value;
                var json_string = JSON.stringify(json_arr);
                app.push(json_string);
            } catch (e) {
                // Code to run if an exception occurs
            } finally {
                // Code that is always executed regardless of
                // an exception occurring
            }

        }
        //alert(app);
        document.getElementById('appt_count').value = parseInt(count) + 1;
        var table = document.getElementById('myTable1');
        var row = table.getElementsByTagName('tr');
        var row = row[row.length - 1].outerHTML;
        table.innerHTML = table.innerHTML + row;
        var row = table.getElementsByTagName('tr');
        var row = row[row.length - 1].getElementsByTagName('td');
        row[0].innerHTML = '<input type="text" class="form-control input-lg " placeholder="" name="appname' + count +
            '" id="appname' + count +
            '"    style="width:250px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
        row[1].innerHTML = '<input type="text" class="form-control input-lg"  placeholder=""  name="appaddress' +
            count + '" id="appaddress' + count +
            '"   style="width:300px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
        row[2].innerHTML = '<input type="text" class="form-control input-lg" placeholder=""  name="appphoneno' + count +
            '" id="appphoneno' + count +
            '"    style="width:150px; padding:0; margin:0;font-size:16px;" autocomplete="off" >'
        row[3].innerHTML =
            '<div class="input-group mb-3"><input type="text" class="form-control input-lg" name="appemail' + count +
            '" id="appemail' + count +
            '"  placeholder="email" aria-label="Username" aria-describedby="basic-addon1"><div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button" onclick="addRows()">+</button><button class="btn btn-outline-secondary" type="button" id="button' +
            count + '" onclick="RowDel(this)">-</button></div></div>';
        for (i = 0; i < app.length; i++) {
            var obj = JSON.parse(app[i]);
            document.getElementById('appname' + obj.countid).value = obj.name;
            document.getElementById('appaddress' + obj.countid).value = obj.address;
            document.getElementById('appphoneno' + obj.countid).value = obj.phoneno;
            document.getElementById('appemail' + obj.countid).value = obj.email;
        }

    }

    function RowDel(element) {
        var rowJavascript = element.parentNode.parentNode;
        var rowjQuery = $(element).closest("tr");
        var x = rowjQuery[0].rowIndex;
        var table = document.getElementById('myTable1');
        var row = table.getElementsByTagName('tr');
        row[x].outerHTML = '';
    }
</script>
