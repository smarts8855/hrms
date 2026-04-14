@extends('layouts_procurement.app')
@section('pageTitle', 'All Needs')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('ShareView.operationCallBackAlert')
            </div>

            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>All Submitted Needs</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-list"></i> Consolidated Needs Report
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border hidden-print text-center">
                            <hr>
                        </div>

                        {{-- <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <?php $currentDepartment = null; ?>
                                @foreach ($getList as $item)
                                    @if ($item->unit != $currentDepartment)
                                        @if ($currentDepartment !== null)
                                            </tbody>
                                            </table>
                                            <div class="page-break"></div>
                                        @endif
                                        <?php $currentDepartment = $item->unit; ?>
                                        <h4 class="text-center text-primary mb-4">
                                            <i class="fa fa-building mr-2"></i>
                                            Department: {{ $currentDepartment }}
                                        </h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed table-bordered">
                                                <thead class="text-gray-b">
                                                    <tr>
                                                        <th>CATEGORY</th>
                                                        <th>ITEM</th>
                                                        <th>DESCRIPTION</th>
                                                         <th>QUANTITY</th>
                                                        <th>JUSTIFICATION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    @endif
                                    <tr>
                                        <td class="font-weight-bold">{{ $item->category }}</td>
                                        <td class="font-weight-bold">{{ $item->item }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->brief_justification }}</td>
                                    </tr>
                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                            </div>
                        </div> --}}

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">

                                @php $currentDepartment = null; @endphp

                                @foreach ($getList as $item)
                                    {{-- If department changes --}}
                                    @if ($item->department_name !== $currentDepartment)
                                        {{-- Close previous table (except first) --}}
                                        @if (!is_null($currentDepartment))
                                            </tbody>
                                            </table>
                                            <div class="page-break"></div>
                                        @endif

                                        @php $currentDepartment = $item->department_name; @endphp

                                        {{-- Department header --}}
                                        <h4 class="text-center text-primary mb-4">
                                            <i class="fa fa-building mr-2"></i>
                                            Department: {{ $currentDepartment ?? 'NA' }}
                                        </h4>

                                        {{-- Start table --}}
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed table-bordered">
                                                <thead class="text-gray-b">
                                                    <tr>
                                                        <th>CATEGORY</th>
                                                        <th>ITEM</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>QUANTITY</th>
                                                        <th>JUSTIFICATION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    @endif

                                    {{-- Table row --}}
                                    <tr>
                                        <td class="font-weight-bold">{{ $item->category ?? 'NA' }}</td>
                                        <td class="font-weight-bold">{{ $item->item ?? 'NA' }}</td>
                                        <td>{{ $item->description ?? 'NA' }}</td>
                                        <td>{{ $item->quantity ?? 'NA' }}</td>
                                        <td>{{ $item->brief_justification ?? 'NA' }}</td>
                                    </tr>
                                @endforeach

                                {{-- Close final table --}}
                                @if (!is_null($currentDepartment))
                                    </tbody>
                                    </table>
                                @endif

                            </div>
                        </div>


                        <!-- Action Buttons -->
                        <div class="box-body text-right print-hidden">
                            <div class="btn-group" role="group">
                                <button class="btn btn-secondary" onclick="window.print()">
                                    <i class="fa fa-print mr-1"></i> Print Report
                                </button>
                                <a href="{{ route('generate-needs-pdf') }}" class="btn btn-primary">
                                    <i class="fa fa-download mr-1"></i> Export to PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-break {
            page-break-before: always;
        }

        @media print {
            .print-hidden {
                display: none !important;
            }

            .box-body {
                background: #FFF !important;
                box-shadow: none !important;
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05) !important;
            }

            .text-primary {
                color: #000 !important;
            }
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>

@endsection
