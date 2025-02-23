<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id('loyalty_tier_id');
            $table->string('tier_name', 50);
            $table->integer('points_required');
            $table->text('benefits_description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_tiers');
    }
};
