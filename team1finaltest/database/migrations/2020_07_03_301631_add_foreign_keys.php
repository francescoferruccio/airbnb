<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('apartments', function (Blueprint $table) {


          $table->foreign("user_id", "user")->references("id")->on("users")->onDelete("cascade");



      });
      Schema::table('views', function (Blueprint $table) {


          $table->foreign("apartment_id", "apartmentviews")->references("id")->on("apartments")->onDelete("cascade");



      });
      Schema::table('requests', function (Blueprint $table) {


          $table->foreign("apartment_id", "apartmentreq")->references("id")->on("apartments")->onDelete("cascade");



      });
      Schema::table('apartment_service', function (Blueprint $table) {


          $table->foreign("apartment_id", "apartment")->references("id")->on("apartments")->onDelete("cascade");
          $table->foreign("service_id", "service")->references("id")->on("services")->onDelete("cascade");


      });
      Schema::table('apartment_sponsorship', function (Blueprint $table) {


          $table->foreign("apartment_id", "apartmentspons")->references("id")->on("apartments")->onDelete("cascade");
          $table->foreign("sponsorship_id", "sponsorship")->references("id")->on("sponsorships")->onDelete("cascade");


      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('apartments', function (Blueprint $table) {

        $table->dropForeign("user");

        });

      Schema::table('views', function (Blueprint $table) {

        $table->dropForeign("apartmentviews");

      });

      Schema::table('requests', function (Blueprint $table) {

        $table->dropForeign("apartmentreq");

      });

      Schema::table('apartment_service', function (Blueprint $table) {

        $table->dropForeign("apartment");
        $table->dropForeign("service");

      });
      Schema::table('apartment_sponsorship', function (Blueprint $table) {

        $table->dropForeign("apartmentspons");
        $table->dropForeign("sponsorship");

      });

    }
}
