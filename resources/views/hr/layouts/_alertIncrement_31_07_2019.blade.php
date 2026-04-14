@php
                    $curDay     = date('d');
                    $dayDue     = ($curDay - (date('d', strtotime($list->appointment_date))));
                    if($dayDue >= 0)
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->appointment_date);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        // Get the Number of day(s) staff has due for increment  
                        //(($appDate->diffInDays($todayDate) - $appDate->diffInDays($todayDate)) + $dayDue)
                        $get_diff_in_days = ($dayDue);
                        if($get_diff_in_days == 0){
                          $diff_in_days ="Today";
                        }else if($get_diff_in_days == 1){
                          $diff_in_days = $get_diff_in_days . ' day ago';
                        }else{
                          $diff_in_days = $get_diff_in_days . ' days ago';
                        }

                        //
                            //check if increament date is due for promotion
                        //

                        // Is (Appoint Month and Appoint Day) == (Today's day and Month) 
                        if( (date('d', strtotime($list->appointment_date))) == (date('d')) and 
                            (date('m', strtotime($list->appointment_date))) == (date('m')) and 
                            (DB::table('tblper')->where('fileNo', $list->fileNo)->where('step', '<', 15)->first()) ){
                            $alertForIncrement = '<small>Increment</small> <br />'. $diff_in_days;
                            DB::table('tblper')->where('fileNo', $list->fileNo)->update(array(
                                'stepalert'         => (($list->step) + 1),
                                'gradealert'        => ($list->grade),
                                'variationreason'   => ('Increment')
                            ));
                        }else{
                            // Is step == stepalert 
                            //$stepCheck = DB::table('tblper')->where('fileNo', $list->fileNo)->select('stepalert')->first();
                            if( (DB::table('tblper')->where('fileNo', $list->fileNo)->whereRaw('tblper.step = tblper.stepalert')->count()) > 0)
                            {
                              $alertForIncrement = '';
                            }else{
                               // Is (Appoint Month and Appoint Day) != (Today's day and Month) BUT still in the same Month 
                              if( (date('m', strtotime($list->appointment_date))) == (date('m')) and 
                                  (DB::table('tblper')->where('fileNo', $list->fileNo)->where('step', '<', 15)->first()) )
                              {
                                $alertForIncrement = '<small>Increment</small> <br />'. $diff_in_days;
                                DB::table('tblper')->where('fileNo', $list->fileNo)->update(array(
                                  'stepalert'         => (($list->step) + 1),
                                  'gradealert'        => ($list->grade),
                                  'variationreason'   => ('Increment')
                                ));
                              }
                              else{
                                $alertForIncrement = '';
                              }

                            }
                        }
                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="blink-text">{!! $alertForIncrement !!}</div>
                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( (date('d', strtotime($list->appointment_date))) == (date('d') + 01) and 
                            ((date('m', strtotime($list->appointment_date))) == (date('m'))) and 
                            (DB::table('tblper')->where('fileNo', $list->fileNo)->where('step', '<', 15)->first()) )
                        {
                            $alertForIncrement = '<small>Increment</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              <td class="hidden-print">
                                <div align="center" style="color: green;">{!! $alertForIncrement !!}</div>
                              </td>
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <td class="hidden-print"></td>
                             @php 
                        }
                    } 
                    @endphp