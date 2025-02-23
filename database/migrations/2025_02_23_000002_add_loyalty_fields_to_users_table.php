<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('brand_user_id')->unique()->index()->after('id');
            $table->string('phone_number', 20)->index()->after('email');
            $table->string('first_name')->nullable()->after('phone_number');
            $table->string('last_name')->nullable()->after('first_name');
            $table->timestamp('registration_date')->after('last_name');
            $table->foreignId('loyalty_tier_id')->after('registration_date')
                  ->constrained('loyalty_tiers', 'loyalty_tier_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['loyalty_tier_id']);
            $table->dropColumn([
                'brand_user_id',
                'phone_number',
                'first_name',
                'last_name',
                'registration_date',
                'loyalty_tier_id'
            ]);
        });
    }
};
