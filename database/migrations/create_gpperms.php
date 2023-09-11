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
        Schema::create('gpperms_users', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->integer('rank_id');
            $table->bigInteger('added');
            $table->bigInteger('changed');
        });
        Schema::create('gpperms_ranks', function (Blueprint $table) {
            $table->bigIncrements('rank_id');
            $table->string('rank_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpperms_users');
        Schema::dropIfExists('gpperms_ranks');
    }
};
