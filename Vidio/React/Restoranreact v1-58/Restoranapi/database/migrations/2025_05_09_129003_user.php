<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('level');
            $table->string('api_token');
            $table->integer('status');
            $table->string('relasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
