@php

$fetch = DB::table('tblper')->where('staff_status','=',1)->get();

         foreach($fetch as $list)
         {

                    $curDay     = date('d');
                    $dayDue     = ($curDay - (date('d', strtotime($list->date_present_appointment))));

                      
                        $year = date('Y', strtotime($list->date_present_appointment));
                     

                    if(($dayDue == 0 || ($dayDue > 0 && $dayDue <=5)) && $year != date('Y'))

                    {
                                               
                        $year = date('Y'); 
                        $month = date('m', strtotime($list->date_present_appointment));
                        $day   = date('d', strtotime($list->date_present_appointment));

                        $dueDate  = "$year-$month-$day";

                        // Is (Appoint Month and Appoint Day) == (Today's day and Month)
                       /*if( (date('d', strtotime($list->date_present_appointment))) == (date('d')) and
                            (date('m', strtotime($list->date_present_appointment))) == (date('m'))){
                            */
                               $check = DB::table('tblarrears_temp')->where('fileNo','=',$list->fileNo)->count();
                               //foreach ($check as $val) {
                                if($check ==0)
                               {
                            DB::table('tblarrears_temp')->insert(array(
                                'courtID'                 => ($list->courtID),
                                'divisionID'              => ($list->divisionID),
                                'fileNo'                  => ($list->fileNo),
                                'old_grade'               => ($list->grade),
                                'new_grade'               => ($list->grade),
                                'old_step'                => ($list->step),
                                'new_step'                => (($list->step) + 1),
                                'oldEmploymentType'       => ($list->employee_type),
                                'newEmploymentType'       => ($list->employee_type),
                                'arrears_type'            =>  'increment',
                                'due_date'                => ($dueDate),
                                'updated_at'              => date('Y-m-d'),
                                
                            ));
                          //}

                               }
                       // }
                    }
       }


        $dayscheck = DB::table('tblarrears_temp')->get();

        foreach ($dayscheck as $d) {
       
        $f_app    = \Carbon\Carbon::createFromFormat('Y-m-d', $d->updated_at);
        $now      = \Carbon\Carbon::now();
        $length = $f_app->diffInDays($now);

        if($length > 6)
        
        DB::table('tblarrears_temp')->where('fileNo','=',$d->fileNo)->delete();
           
        }

                  
@endphp
