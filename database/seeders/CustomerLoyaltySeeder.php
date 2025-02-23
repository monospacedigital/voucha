<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\LoyaltyTier;
use App\Models\Point;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerLoyaltySeeder extends Seeder
{
    public function run(): void
    {
        // Save existing admin users
        $adminUsers = User::where('email', 'like', '%@monospace.ng')->get();

        // Disable foreign key checks
        DB::statement('PRAGMA foreign_keys = OFF');

        // Clear existing data
        Point::truncate();
        Transaction::truncate();
        User::truncate();
        Campaign::truncate();
        Reward::truncate();
        LoyaltyTier::truncate();

        // Re-enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON');

        // Restore admin users
        foreach ($adminUsers as $admin) {
            $admin->save();
        }

        // 1. Create Loyalty Tiers first (required for users)
        $tiers = [
            [
                'loyalty_tier_id' => 1,
                'tier_name' => 'Bronze',
                'points_required' => 0,
                'benefits_description' => 'Basic tier benefits - 1x points on all transactions'
            ],
            [
                'loyalty_tier_id' => 2,
                'tier_name' => 'Silver',
                'points_required' => 1000,
                'benefits_description' => 'Silver tier benefits - 1.2x points on all transactions, priority support'
            ],
            [
                'loyalty_tier_id' => 3,
                'tier_name' => 'Gold',
                'points_required' => 5000,
                'benefits_description' => 'Gold tier benefits - 1.5x points on all transactions, priority support, exclusive rewards'
            ],
            [
                'loyalty_tier_id' => 4,
                'tier_name' => 'Platinum',
                'points_required' => 10000,
                'benefits_description' => 'Platinum tier benefits - 2x points on all transactions, VIP support, exclusive rewards and events'
            ],
        ];

        foreach ($tiers as $tier) {
            LoyaltyTier::create($tier);
        }

        // 2. Create Campaigns (needed for points)
        $campaigns = [
            [
                'campaign_id' => 1,
                'campaign_name' => 'Welcome Bonus',
                'campaign_description' => 'Double points for new users',
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
                'point_multiplier' => 2.00,
                'target_transaction_types' => 'airtime,bill_payment',
                'target_user_segments' => 'new_users',
            ],
            [
                'campaign_id' => 2,
                'campaign_name' => 'Weekend Special',
                'campaign_description' => '1.5x points on weekend transactions',
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'point_multiplier' => 1.50,
                'target_transaction_types' => 'all',
                'target_user_segments' => 'all',
            ],
        ];

        foreach ($campaigns as $campaign) {
            Campaign::create($campaign);
        }

        // 3. Create Rewards
        $rewards = [
            [
                'reward_id' => 1,
                'reward_name' => '5% Cashback',
                'reward_description' => 'Get 5% cashback on your next transaction',
                'points_required' => 500,
                'reward_type' => 'cashback',
                'reward_value' => 5.00,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
            ],
            [
                'reward_id' => 2,
                'reward_name' => 'Free Service',
                'reward_description' => 'One free service of your choice',
                'points_required' => 1000,
                'reward_type' => 'free_service',
                'reward_value' => 50.00,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
            ],
        ];

        foreach ($rewards as $reward) {
            Reward::create($reward);
        }

        // 4. Create Users with Transactions and Points
        for ($i = 1; $i <= 50; $i++) {
            $registrationDate = fake()->dateTimeBetween('-1 year', 'now');

            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'brand_user_id' => (string) Str::uuid(),
                'phone_number' => fake()->e164PhoneNumber(), // Standardized phone format
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'registration_date' => $registrationDate,
                'loyalty_tier_id' => fake()->randomElement([1, 1, 1, 2, 2, 3, 4]), // Weight towards lower tiers
                'email_verified_at' => $registrationDate,
            ]);

            // Create 3-10 transactions per user
            $numTransactions = fake()->numberBetween(3, 10);
            for ($j = 1; $j <= $numTransactions; $j++) {
                $transactionDate = fake()->dateTimeBetween($registrationDate, 'now');

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'brand_transaction_id' => (string) Str::uuid(),
                    'transaction_type' => fake()->randomElement(['airtime', 'bill_payment', 'transfer']),
                    'transaction_amount' => fake()->randomFloat(2, 10, 1000),
                    'transaction_date' => $transactionDate,
                    'status' => 'completed',
                ]);

                // Create points for the transaction
                Point::create([
                    'user_id' => $user->id,
                    'transaction_id' => $transaction->transaction_id,
                    'point_type' => 'earned',
                    'point_value' => floor($transaction->transaction_amount),
                    'point_reason' => 'Transaction points',
                    'point_date' => $transactionDate,
                    'expiry_date' => now()->addYear(),
                    'campaign_id' => fake()->boolean(30) ? fake()->randomElement([1, 2]) : null,
                ]);
            }

            // Add welcome bonus points for some users
            if (fake()->boolean(40)) {
                Point::create([
                    'user_id' => $user->id,
                    'transaction_id' => null,
                    'point_type' => 'earned',
                    'point_value' => fake()->numberBetween(50, 200),
                    'point_reason' => 'Welcome bonus',
                    'point_date' => $registrationDate,
                    'expiry_date' => now()->addYear(),
                    'campaign_id' => 1,
                ]);
            }
        }

        // Recalculate tiers for all users
        $this->command->call('users:recalculate-tiers');
    }
}
