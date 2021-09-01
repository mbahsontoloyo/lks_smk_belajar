<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->unsignedBigInteger("poll_id");
            $table->foreign("poll_id")->references("id")->on("polls");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('choices', function (Blueprint $table) {
            //
        });
    }
}
