<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('brand_transaction_id')->unique()->index();
            $table->enum('transaction_type', ['airtime', 'bill_payment', 'transfer', 'etc']);
            $table->decimal('transaction_amount', 10, 2);
            $table->timestamp('transaction_date');
            $table->enum('status', ['completed', 'pending', 'reversed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
