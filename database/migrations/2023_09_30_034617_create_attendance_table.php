<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->date('date');
            $table->string('day');
            $table->enum('absent_present', ['Absent', 'Present','off'])->default('Present');
            $table->enum('leave_applied', ['Yes', 'No'])->default('No');            
            $table->timestamps();
            
            $table->foreign('emp_id')->references('id')->on('employees'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
