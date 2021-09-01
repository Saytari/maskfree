<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->float('daily_ratio')->min(0)->max(1);
            $table->float('pre_infection')->min(0)->max(1);
            $table->float('sym_infection')->min(0)->max(1);
            $table->float('asym_infection')->min(0)->max(1);

            $table->float('alpha')->min(0)->max(1);
            $table->float('transmission_ratio')->min(0)->max(1);
            $table->float('NPI_ratio')->min(0)->max(1);

            $table->integer('dExp')->min(1);
            $table->integer('dPre')->min(1);
            $table->integer('dSym')->min(1);
            $table->integer('dAsym')->min(1);
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
        Schema::dropIfExists('plan');
    }
}
