<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->tinyInteger("rooms");
            $table->tinyInteger("beds");
            $table->tinyInteger("bathrooms");
            $table->tinyInteger("size");
            $table->string("address");
            $table->float("latitude", 10,7);
            $table->float("longitude", 10,7);
            $table->string("picture");
            $table->boolean("show");
            $table->bigInteger("user_id")->unsigned()->index();
            
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
        Schema::dropIfExists('apartments');
    }
}
