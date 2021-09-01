<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');

            $table->float('r0')->min(0)->max(1);
            $table->float('d0')->min(0)->max(1);
            $table->float('p0')->min(0)->max(1);
            $table->float('f0')->min(0)->max(1);
            $table->float('e0')->min(0)->max(1);
            $table->float('pre0')->min(0)->max(1);
            $table->float('sym0')->min(0)->max(1);
            $table->float('asym0')->min(0)->max(1);
            $table->float('s0')->min(0)->max(1);

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
        Schema::dropIfExists('category_states');
    }
}
