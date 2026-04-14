@php
      // foreach($getCentralList as $list)
        
//{                
                 if(($list->incremental_date  !='' && $list->incremental_date  != '0000-00-00' || $list->appointment_date  != '0000-00-00'))
                  {

                    $curDay    = date('d');
                    $curmonth   = date('m');
                    $curYear   = date('Y');
                    $monthWords = date('F');
                     $realmonth = date('m', strtotime($list->incremental_date ));
                    $dayDue     = ($curDay - (date('d', strtotime($list->incremental_date ))));
                    $yearDiff   = ($curYear - (date('Y', strtotime($list->incremental_date ))));
                     
                    $to   = new DateTime();
                    $from = new DateTime($list->incremental_date );
                    $employDate = new DateTime($list->appointment_date );
                     $employYeardiff = $employDate->diff($to);
                    $diff = $from->diff($to);

                    $year = $diff->y;
                    $numYears = $employYeardiff->y;

                     $realday   = date('d', strtotime($list->incremental_date ));
                     $realmonth = date('m', strtotime($list->incremental_date ));
                     $f_app     = \Carbon\Carbon::createFromFormat('Y-m-d', $list->incremental_date );
                     //$date_of_birth     = \Carbon\Carbon::createFromFormat('Y-m-d', $list->dob);
                     $now       = \Carbon\Carbon::now();

                     $length = $f_app->diffInDays($now);
                    //$birthDiff   = $date_of_birth->diffInDays($now);

                     $daysLeft = 365 - $length;
                    $yearsOfEmployment = $numYears;
                    //dd($length);


                     if($yearsOfEmployment > 1)
                     {
                    $phase1 = array('January','February','March','April','May','June');
                    $phase2 = array('July','August','September','October','November','December');
                    $realday1 = date('d', strtotime($list->incremental_date ));
                    $realmonth1 = date('m', strtotime($list->incremental_date ));
                     $month = date('F', strtotime($list->incremental_date ));
                    $date     = \Carbon\Carbon::createFromFormat('Y-m-d', $list->incremental_date );
                    //$now = '2019-05-24 13:28:42';
                    $now = \Carbon\Carbon::now();
                     $lengthOfDays = $date->diffInDays($now);
                     $daysLeft1 = 365 - $lengthOfDays;


                   $todayDate = date("Y-m-d");
                   $formatTodayDate = \Carbon\Carbon::createFromFormat('Y-m-d', $todayDate);
                    $thisYear   = date('Y');
                   $secondPhaseDate = ($thisYear + 1)."-07-01";
                   $firstPhaseDate  = ($thisYear + 1)."-01-01";
                   
                   
                   /* First set of step Check */
                   if($list->grade > 3 && $list->grade <= 10 && $list->step != 15)
                     {
                      $newStep = $list->step + 1;
                        if($lengthOfDays > 300 && $lengthOfDays < 365)
                        {
                          if (in_array($month, $phase1))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $firstPhaseDate,
                            'approvedBy' => Auth::user()->name,
                            'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                           $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           //echo $show = "$daysLeft1 Days to Increment in Phase 2 $secondPhaseDate";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' Days to Increment in Phase 2 '.$firstPhaseDate.' </a></div>';
                        }
                         elseif (in_array($month, $phase2))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                          DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $secondPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                        }
                        $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           //echo $show = " $daysLeft1 to Increment in Phase 1 $firstPhaseDate";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' Days to Increment  </a></div>';
                        }

                        }
                        elseif ($lengthOfDays > 365) {
                           $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $secondPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                         $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                         echo $show = '<div align="center" class="blink-text"> <a href="'.$url.'"> Increment Overdue </a></div>';

                        }
                     
                     }
                     /* First set of step Check **/
                     /* second set of step Check */
                   elseif($list->grade > 10 && $list->grade <= 14 && $list->step < 11)
                   
                     {
                      $newStep = $list->step + 1;
                        if($lengthOfDays > 300 && $lengthOfDays < 365)
                        
                        {
                          if (in_array($month, $phase1))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $firstPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                         $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           //echo $show = "$daysLeft1 Days to Increment in Phase 2 $secondPhaseDate";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' Days to Increment </a></div>';
                        }
                         elseif (in_array($month, $phase2))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $secondPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                         $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           //echo $show = " $daysLeft1 to Increment in Phase 1 $firstPhaseDate";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' Days to Increment  </a></div>';
                        }

                        }
                        elseif ($lengthOfDays > 365) {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $firstPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                          $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                         echo $show = '<div align="center" class="blink-text"> <a href="'.$url.'"> Increment Overdue </a></div>';
                        }
                     
                     }
                     /* Second set of step Check **/

                      /* second set of step Check */
                   elseif(($list->grade > 14 && $list->grade <= 16))
                     {
                      $newStep = $list->step + 1;
                        if($lengthOfDays > 300 && $lengthOfDays < 365)
                        {
                          if (in_array($month, $phase1))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $firstPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                           //echo $show = "$daysLeft1 Days to Increment in Phase 2 $secondPhaseDate";
                         $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' Days to Increment  </a></div>';
                        }
                         elseif (in_array($month, $phase2))
                        {
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $secondPhaseDate,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                          // echo $show = " $daysLeft1 to Increment in Phase 1 $firstPhaseDate";
                         $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                           echo '<div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft1.' to Increment  </a></div>';
                        }

                        }
                        elseif ($lengthOfDays > 365) {
                         //echo $show = 'Increment Overdue';
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                          $yr =  $curYear."-01-01";
                           DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $yr,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                         }
                          $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                         echo '<div align="center" class="blink-text"> <a href="'.$url.'"> Increment Overdue </a></div>';
                        }
                     
                     }
                     /* Second set of step Check **/


                   }
                     else
                     {

                    /*if($numYears <=1 && $length > 275)
                    {
                         $newStep = $list->step + 1;
                           $explodeDate = explode('-', $list->appointment_date);
                           $dueYear = $explodeDate[0];
                           $incrementDuedate = ($dueYear + 1)."-$explodeDate[1]-$explodeDate[2]";
                           
                        if($length > 305 && $length < 365)
                        { 
                          
                        $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           
                          DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $incrementDuedate ,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                        }
                           $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                          echo '
                            <div align="center" class="blink-text"> <a href="'.$url.'"> '.$daysLeft.' days To Increment </a> </div>
                          ';
                         
                        }
                        elseif ($length == 365) {
                           $newStep = $list->step + 1;
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           
                          DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $incrementDuedate ,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                        }
                          $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                            echo '
                               <div align="center" class="blink-text"> <a href="'.$url.'">  Increment Today </a> </div>
                              ';
                        }
                        else {
                           $newStep = $list->step + 1;
                          $check = DB::table('tblvariation_temp')->where('staffid','=',$list->ID)->where('treated','=',0)->count();
                        if($check == 0 )
                         {
                           
                          DB::table('tblvariation_temp')->insert(array(
                            'staffid' => $list->ID,
                            'fileNo' => $list->fileNo,
                            'courtID' => $list->divisionID,
                            'arrears_type' => 'increment',
                            'old_grade' => $list->grade,
                            'old_step' => $list->step,
                            'new_grade' => $list->grade,
                            'new_step' => $newStep,
                            'due_date' => $incrementDuedate ,
                            'approvedBy' => Auth::user()->name,
                             'newEmploymentType'      => $list->employee_type,
                            'oldEmploymentType'      => $list->employee_type,
                            'approvedDate' => date('Y-m-d'),
                           ));
                        }
                              $url = "http://hr.njc.gov.ng/print/doc/$list->ID";
                            echo '
                               <div align="center" class="blink-text"><a href="'.$url.'"> Increment Overdue </a> </div>
                              ';
                        }
                      
                     }*/
                   }//years of employment else ends



                    
                 }//if date Not Empty end

                 

                   // } //end foreach
         @endphp
