<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('branch_office_id')->nullable();
            $table->string('name');
            $table->integer('stock');
            $table->integer('min_stock')->nullable();
            $table->decimal('price',9,2);
            $table->string('description');
            $table->enum('status', [\App\Product::DISPONIBLE, \App\Product::NO_DISPONIBLE])->default(\App\Product::DISPONIBLE);
            $table->timestamps();
            $table->unique(['name', 'branch_office_id']);
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
