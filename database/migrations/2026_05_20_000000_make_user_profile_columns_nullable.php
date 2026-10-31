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
        Schema::table('users', function (Blueprint $table) {
            $table->string('volunteer_type')->nullable()->change();
            $table->string('domicile')->nullable()->change();
            $table->string('occupation')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('volunteer_type')->nullable(false)->change();
            $table->string('domicile')->nullable(false)->change();
            $table->string('occupation')->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
        });
    }
};
