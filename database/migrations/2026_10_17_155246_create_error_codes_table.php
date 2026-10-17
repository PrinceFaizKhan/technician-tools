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
        Schema::create('error_codes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('appliance_id')->nullable()->constrained('appliances')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->foreignId('filter_id')->nullable()->constrained('error_code_filters')->nullOnDelete();
            $table->string('title');
            $table->string('code')->nullable()->index();
            $table->text('description')->nullable();
            $table->text('cause')->nullable();
            $table->longText('solution')->nullable();
            $table->string('pdf_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['appliance_id', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_codes');
    }
};
