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
        Schema::create('working_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->tinyInteger('day_of_week')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_interval_minutes')->default(15);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('service_id')
                  ->references('id')->on('services')
                  ->onDelete('set null');

            $table->unique(
                ['service_id', 'day_of_week', 'date', 'start_time', 'end_time'],
                'unique_working_rule'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_times');
    }
};
