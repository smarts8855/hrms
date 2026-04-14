<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exported Rows</title>

    <style>
        /* Add your CSS styles here for PDF layout */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="row">
        @if (!empty($rowData))
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title" style="text-align: center">All Submitted Needs</h2>
                    <hr>

                    <?php $currentDepartment = null; ?>
                    @foreach ($rowData as $key => $row)
                        @if($row->department_name != $currentDepartment)
                            @if($currentDepartment !== null)
                                </table> <!-- Close the previous table -->
                            @endif
                            <?php $currentDepartment = $row->department_name; ?>
                            <h4 style="text-align: center;">Department: {{ $currentDepartment }}</h4>
                            <div align="center" class="form-group mb-0 col-md-12">
                                <table class="table table-hover table-responsiv table-bordered" id="exportTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">SN</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Brief Justification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        @endif
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row->category ?? '' }}</td>
                            <td>{{ $row->item ?? '' }}</td>
                            <td>{{ $row->description ?? '' }}</td>
                            <td>{{ $row->quantity ?? '' }}</td>
                            <td>{{ $row->brief_justification ?? '' }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
    <p>No data available for export.</p>
@endif
</div>
</body>

</html>
