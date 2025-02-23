<?php

namespace App\Console\Commands;

use App\Models\LoyaltyTier;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateFilamentUser extends Command
{
    protected $signature = 'make:admin-user';
    protected $description = 'Create a new Filament admin user with loyalty fields';

    public function handle()
    {
        // Get the default loyalty tier (create one if none exists)
        $defaultTier = LoyaltyTier::firstOrCreate(
            ['tier_name' => 'Bronze'],
            [
                'points_required' => 0,
                'benefits_description' => 'Basic tier benefits'
            ]
        );

        $user = User::create([
            'name' => $this->ask('Name'),
            'email' => $this->ask('Email address'),
            'password' => Hash::make($this->secret('Password')),
            'brand_user_id' => (string) Str::uuid(),
            'phone_number' => $this->ask('Phone number'),
            'registration_date' => now(),
            'loyalty_tier_id' => $defaultTier->loyalty_tier_id,
        ]);

        $this->info('Admin user created successfully.');

        return Command::SUCCESS;
    }
}
