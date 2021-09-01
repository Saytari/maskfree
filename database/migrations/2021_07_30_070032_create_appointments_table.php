<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('vaccinator_id');
            $table->foreignId('center_id');
            $table->foreignId('dose_id');
            $table->foreignId('vaccine_id');
            $table->foreignId('request_id');
            $table->dateTime('appointment_date');
            //adding image signature
            $table->string('image_Signature');
            //$table->string('center_name');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
