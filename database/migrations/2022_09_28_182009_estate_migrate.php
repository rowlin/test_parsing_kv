<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates' , function (Blueprint $table){
           $table->id();
           $table->string( 'title')->nullable();
           $table->string('address');
           $table->integer('deal_type')->default(1);
           $table->string('url');
           $table->string('image')->nullable();
           $table->integer('float')->nullable();
           $table->integer('float_total')->nullable();
           $table->float('total_area')->nullable();
           $table->text('description_full');
           $table->text('description')->nullable();
           $table->integer('year')->nullable();
           $table->decimal('price');
           $table->decimal('price_per_m');
           $table->dateTime('published');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estates');
    }
};
