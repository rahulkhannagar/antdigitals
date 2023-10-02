<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;

class LeaveReportController extends Controller
{
    public function index($emp_id)
    {
        $employeeAttendance = Attendance::where('emp_id', $emp_id)->get();
        $reportData = $this->generateLeaveReport($employeeAttendance);
        $empName = Employee::where('id', $emp_id)->first();     
        $daysLeave10 = $this->calculateLeaveWith10Days($employeeAttendance);   


        return view('leave-report', compact('reportData','empName','daysLeave10'));
    }

    private function generateLeaveReport($employeeAttendance)
    {


        // Initialize variables
        $leaveWithoutPay = $absentDays = $paidLeave  = 0;
        $isFridayLeave = $isFridayLeaveApplied = false;

        foreach ($employeeAttendance as $attendance) {
            // Check if the day is Friday and marked as Absent
            if ($attendance->day === 'Friday' && $attendance->absent_present === 'Absent') {
                $isFridayLeave = true;
                if($attendance->leave_applied == 'Yes'){
                    $isFridayLeaveApplied = true;
                }
            }
            if(($attendance->day === 'Saturday' || $attendance->day === 'Sunday' ) && $attendance->leave_applied == 'Yes'){
                $leaveWithoutPay += -1; 
            }
            // Check if consecutive days are absent (Monday after Friday leave)
            if ($isFridayLeave && $attendance->day === 'Monday' && $attendance->absent_present === 'Absent') {
                $leaveWithoutPay += ($isFridayLeaveApplied) ? 3 : 4; 
                $absentDays +=  3;  
            }else{
                $absentDays += ($attendance->absent_present === 'Absent') ? 1: 0;
                $leaveWithoutPay  += ($attendance->absent_present === 'Absent' && $attendance->leave_applied == 'No') ?  1 :0;
                
            }
            if($attendance->day === 'Monday'){
                $isFridayLeave = $isFridayLeaveApplied = false;
            }

        }

        return [
            'absent_days' => $absentDays,
            'lwp_days' => $leaveWithoutPay,
            'attendance' =>  $employeeAttendance,
        ];
    }


public function calculateLeaveWith10Days($employeeAttendance)
{
    $leaveCount =  $lossofPay = $consecutiveWeekendsMissed = $absenceCount =  0;

    foreach ($employeeAttendance as $attendance) {
            if (in_array($attendance->day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])) {
                if($attendance->absent_present === 'Absent'){
                    $leaveCount++;
                    if($attendance->leave_applied == 'No'){
                        $lossofPay++;
                    }
                    $isLastDayAbsent = true;
                }else{
                    $isLastDayAbsent = false;
                }
               
            } elseif (($attendance->day === 'Saturday' || $attendance->day === 'Sunday') && $isLastDayAbsent) {
                $consecutiveWeekendsMissed++;
                if($attendance->leave_applied == 'No'){
                    $lossofPay++;
                }
            }
    }

    if ($leaveCount >= 10) {
        $leaveCount = $leaveCount + $consecutiveWeekendsMissed;
    }

    return [
        'absent_days' => $leaveCount,
        'lwp_days' => $lossofPay
    ];
}


    public function employeeList()
        {
        $employees = Employee::all(); // Fetch all employees

        return view('employee-list', compact('employees'));
    }
}
