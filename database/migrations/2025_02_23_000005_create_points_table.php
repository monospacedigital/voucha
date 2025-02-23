<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id('point_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions', 'transaction_id');
            $table->enum('point_type', ['earned', 'redeemed']);
            $table->integer('point_value');
            $table->string('point_reason');
            $table->timestamp('point_date');
            $table->date('expiry_date')->nullable();
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns', 'campaign_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('points');
    }
};
