<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id('campaign_id');
            $table->string('campaign_name');
            $table->text('campaign_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('point_multiplier', 3, 2)->default(1.00);
            $table->string('target_transaction_types');
            $table->string('target_user_segments');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
