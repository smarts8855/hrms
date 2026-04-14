
@php
//$list->first_name;
                     $curDay    = date('d');
                    $curmonth   = date('m');
                    $dayDue     = ($curDay - (date('d', strtotime($list->date_present_appointment))));

                      $realday = date('d', strtotime($list->date_present_appointment));
                     $realmonth = date('m', strtotime($list->date_present_appointment));
                     $f_app    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_first_appointment);
                      $now = \Carbon\Carbon::now();

                     $length = $f_app->diffInDays($now);

                     //check if grade level is less than 3 and or equall to 6
                     if($list->grade > 3 && $list->grade <= 6)
                     {

                     
                    if($length > 730 && $length <= 801 && $realmonth === $curmonth)
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->appointment_date);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        
                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="level 3-4 Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'level 3-4 day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'level 3-4 days ago';
                        }

                        
                  

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="">
                              <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  <br/>
                  <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>


                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Increment</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              <td class="hidden-print">
                                <div align="center" style="color: green;">
                                  <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  <br/>
                  <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                                </div>
                              </td>
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <td class="hidden-print"></td>
                             @php 
                        }
                    }
                    }

                    //check if grade level is greater than 6 and or less than 14
                    else if($list->grade > 6 && $list->grade < 14)                     {

                     
                    if($length > 1096 && $length <= 1126 && $realmonth === $curmonth)
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->appointment_date);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        
                        
                          
                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="level 7 - 14 Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'level 7 - 14 day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'level 7 - 14 days ago';
                        }

                        
                  

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="">
                              <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  <br/>
                  <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                            </div>
                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Increment</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              <td class="hidden-print">
                                <div align="center" style="color: green;">
                                  <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                                 <br/>
                                <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                                </div>
                              </td>
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <td class="hidden-print"></td>
                             @php 
                        }
                    }
                    }


                    else if($list->grade > 13 && $list->grade <= 17)                     {

                     
                    if($length > 1460 && $length <= 1492 && $realmonth === $curmonth)
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->appointment_date);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        
                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="level  14 - 17 Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'level 14 - 177 - 14 day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'level 14 - 17 days ago';
                        }

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="">
                              <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  <br/>
                  <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                            </div>
                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Increment</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              <td class="hidden-print">
                                <div align="center" style="color: green;">
                                  <a href="{{url('/estab/staff/profile/'.$list->fileNo)}}" class="btn btn-primary btn-xs"><i class="fa fa-eye text-enter"></i></a>
                  <br/>
                  <a href="javascript:void" style="margin-top: 20%;" class="btn btn-success btn-xs promote" id="{{$list->fileNo}}"><i class="fa fa-edit"></i></a>
                                </div>
                              </td>
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <td class="hidden-print"></td>
                             @php 
                        }
                    }
                    }
                    @endphp

                    