<?php
       //foreach($allList as $list)
        
//{                
                 if(($list->dob != '0000-00-00' && $list->dob != '') && ($list->appointment_date !='' || $list->appointment_date != '0000-00-00'))
                  {

                    $curDay    = date('d');
                    $curmonth   = date('m');
                    $curYear   = date('Y');
                    $monthWords = date('F');
                     $realmonth = date('m', strtotime($list->appointment_date));
                    $dayDue     = ($curDay - (date('d', strtotime($list->appointment_date))));
                    $yearDiff   = ($curYear - (date('Y', strtotime($list->appointment_date))));
                     
                    $to   = new DateTime();
                    $from = new DateTime($list->appointment_date);
                    $diff = $from->diff($to);

                    $year = $diff->y;

                     $realday   = date('d', strtotime($list->appointment_date));
                     $realmonth = date('m', strtotime($list->appointment_date));
                     $f_app     = \Carbon\Carbon::createFromFormat('Y-m-d', $list->appointment_date);
                     $date_of_birth     = \Carbon\Carbon::createFromFormat('Y-m-d', $list->dob);
                     $now       = \Carbon\Carbon::now();

                     $length = $f_app->diffInDays($now);
                     $birthDiff   = $date_of_birth->diffInDays($now);

                     $daysLeft = 12783 - $length;
                     $birthRetireLeft = 21915 - $birthDiff;
                    //dd($length);

                    if($list->employee_type == 1 || $list->employee_type == 4 || $list->employee_type == 5)
                    {
                        if($daysLeft < $birthRetireLeft)
                        {
                        if($length > 12418 && $length < 12783)
                        { 
                          echo '
                            <div align="center" class="blink-text">'.$daysLeft.' days To retirement</div>
                          ';
                         
                        }
                        elseif ($length >= 12783) {

                            echo '
                               <div align="center" class="blink-text">Retirement Reached</div>
                              ';
                        }
                       }
                    elseif ($birthRetireLeft < $daysLeft) {
                      
                        if($birthDiff > 21550 && $birthDiff < 21915)
                        {
                            echo '
                            <div align="center" class="blink-text">'.$birthRetireLeft.' days To retirement</div>
                          ';
                        }

                        elseif ($birthDiff >= 21915) {
                            echo '
                               <div align="center" class="blink-text">Retirement Reached</div>
                              ';
                        }
                        
                    }

                   }
                    elseif($list->employee_type == 'CONSOLIDATED')
                    {
                        if($birthDiff > 23376 && $birthDiff < 23741)
                        { 
                          echo '
                               <div align="center" class="blink-text">'.$birthRetireLeft.' To retirement</div>
                              ';
                         
                        }
                        elseif ($birthDiff >= 23741) {
                            echo '
                               <div align="center" class="blink-text">Retirement Age Reached</div>
                              ';
                        }
                        

                   }
                 }//if date Not Empty end

                 else
                 {
                    echo '
                     <div align="center" class="blink-text">Undefined</div>
                    ';
                 }
                

                    // }
         ?>
