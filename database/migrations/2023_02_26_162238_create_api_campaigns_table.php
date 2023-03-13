<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('Campaign_id')->nullable();
            $table->boolean("is_disabled")->default(false);
            $table->string('Campaign_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_campaigns');
    }
};
