<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exported Market Survey Data</title>

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
                        <h2 class="card-title" style="text-align: center">Market Survey</h2>
                        {{-- <hr /> --}}

                        <div class="row">
                            <div align="center" class="form-group mb-0 col-md-12">
                                <table class="table table-hover table-responsiv table-bordered" id="exportTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">SN</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Specification</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Contract Price</th>
                                            <th scope="col">Market Price</th>
                                            <th scope="col">Survey Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rowData as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->item ?? '' }}</td>
                                                <td>{{ $row->specification ?? '' }}</td>
                                                <td>{{ $row->category ?? '' }}</td>
                                                <td class="text-right">
                                                    {{ number_format(floatval(str_replace(',', '', $row->price ?? '')), 2) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format(floatval(str_replace(',', '', $row->marketPrice ?? '')), 2) }}
                                                </td>
                                                <td class="text-right">
                                                    {{$row->survey_date ? date('jS M Y', strtotime($row->survey_date)) : ""}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
