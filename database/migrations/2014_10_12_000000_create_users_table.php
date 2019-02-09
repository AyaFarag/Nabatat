<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $table) {
            $table -> increments("id");
            $table -> string("first_name");
            $table -> string("last_name");
            $table -> string("email") -> unique();
            $table -> string("confirmation_code") -> unique() -> nullable();
            $table -> string("password");
            $table -> boolean("activated") -> default(0);
            $table -> timestamp("phone_code_created_at") -> default("2017-06-14 15:28:36");
            $table -> string("api_token") -> nullable();
            $table -> string("device_token") -> nullable();
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
    }
}
