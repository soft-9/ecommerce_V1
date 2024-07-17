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
        Schema::create('products', function (Blueprint $table) {
          $table->id();
          $table->string('title_en');
          $table->string('title_ar');
          $table->string('name_en');
          $table->string('name_ar');
          $table->longText('description_en')->nullable();
          $table->longText('description_ar')->nullable();
          $table->longText('model_en')->nullable();
          $table->longText('model_ar')->nullable();
          $table->string('avatar_main');
          $table->string('avatar_details')->nullable();
          $table->string('price_before_discount')->nullable();
          $table->string('price');
          $table->integer('quantity')->nullable();
          $table->decimal('stars', 2, 1)->nullable();
          $table->foreignId('category_id')->constrained()->onDelete('cascade');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
