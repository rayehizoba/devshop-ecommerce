<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order')->default(1);
            $table->string('summary');
            $table->text('description');
            $table->string('end_products')->default('1');
            $table->boolean('for_personal_or_client')->default(0);
            $table->boolean('for_multiple_user_product')->default(0);
            $table->boolean('for_multiple_paying_user_product')->default(0);
            $table->boolean('for_theme_generators')->default(0);
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
        Schema::dropIfExists('licenses');
    }
}
