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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Wholesale Sale', 'Wholesale Return']);
            $table->foreignId('pharmacy_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_product')->default(0);
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_gift')->default(0);
            $table->decimal('value_income', 15, 2)->default(0);
            $table->decimal('value_output', 15, 2)->default(0);
            $table->foreignId('representative_id')->constrained('representatives')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->decimal('value_gift', 15, 2)->default(0);



            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('set null');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
