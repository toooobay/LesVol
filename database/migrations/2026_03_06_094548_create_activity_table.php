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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->date('activity_date');
            $table->time('activity_time');
            $table->string('location');
            $table->text('description');
            $table->text('requirements');
            $table->date('open_reg_date');
            $table->date('close_reg_date');
            $table->string('image_path');
            $table->integer('slot');
            $table->foreignId('seeker_id')->index()->constrained('seekers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
