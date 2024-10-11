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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id(); // int(11)
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // int(11)
            $table->string('title', 255);
            $table->mediumText('description');
            $table->string('speaker', 45);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->enum('type', ['talk', 'workshop']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
