<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users_phones", function (Blueprint $table) {
            $table -> increments("id");
            $table -> string("phone") -> unique();
            $table -> boolean("confirmed") -> default(0);
            $table -> string("confirmation_code", 4) -> nullable();
            $table -> integer("user_id") -> unsigned();

            $table
                -> foreign("user_id")
                -> references("id")
                -> on("users")
                -> onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users_phones");
    }
}
