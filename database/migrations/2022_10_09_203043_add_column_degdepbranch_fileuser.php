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
        Schema::table('file_users', function (Blueprint $table) {
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('desigantion_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_users', function (Blueprint $table) {
            //
        });
    }
};
