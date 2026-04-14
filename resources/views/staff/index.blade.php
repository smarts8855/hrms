<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SCN-GRP</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/_all-skins.min.css') }}">

        <style>
            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                form,
                .no-print,
                button,
                input {
                    display: none !important;
                }

                table,
                tr,
                td,
                th {
                    border: 1px solid #000 !important;
                }
            }
        </style>
    </head>

    <body class="hold-transition skin-green sidebar-mini">
        <div>
            <header class="main-header">
                <nav class="navbar navbar-static-top" style="background: #0B610B">
                    <div align="center" style="color: #fff; font-size: 26px; padding: 10px;">
                        <b>Government Resource Planning</b>
                        <div style="font-size: 18px;">
                            <h2>SCN-GRP</h2>
                        </div>
                    </div>
                </nav>
            </header>

            <div>
                <section>
                    <div class="box box-default">
                        <div class="container">
                            <h4>Select Staff</h4>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Staff No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($staffs as $staff)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $staff->fileNo }}</td>
                                            <td>{{ $staff->title }} {{ $staff->surname }} {{ $staff->first_name }}
                                                {{ $staff->othernames }}</td>
                                            <td>
                                                <a href="{{ route('staff.documents', $staff->ID) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Documents
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <br><br><br>
                <br><br><br>
                <br><br><br>
            </div>
        </div>

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script>
            var eduIndex = 1;
            var attIndex = 1;

            // ADD EDUCATION
            $('#addEducation').on('click', function() {
                var row = $('.educationRow:first').clone();
                row.find('input, select').val('');
                row.html(row.html().replace(/\[0\]/g, '[' + eduIndex + ']'));
                $('#educationWrapper').append(row);
                eduIndex++;
            });

            // REMOVE EDUCATION
            $(document).on('click', '.remove-education', function() {
                if ($('.educationRow').length === 1) {
                    alert('At least one education record is required.');
                    return;
                }
                $(this).closest('.educationRow').remove();
            });

            // ADD ATTACHMENT
            $('#addAttachment').on('click', function() {
                var row = $('.attachmentRow:first').clone();
                row.find('input').val('');
                row.html(row.html().replace(/\[0\]/g, '[' + attIndex + ']'));
                $('#attachmentWrapper').append(row);
                attIndex++;
            });

            // REMOVE ATTACHMENT
            $(document).on('click', '.remove-attachment', function() {
                if ($('.attachmentRow').length === 1) {
                    alert('At least one attachment is required.');
                    return;
                }
                $(this).closest('.attachmentRow').remove();
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#searchStaff').on('click', function(e) {
                    e.preventDefault();

                    let fileNo = $('#fileNo').val().trim();
                    if (!fileNo) {
                        alert('Enter file number');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('staff.search.fileNo') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
                            fileNo: fileNo
                        },
                        success: function(res) {
                            if (res.status) {
                                $('#staffInfo').show();
                                $('#staffName').text(
                                    `${res.data.title} ${res.data.surname} ${res.data.first_name} ${res.data.othernames}`
                                );
                                $('#staffFile').text(res.data.fileNo);
                                $('#staff_id').val(res.data.ID);
                                $('#file_no').val(res.data.fileNo);
                            }
                        },
                        error: function(xhr) {
                            $('#staffInfo').hide();
                            if (xhr.status === 404) {
                                alert('Staff not found');
                            } else {
                                console.error(xhr.responseText);
                                alert('An error occurred, check console for details');
                            }
                        }
                    });
                });
            });
        </script>
    </body>

</html>
