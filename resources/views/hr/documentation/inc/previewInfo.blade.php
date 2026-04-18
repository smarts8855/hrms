<style>
    .card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card-header {
        background: #337ab7;
        padding: 12px 15px;
        font-size: 16px;
        color: #fff;
        font-weight: bold;
        border-bottom: 1px solid #337ab7;
        border-radius: 6px 6px 0 0;
        text-transform: uppercase;
    }
    .card-body {
        padding: 15px;
    }
</style>

{{-- <form action="{{ url('/documentation-preview') }}" method="POST">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step4">
        <div align="left" class="col-md-offset-0">
            <h3 class="text-success text-center noprint">
                <i class="glyphicon glyphicon-ok"></i> <b> Documentation Complete</b>
            </h3>
        </div>
        <br />
        <p>
        <div class="row">
            @if(session('msg'))
            <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Success!</strong> <br />
            {{ session('msg') }}
            </div>
            @endif

            @if(session('err'))
            <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Operation Error !</strong> <br />
            {{ session('err') }}
            </div>
            @endif
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>BASIC INFORMATION</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td colspan="2" style="text-align:center;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if (isset($StaffNames->passport_url) && !empty($StaffNames->passport_url))
                                                            <div>
                                                                <img src="{{ asset($StaffNames->passport_url) }}"
                                                                    alt="Staff Passport"
                                                                    style="width:150px; height:180px; object-fit:cover; border:1px solid #ddd;">
                                                            </div>
                                                        @else
                                                            <div class="text-muted">No passport photo available</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if (isset($StaffNames->signature_url) && !empty($StaffNames->signature_url))
                                                            <div>
                                                                <img src="{{ asset($StaffNames->signature_url) }}"
                                                                    alt="Staff Signature"
                                                                    style="width:200px; height:80px; object-fit:contain; border:1px solid #ddd; margin-top:50px;">
                                                            </div>
                                                        @else
                                                            <div class="text-muted">No signature available</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>FILE NO.: </b></td>
                                            <td><input class="form-control input-lg" id="staffFileNo" name="staffFileNo"
                                                    value="{{ $staffFileNo }}"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Name:</b></td>
                                            <td> {{ $StaffNames->surname }} {{ $StaffNames->first_name }}
                                                {{ $StaffNames->othernames }}
                                                <input type="hidden" class="form-control input-lg" id="fullname"
                                                    name="fullname"
                                                    value="{{ $StaffNames->surname }} {{ $StaffNames->first_name }} {{ $StaffNames->othernames }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Gender: </b></td>
                                            <td>{{ $staffInfo->gender ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Birth: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->dob ?? '')) }}</td>
                                        </tr>

                                        <tr>
                                            <td width="210"><b>Employment Type: </b></td>
                                            <td>{{ $empType->employmentType ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Grade Level:</b></td>
                                            <td>{{ $staffInfo->grade ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Step: </b></td>
                                            <td>{{ $staffInfo->step ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Department: </b></td>
                                            <td>{{ $dept->department ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Designation: </b></td>
                                            <td>{{ $design->designation ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Appointment: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->appointment_date ?? '')) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of First Appointment: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->date_present_appointment ?? '')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getBasicInfo') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>CONTACT INFORMATION</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>EMAIL: </b></td>
                                            <td>{{ $staffInfo->email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ALTERNATIVE EMAIL: </b></td>
                                            <td>{{ $staffInfo->alternate_email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>PHONE: </b></td>
                                            <td>{{ $staffInfo->phone ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ALTERNATIVE PHONE: </b></td>
                                            <td>{{ $staffInfo->alternate_phone ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>PHYSICAL ADDRESS: </b></td>
                                            <td>{{ $staffInfo->home_address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getContact') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>PLACE OF BIRTH</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>STATE OF ORIGIN: </b></td>
                                            <td>{{ $UserState->State ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td><b>L.G.A.: </b></td>
                                            <td>{{ $UserLga->lga ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ADDRESS: </b></td>
                                            <td>{{ $staffInfo->permanent_addr ?? '' }}</td>
                                        </tr>

                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getPlaceOfBirth') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>EDUCATION</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">

                                        @foreach ($education as $educations)
                                            @php
                                                $filepath = 'CertificatesHeld/';
                                                $category = DB::table('tbleducation_category')
                                                    ->where('edu_categoryID', $educations->categoryID)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td width="210" colspan="4"><b>{{ $category->category }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>SCHOOL ATTENDED: </b></td>
                                                <td>{{ $educations->schoolattended ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>FROM: </b></td>
                                                <td>{{ $educations->schoolfrom ?? '' }}</td>

                                                <td><b>TO: </b></td>
                                                <td>{{ $educations->schoolto ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>QUALIFICATION: </b></td>
                                                <td>{{ $educations->degreequalification ?? '' }}</td>

                                                <td><b>CERTIFICATE: </b></td>
                                                <td> <a href="{{ $educations->document ?? '' }}" target="_blank">{{ $educations->certificateheld ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="noprint">
                                                    <a href="{{ route('getEducation') }}" class="pull-right">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>


                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>MARITAL INFORMATION</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>MARITAL STATUS: </b></td>
                                            <td>{{ $relationship }}</td>
                                        </tr>
                                        @if ($relationship == 'Married')
                                            <tr>
                                                <td><b>NAME OF SPOUSE: </b></td>
                                                <td>{{ $maritalStatus->wifename ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>SPOUSE DATE OF BIRTH: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($maritalStatus->wifedateofbirth ?? '')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>DATE OF MARRIAGE: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($maritalStatus->dateofmarriage ?? '')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>SPOUSE ADDRESS: </b></td>
                                                <td>{{ $maritalStatus->homeplace ?? '' }}</td>
                                            </tr>
                                        @endif
                                        <tr>

                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getMarital') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>



                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>NEXT OF KIN</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($nextOfKin as $nok)
                                        <tr>
                                            <td width="210"><b>FULL NAME: </b></td>
                                            <td>{{ $nok->fullname ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>PHONE NAMBER: </b></td>
                                            <td>{{ $nok->phoneno ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>RESIDENT ADDRESS:</b> </td>
                                            <td>{{ $nok->address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>RELATIONSHIP: </b></td>
                                            <td>{{ $nok->relationship ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getNextOfKin') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr style="background-color:green">
                                                <td></td>
                                                <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>Children</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($children as $child)
                                            <tr>
                                                <td width="210"><b>FULLNAME: </b></td>
                                                <td>{{ $child->fullname ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>DATE OF BIRTH: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($child->dateofbirth ?? '')) }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>GENDER:</b> </td>
                                                <td>{{ $child->gender ?? '' }}</td>
                                            </tr>

                                            <tr style="background-color:green">
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getChildren') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>Previous Employment</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($prevEmployment as $emp)
                                            <tr>
                                                <td width="210"><b>EMPLOYER: </b></td>
                                                <td>{{ $emp->previousSchudule ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>PREVIOUS PAY: </b></td>
                                                <td>{{ isset($totalPreviousPay) ? number_format($emp->totalPreviousPay, 2) : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>PERIOD OF EMPLOYMENT:</b> </td>
                                                <td>{{ date('d-m-Y', strtotime($emp->fromDate)) ?? '' }} -
                                                    {{ date('d-m-Y', strtotime($emp->toDate)) ?? '' }}</td>
                                            </tr>

                                            <tr>
                                                <td width="210"><b>FILES PAGES: </b></td>
                                                <td>{{ $emp->filePageRef ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>CHECKED BY:</b> </td>
                                                <td>{{ $emp->checkedby ?? '' }}</td>
                                            </tr>
                                            <tr style="background-color:green">
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getPrevEmployment') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>Document Attachment</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @php $filepath="/staffattachments/" @endphp
                                        @foreach ($staffAttachment as $emp)
                                            <tr>
                                                <td width="210"><b>DOCUMENT: </b></td>
                                                <td><a
                                                        href="{{ $emp->filepath ?? '' }}" target="_blank">{{ $emp->filedesc ?? '' }}</a>
                                                </td>
                                            </tr>

                                            <tr style="background-color:green">
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getAttachment') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>



                        <div class="panel panel-default">
                            <div class="panel-heading fieldset-preview"><b>Account Information</b></div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>BANK NAME: </b></td>
                                            <td>{{ $UserBank->bank ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>ACCOUNT NAMBER: </b></td>
                                            <td>{{ $staffInfo->AccNo ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getAccount') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>





                        <div class="panel panel-defaul">
                            <div class="panel-heading fieldset-preview"><b>OTHER INFORMATION</b></div>
                            <div class="panel-body">
                                @if ($otherInfo == '')
                                @else
                                    <table class="table table-striped table-hover table-responsive table-condensed">
                                        <tbody class="btn-lg">

                                            <tr>
                                                <td width="500"><b>Have you ever been convicted for any crime
                                                        before?: </b></td>
                                                <td>{{ $otherInfo->qtn1 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn1 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn2 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td width="500"><b>Have you suffered any illness?: </b></td>
                                                <td>{{ $otherInfo->qtn3 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn3 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn4 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td width="500"><b>Have you taken an undertaken to anybody to repay
                                                        money advance from education, etc?</b> </td>
                                                <td>{{ $otherInfo->qtn5 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>Are you a judgement Debtor? or are there any
                                                        write from debts outstanding against you?</b> </td>
                                                <td>{{ $otherInfo->qtn6 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn6 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn7 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><b width="500">Official Employees details of services in the
                                                        forces (if applicable): </b></td>
                                                <td>{{ $otherInfo->qtn8 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>Decoration: </b></td>
                                                <td>{{ $otherInfo->qtn9 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>What is your religion?: </b> </td>
                                                <td>{{ $otherInfo->qtn10 ?? '' }}</td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                            </tr>

                                            <tr>

                                                <td colspan="2" class="noprint">
                                                    <a href="{{ route('getOthers') }}" class="pull-right">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                <div class="clearfix"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        </p>
        <hr />
        <div align="center" class="noprint">
            <ul class="list-inline">
                <li>
                    <a href="{{ url('/documentation-others') }}" class="btn btn-default">Previous</a>
                </li>
                <li><a onclick="window.print();return false;" class="btn btn-default">Print</a></li>
                <li>
                    <button type="submit" class="btn btn-primary btn-info-full">Submit</a>
                </li>

            </ul>
        </div>
    </div>
</form> --}}
<form action="{{ url('/documentation-preview') }}" method="POST">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step4">
        <div align="left" class="col-md-offset-0">
            <h3 class="text-primary text-center noprint">
                <i class="glyphicon glyphicon-ok"></i> <b> Documentation Complete</b>
            </h3>
        </div>
        <br />
        <p>
        <div class="row">
            @if(session('msg'))
            <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Success!</strong> <br />
            {{ session('msg') }}
            </div>
            @endif

            @if(session('err'))
            <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Operation Error !</strong> <br />
            {{ session('err') }}
            </div>
            @endif
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><b>BASIC INFORMATION</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td colspan="2" style="text-align:center;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if (isset($StaffNames->passport_url) && !empty($StaffNames->passport_url))
                                                            <div>
                                                                <img src="{{ asset($StaffNames->passport_url) }}"
                                                                    alt="Staff Passport"
                                                                    style="width:150px; height:180px; object-fit:cover; border:1px solid #ddd;">
                                                            </div>
                                                        @else
                                                            <div class="text-muted">No passport photo available</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if (isset($StaffNames->signature_url) && !empty($StaffNames->signature_url))
                                                            <div>
                                                                <img src="{{ asset($StaffNames->signature_url) }}"
                                                                    alt="Staff Signature"
                                                                    style="width:200px; height:80px; object-fit:contain; border:1px solid #ddd; margin-top:50px;">
                                                            </div>
                                                        @else
                                                            <div class="text-muted">No signature available</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>FILE NO.: </b></td>
                                            <td><input class="form-control input-lg" id="staffFileNo" name="staffFileNo"
                                                    value="{{ $staffFileNo }}"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Name:</b></td>
                                            <td> {{ $StaffNames->surname }} {{ $StaffNames->first_name }}
                                                {{ $StaffNames->othernames }}
                                                <input type="hidden" class="form-control input-lg" id="fullname"
                                                    name="fullname"
                                                    value="{{ $StaffNames->surname }} {{ $StaffNames->first_name }} {{ $StaffNames->othernames }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Gender: </b></td>
                                            <td>{{ $staffInfo->gender ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Birth: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->dob ?? '')) }}</td>
                                        </tr>

                                        <tr>
                                            <td width="210"><b>Employment Type: </b></td>
                                            <td>{{ $empType->employmentType ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Grade Level:</b></td>
                                            <td>{{ $staffInfo->grade ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Step: </b></td>
                                            <td>{{ $staffInfo->step ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Department: </b></td>
                                            <td>{{ $dept->department ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Designation: </b></td>
                                            <td>{{ $design->designation ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Appointment: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->appointment_date ?? '')) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of First Appointment: </b></td>
                                            <td>{{ date('d-m-Y', strtotime($staffInfo->date_present_appointment ?? '')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getBasicInfo') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>CONTACT INFORMATION</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>EMAIL: </b></td>
                                            <td>{{ $staffInfo->email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ALTERNATIVE EMAIL: </b></td>
                                            <td>{{ $staffInfo->alternate_email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>PHONE: </b></td>
                                            <td>{{ $staffInfo->phone ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ALTERNATIVE PHONE: </b></td>
                                            <td>{{ $staffInfo->alternate_phone ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>PHYSICAL ADDRESS: </b></td>
                                            <td>{{ $staffInfo->home_address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getContact') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>PLACE OF BIRTH</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>STATE OF ORIGIN: </b></td>
                                            <td>{{ $UserState->State ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td><b>L.G.A.: </b></td>
                                            <td>{{ $UserLga->lga ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ADDRESS: </b></td>
                                            <td>{{ $staffInfo->permanent_addr ?? '' }}</td>
                                        </tr>

                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getPlaceOfBirth') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>EDUCATION</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">

                                        @foreach ($education as $educations)
                                            @php
                                                $filepath = 'CertificatesHeld/';
                                                $category = DB::table('tbleducation_category')
                                                    ->where('edu_categoryID', $educations->categoryID)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td width="210" colspan="4"><b>{{ $category->category }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>SCHOOL ATTENDED: </b></td>
                                                <td>{{ $educations->schoolattended ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>FROM: </b></td>
                                                <td>{{ $educations->schoolfrom ?? '' }}</td>

                                                <td><b>TO: </b></td>
                                                <td>{{ $educations->schoolto ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>QUALIFICATION: </b></td>
                                                <td>{{ $educations->degreequalification ?? '' }}</td>

                                                <td><b>CERTIFICATE: </b></td>
                                                <td> <a href="{{ $educations->document ?? '' }}" target="_blank">{{ $educations->certificateheld ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="noprint">
                                                    <a href="{{ route('getEducation') }}" class="pull-right">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header"><b>MARITAL INFORMATION</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>MARITAL STATUS: </b></td>
                                            <td>{{ $relationship }}</td>
                                        </tr>
                                        @if ($relationship == 'Married')
                                            <tr>
                                                <td><b>NAME OF SPOUSE: </b></td>
                                                <td>{{ $maritalStatus->wifename ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>SPOUSE DATE OF BIRTH: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($maritalStatus->wifedateofbirth ?? '')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>DATE OF MARRIAGE: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($maritalStatus->dateofmarriage ?? '')) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>SPOUSE ADDRESS: </b></td>
                                                <td>{{ $maritalStatus->homeplace ?? '' }}</td>
                                            </tr>
                                        @endif
                                        <tr>

                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getMarital') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-header"><b>NEXT OF KIN</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($nextOfKin as $nok)
                                        <tr>
                                            <td width="210"><b>FULL NAME: </b></td>
                                            <td>{{ $nok->fullname ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>PHONE NAMBER: </b></td>
                                            <td>{{ $nok->phoneno ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>RESIDENT ADDRESS:</b> </td>
                                            <td>{{ $nok->address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>RELATIONSHIP: </b></td>
                                            <td>{{ $nok->relationship ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getNextOfKin') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr style="background-color:#337ab7">
                                                <td></td>
                                                <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>Children</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($children as $child)
                                            <tr>
                                                <td width="210"><b>FULLNAME: </b></td>
                                                <td>{{ $child->fullname ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>DATE OF BIRTH: </b></td>
                                                <td>{{ date('d-m-Y', strtotime($child->dateofbirth ?? '')) }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>GENDER:</b> </td>
                                                <td>{{ $child->gender ?? '' }}</td>
                                            </tr>

                                            <tr style="background-color:#337ab7">
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getChildren') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>Previous Employment</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @foreach ($prevEmployment as $emp)
                                            <tr>
                                                <td width="210"><b>EMPLOYER: </b></td>
                                                <td>{{ $emp->previousSchudule ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="210"><b>PREVIOUS PAY: </b></td>
                                                <td>{{ isset($totalPreviousPay) ? number_format($emp->totalPreviousPay, 2) : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>PERIOD OF EMPLOYMENT:</b> </td>
                                                <td>{{ date('d-m-Y', strtotime($emp->fromDate)) ?? '' }} -
                                                    {{ date('d-m-Y', strtotime($emp->toDate)) ?? '' }}</td>
                                            </tr>

                                            <tr>
                                                <td width="210"><b>FILES PAGES: </b></td>
                                                <td>{{ $emp->filePageRef ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>CHECKED BY:</b> </td>
                                                <td>{{ $emp->checkedby ?? '' }}</td>
                                            </tr>
                                            <tr style="background-color:#337ab7">
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getPrevEmployment') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><b>Document Attachment</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        @php $filepath="/staffattachments/" @endphp
                                        @foreach ($staffAttachment as $emp)
                                            <tr>
                                                <td width="210"><b>DOCUMENT: </b></td>
                                                <td><a
                                                        href="{{ $emp->filepath ?? '' }}" target="_blank">{{ $emp->filedesc ?? '' }}</a>
                                                </td>
                                            </tr>

                                            <tr style="background-color:#337ab7">
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                        @endforeach
                                        <td colspan="2" class="noprint">
                                            <a href="{{ route('getAttachment') }}" class="pull-right">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-header"><b>Account Information</b></div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-responsive table-condensed">
                                    <tbody class="btn-lg">
                                        <tr>
                                            <td width="210"><b>BANK NAME: </b></td>
                                            <td>{{ $UserBank->bank ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td width="210"><b>ACCOUNT NAMBER: </b></td>
                                            <td>{{ $staffInfo->AccNo ?? '' }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="noprint">
                                                <a href="{{ route('getAccount') }}" class="pull-right">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                        </div>





                        <div class="card">
                            <div class="card-header"><b>OTHER INFORMATION</b></div>
                            <div class="card-body">
                                @if ($otherInfo == '')
                                @else
                                    <table class="table table-striped table-hover table-responsive table-condensed">
                                        <tbody class="btn-lg">

                                            <tr>
                                                <td width="500"><b>Have you ever been convicted for any crime
                                                        before?: </b></td>
                                                <td>{{ $otherInfo->qtn1 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn1 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn2 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td width="500"><b>Have you suffered any illness?: </b></td>
                                                <td>{{ $otherInfo->qtn3 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn3 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn4 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td width="500"><b>Have you taken an undertaken to anybody to repay
                                                        money advance from education, etc?</b> </td>
                                                <td>{{ $otherInfo->qtn5 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>Are you a judgement Debtor? or are there any
                                                        write from debts outstanding against you?</b> </td>
                                                <td>{{ $otherInfo->qtn6 ?? '' }}</td>
                                            </tr>
                                            @if ($otherInfo->qtn6 == 'yes')
                                                <tr>
                                                    <td width="200"><b>Details: </b></td>
                                                    <td>{{ $otherInfo->qtn7 ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><b width="500">Official Employees details of services in the
                                                        forces (if applicable): </b></td>
                                                <td>{{ $otherInfo->qtn8 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>Decoration: </b></td>
                                                <td>{{ $otherInfo->qtn9 ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="500"><b>What is your religion?: </b> </td>
                                                <td>{{ $otherInfo->qtn10 ?? '' }}</td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                            </tr>

                                            <tr>

                                                <td colspan="2" class="noprint">
                                                    <a href="{{ route('getOthers') }}" class="pull-right">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                <div class="clearfix"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        </p>
        <hr />
        <div align="center" class="noprint">
            <ul class="list-inline">
                <li>
                    <a href="{{ url('/documentation-others') }}" class="btn btn-default">Previous</a>
                </li>
                <li><a onclick="window.print();return false;" class="btn btn-default">Print</a></li>
                <li>
                    <button type="submit" class="btn btn-primary btn-info-full">Submit</a>
                </li>

            </ul>
        </div>
    </div>
</form>
