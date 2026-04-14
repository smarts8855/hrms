 @if (!$userInAssignSalaryStaff && $bankAssignments->isNotEmpty() && ($user->user_type == 'Technical' || $isHOD))
     <div class="box box-default">
         <div class="box box-primary custom-card">
             <div class="box-header with-border hidden-print">
                 <div class="row">
                     <div class="col-xs-6">
                         <h3 class="box-title">
                             Bank Assignment Summary
                         </h3>
                     </div>
                 </div>
             </div>
             <div class="box-body">
                 <div class="table-responsive" style="font-size: 12px; padding:10px;">
                     {{-- <h4 class="mt-5">Bank Assignment Summary</h4> --}}

                     <table class="table table-bordered table-striped table-highlight">
                         <thead>
                             <tr bgcolor="#c7c7c7">
                                 <th>S/N</th>
                                 <th>Staff</th>
                                 {{-- <th>Division</th> --}}
                                 <th>Bank</th>
                                 <th>Total Staff (Bank)</th>
                                 <th>Checked</th>
                                 <th>Not Checked</th>
                             </tr>
                         </thead>

                         @php $serialNum = 1; @endphp
                         {{-- If no rows OR all have totalStaff = 0 --}}
                         @if ($bankAssignments->isEmpty() || $bankAssignments->sum('totalStaff') == 0)
                             <tr>
                                 <td colspan="7" class="text-center text-danger">No Records found...</td>
                             </tr>
                         @else
                             @foreach ($bankAssignments as $row)
                                 <tr>
                                     <td>{{ $serialNum++ }}</td>
                                     <td>{{ $row->staffName }}</td>
                                     {{-- <td>{{ $row->divisionName }}</td> --}}
                                     <td>{{ $row->bankName }}</td>
                                     <td>{{ $row->totalStaff }}</td>
                                     <td>{{ $row->checkedStaff }}</td>
                                     <td>{{ $row->totalStaff - $row->checkedStaff }}</td>
                                 </tr>
                             @endforeach
                         @endif

                     </table>
                 </div>
             </div>
         </div>
     </div>
 @endif
