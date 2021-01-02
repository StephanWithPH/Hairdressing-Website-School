<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentTreatmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_treatment', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')
                ->references('id')
                ->on('appointments')->onDelete('cascade');
            $table->unsignedBigInteger('treatment_id');
            $table->foreign('treatment_id')
                ->references('id')
                ->on('treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments_treatments');
    }
}
