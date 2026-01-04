<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['dispatch','receive'])->default('receive');
            $table->bigInteger('department_id');
            $table->string('file_title');
            $table->string('file_number')->unique()->index();
            $table->text('comment')->nullable();
            $table->text('file')->nullable();
            $table->json('dispatch_to')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('number_start')->default(1);
            $table->bigInteger('number_end')->default(1);
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
        Schema::dropIfExists('letters');
    }
};
