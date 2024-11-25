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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index()->unique();
            $table->string('name');
            $table->bigInteger('phone')->unique()->index();
            $table->string('password');
            $table->dateTime('registered_at');
            $table->dateTime('last_login_at')->nullable();
            $table->string('register_ip')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->boolean('is_active')->default(false);
            $table->dateTime('phone_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
