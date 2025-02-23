<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id('reward_id');
            $table->string('reward_name');
            $table->text('reward_description');
            $table->integer('points_required');
            $table->enum('reward_type', ['discount', 'cashback', 'free_service', 'etc']);
            $table->decimal('reward_value', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rewards');
    }
};
