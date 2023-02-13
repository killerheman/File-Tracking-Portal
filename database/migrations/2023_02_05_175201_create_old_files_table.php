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
        Schema::create('old_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_no')->unique();
            $table->string('file_code')->unique();
            $table->unsignedBigInteger('ini_department')->nullable();
            $table->unsignedBigInteger('ini_branch');
            $table->unsignedBigInteger('sender_department')->nullable();
            $table->unsignedBigInteger('sender_branch');
            $table->unsignedBigInteger('departure')->nullable();
            $table->string('subject')->nullable();
            $table->text('matter')->nullable();
            $table->date('receiving_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('file')->nullable();
            $table->text('remark')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('old_files');
    }
};
