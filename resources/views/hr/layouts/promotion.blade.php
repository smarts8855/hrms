@php
//$list->first_name;
//dd($list->grade);
                  
                  if($list->date_present_appointment != '0000-00-00')
                  {

                      $curDay    = date('d');
                     $curmonth   = date('m');
                     $curYear   = date('Y');
                     $monthWords = date('F');//Current month in words
                     $month = date('F', strtotime($list->date_present_appointment)); // month in words baed on date o present appointment
                     $dayDue     = ($curDay - (date('d', strtotime($list->date_present_appointment))));

                   //dd($dayDue);

                    $phase1 = array('January','February','March','April','May','June');
                     $phase2 = array('July','August','September','October','November','December');


                      $realday = date('d', strtotime($list->date_present_appointment));

                     $realmonth = date('m', strtotime($list->date_present_appointment));
                     $f_app    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                     $now = \Carbon\Carbon::now();

                     $todayDate = date("Y-m-d");
                     $formatTodayDate = \Carbon\Carbon::createFromFormat('Y-m-d', $todayDate);
                     $secondPhaseDate = $curYear."-07-01";
                    
                     $firstPhaseDate  = ($curYear + 1)."-07-01";
                     $sphase = \Carbon\Carbon::createFromFormat('Y-m-d', $secondPhaseDate);
                     $fphase = \Carbon\Carbon::createFromFormat('Y-m-d', $firstPhaseDate);

                     $sphaseYear = date('Y', strtotime($secondPhaseDate));
                     $fphaseYear = date('Y', strtotime($firstPhaseDate));

                     $fdifference = $formatTodayDate->diffInDays($fphase);
                     $sdifference = $formatTodayDate->diffInDays($sphase); 
                      
                     $length = $f_app->diffInDays($now);

                     //dd($length);
                     
                     //check if grade level is less than 3 and or equall to 6
                     if($list->grade > 3 && $list->grade <= 6)
                     {

                    // if($length > 730 && $length <= 801 && $realmonth === $curmonth)                     
                    if($length > 670)
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
                        }


                         
                       //echo 'due today';
                        /*$get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago'.$list->fileNo;
                        }*/

                        $show = '';

                        if (in_array($month, $phase1))
                        {
                         if($sdifference > 1)
                         {
                         //$show = " Due for Promotion in Phase 2 $sphase";
                          $show = " Due for Promotion";
                         }
                        }
                        elseif (in_array($month, $phase2))
                        {
                         if($fdifference > 1 )
                         {
                         //$show = "Due for Promotion in Phase 1 $fphase";
                           $show = " Due for Promotion";
                         }
                        }
                             

                        @endphp 
                          
                            <div align="center" class="blink-text">{{$show}}</div>
                          
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                         {
                            $alertForIncrement = '<small>Promotion:</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                              
                                <div align="center" style="color: green;">{!! $alertForIncrement !!}</div>
                              
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <!--<td class="hidden-print"></td>-->
                             @php 
                        }
                    }
                  }

                    //check if grade level is greater than 6 and or less than or equals 14
                    else if($list->grade > 6 && $list->grade <= 14)  {

                     //if($length > 1096 && $length <= 1126 && $realmonth === $curmonth)
                     //($value >= 1 && $value <= 10)
                    if($length >= 1035 )
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        
                        //if($length == 1097 && $realmonth === $curmonth)
                        if($length == 1097 && $realmonth === $curmonth)
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
                        }

                       //echo 'due today';
                        /*$get_diff_in_days = ($dayDue);
                        if($dayDue == 0){
                          $show = $diff_in_days ="Promotion: Today";
                        
                        }
                        else if($get_diff_in_days == 1){
                          $show = $diff_in_days = 'Promotion:'. $get_diff_in_days . 'day ago';
                        }
                        else{
                        $show = $diff_in_days = $dayDue . 'days ago';
                        }*/

                        $show = '';

                        if (in_array($month, $phase1))
                        {
                         if($sdifference > 1)
                         {
                         //$show = 'Due for Promotion in Phase 2';
                           $show = " Due for Promotion";
                         }
                        }
                        elseif (in_array($month, $phase2))
                        {
                         if($fdifference > 1 )
                         {
                         //$show = 'Due for Promotion in Phase 1';
                           $show = " Due for Promotion";
                         }
                        }
                      

                        
                  

                        @endphp 
                          
                            <div align="center" class="blink-text">{{$show}}</div>
                          
                         @php
                    }else{
                        //check for tomorrow increament
                        if( date('d', strtotime($list->date_present_appointment)) == (date('d') + 01) and 
                            date('m', strtotime($list->date_present_appointment)) == date('m') )
                        {
                            $alertForIncrement = '<small>Promotion:</small> <br />'. 'Tomorrow';
                            $raiseVariation = '';
                            @endphp
                             
                                <div align="center" style="color: green;">{!! $alertForIncrement !!}</div>
                              
                            @php 
                        }else{
                             $raiseVariation = '';
                             @endphp
                             <!--<td class="hidden-print"></td>-->
                             @php 
                        }
                    }
                    }


                    else if($list->grade > 14 && $list->grade <= 16){ 
                    //if($length > 1430 && $realmonth === $curmonth)
                    if($length > 1400)
                    {
                        $appDate    = \Carbon\Carbon::createFromFormat('Y-m-d', $list->date_present_appointment);
                        $todayDate  = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        ///echo $list->fileNo;
                        // $check = DB::table('promotion_alert')->where('fileNo','=',$list->fileNo)->where('year','=',date('Y'))->count();
                        
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

                         

                        $show = '';

                        if (in_array($month, $phase1))
                        {
                         if($sdifference > 1 /*&& $sdifference <= 90*/)
                         {
                         $show = "Due for Promotion in Phase 2 $sphaseYear";
                         $show = " Due for Promotion";
                         }
                        }
                        elseif (in_array($month, $phase2))
                        {
                         if($fdifference > 1 /*&& $sdifference <= 90*/)
                         {
                         //$show = "Due for Promotion in Phase 1 $sphaseYear";
                           $show = " Due for Promotion";
                         }
                        }

                        @endphp 
                          
                            <div align="center" class="blink-text">{{$show}}</div>
                          
                         @php
                      

                    }else{
                       
                             @endphp
                             <!--<td class="hidden-print"></td>-->
                             @php 
    
                    }

                    }

                    else if($list->grade == 17)
                    {
                      
                         @endphp
                             <!--<td class="hidden-print"></td> -->
                             @php 
                    }


                }//end if date not 0000-00-00
                 else{
                       
                             @endphp
                             <!--<td class="hidden-print"></td>-->
                             @php 
                        
                    }
                    @endphp

                    