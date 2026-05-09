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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('title')->nullable(); 
            $table->string('slug')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable(); 
            $table->string('link')->nullable(); 
            $table->string('image')->nullable(); 
            $table->boolean('status')->default(1);
            $table->boolean('serial')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
