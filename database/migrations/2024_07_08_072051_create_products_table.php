<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->foreignId('category_id');
            $table->foreignId('brand_id');
            $table->foreignId('added_by')->nullable();
            $table->decimal('price',10,2);
            $table->string('color')->nullable();
            $table->string('weight')->nullable();
            $table->string('gender')->nullable();
            $table->string('feature')->nullable();
            $table->boolean('is_active')->default(1)->comment('0 = Inactive, 1 = Active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
