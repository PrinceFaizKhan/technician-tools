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
        Schema::create('compressors', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('brand_name')->nullable()->index();
            $table->string('model_number')->nullable()->index();
            $table->foreignId('refrigerant_id')->nullable()->constrained('refrigerants')->nullOnDelete();
            $table->string('hp_capacity')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compressors');
    }
};
