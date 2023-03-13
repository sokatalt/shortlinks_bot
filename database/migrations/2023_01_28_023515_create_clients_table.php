<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("client_id")->unsigned();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("username")->nullable();
            $table->tinyText("language")->nullable();
            $table->tinyInteger("subscription_tries")->default(0);
            $table->foreignId('subscription_id')->nullable()->constrained();
            $table->boolean("is_enabled")->default(true);
            $table->boolean("is_approved")->default(false);
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
        Schema::dropIfExists('clients');
    }
};
