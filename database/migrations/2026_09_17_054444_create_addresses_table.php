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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label'); // detail alamatnya
            $table->text('full_address');
            $table->decimal('longitude', 10, 7)->nullable(); // garis lintang
            $table->decimal('latitude', 10, 7)->nullable(); // garis bujur
            $table->boolean('is_primary')->nullable(); // untuk menentukan alamat utamanya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
