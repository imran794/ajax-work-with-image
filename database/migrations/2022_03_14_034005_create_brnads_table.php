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
        Schema::create('brnads', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('brand_number');
            $table->string('brand_location');
            $table->string('brand_image');
            $table->bigInteger('added_by');
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('deleted',['yes','no'])->default('no');
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('brnads');
    }
};
