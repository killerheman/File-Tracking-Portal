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
        Schema::create('file_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('file_id');
            $table->string('sender_id')->nullable();
            $table->string('reciever_id')->nullable();
            $table->string('mode_id');
            $table->string('status');
            $table->string('remark')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('file_trackings');
    }
};
