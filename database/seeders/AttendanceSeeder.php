<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $employees = DB::table('employees')->select('id')->get(); 

       foreach ($employees as $employee) {
           $startDate = Carbon::now()->subDays(30); 

           while ($startDate <= Carbon::now()) {
               DB::table('attendance')->insert([
                   'emp_id' => $employee->id,
                   'date' => $startDate,
                   'day' => $startDate->format('l'),
                   'absent_present' => 'Present',
                   'leave_applied' => 'No',
               ]);
               
               $startDate->addDay();
           }
       }
    }
}
