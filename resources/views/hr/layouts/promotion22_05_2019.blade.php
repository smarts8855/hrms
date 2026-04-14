@php
//$list->first_name;
                     $curDay    = date('d');
                    $curmonth   = date('m');
                    $dayDue     = ($curDay - (date('d', strtotime($list->date_present_appointment))));

                      $realday = date('d', strtotime($list->date_present_appointment));
                     $realmonth = date('m', strtotime($list->date_present_appointment));
              $f_app    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                      $now = \Carbon\Carbon::now();

                     $length = $f_app->diffInDays($now);

                     //check if grade level is less than 3 and or equall to 6
                     if($list->grade > 3 && $list->grade <= 6)
                     {

                     
                    if($length > 730 && $length <= 801 && $realmonth === $curmonth)
                    {
                    $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

                        if($length == 731 && $realmonth === $curmonth)
                       {
                        $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('active','=',1)->count();
                         if($check == 0 )
                         {
                            
                            DB::table('promotion_alert')->insert(array(
                                'fileNo'        => $list->fileNo,
                                'active'        => 1,
                                'reason'        => 'Promotion',
                                'year'          => date('Y'),
                                'month'         => date('F'),
                                'date_added'    => date('Y-m-d'),
                            ));
                            

                             /*DB::table('tblper')->where('fileNo','=',$list->fileNo)->update(array(
                                'promotion_alert'        => 1,
                                
                            ));*/

                          }
                        }

                         
                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago'.$list->fileNo;
                        } 
                             

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="blink-text">{{$show}}</div>
                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Promotion:</small> <br />'. 'Tomorrow';
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
                  }

                    //check if grade level is greater than 6 and or less than 14
                    else if($list->grade > 6 && $list->grade < 14)  {

                     
                    if($length > 1096 && $length <= 1126 && $realmonth === $curmonth)
                    {
                     $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

                        if($length == 1097 && $realmonth === $curmonth)
                       {
                        $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('active','=',1)->count();if($check == 0 )
                         {
                            
                            DB::table('promotion_alert')->insert(array(
                                'fileNo'        => $list->fileNo,
                                'active'        => 1,
                                'reason'        => 'Promotion',
                                'year'          => date('Y'),
                                'month'         => date('F'),
                                'date_added'    => date('Y-m-d'),
                            ));
                            

                             /*DB::table('tblper')->where('fileNo','=',$list->fileNo)->update(array(
                                'promotion_alert'        => 1,
                                
                            ));*/

                          }
                        }

                        
                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Promotion: Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = 'Promotion:'. $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago';
                        }
                      

                        
                  

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="blink-text">{{$show}}</div>
                          </td>
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Promotion:</small> <br />'. 'Tomorrow';
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
                    }


                    else if($list->grade >= 13 && $list->grade <= 16){

                     
                    if($length > 1460 && $length <= 1492 && $realmonth === $curmonth)
                    {
                    $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        ///echo $list->fileNo;
                        // $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('year','=',date('Y'))->count();
                        if($length == 1461 && $realmonth === $curmonth)
                       {
                        $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('active','=',1)->count();
                         if($check == 0 )
                         {
                            
                            DB::table('promotion_alert')->insert(array(
                                'fileNo'        => $list->fileNo,
                                'active'        => 1,
                                'reason'        => 'Promotion',
                                'year'          => date('Y'),
                                'month'         => date('F'),
                                'date_added'    => date('Y-m-d'),
                            ));
                            

                             /*DB::table('tblper')->where('fileNo','=',$list->fileNo)->update(array(
                                'promotion_alert'        => 1,
                                
                            ));*/

                          }
                        }

                         

                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago';
                        }
                         

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="blink-text">{{$show}}</div>
                          </td>
                         @php
                      

                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Promotion</small> <br />'. 'Tomorrow';
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

                    }
                   else if($list->grade >= 17)
                    {
                      if($length > 1500)
                    {
                    $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        ///echo $list->fileNo;
                        // $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('year','=',date('Y'))->count();
                       
                         

                       //echo 'due today';
                        $get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago';
                        }
                         

                        @endphp 
                          <td class="hidden-print">
                            <div align="center" class="blink-text"></div>
                          </td>
                         @php
                      

                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Promotion</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              <td class="hidden-print">
                                <div align="center" style="color: green;"></div>
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

                    