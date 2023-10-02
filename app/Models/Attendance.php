<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $fillable = [
        'emp_id',
        'date',
        'day',
        'absent_present',
        'Applied'
    ];
     public function employee()
        {
             return $this->belongsTo(Employee::class, 'emp_id');
        }
}
