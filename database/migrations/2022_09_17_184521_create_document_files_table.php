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
        Schema::create('document_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_code')->nullable();
            $table->string('file_number')->nullable();
            $table->string('title')->nullable();
            $table->string('file_type_id')->nullable();
            $table->string('file_type_main_id')->nullable();
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('file_mode_id')->nullable();
            $table->string('qr')->nullable();
            $table->string('barcode')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('transfer_by')->nullable();
            $table->unsignedBigInteger('current_user');
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
        Schema::dropIfExists('document_files');
    }
};
