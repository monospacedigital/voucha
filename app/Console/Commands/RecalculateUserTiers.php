<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RecalculateUserTiers extends Command
{
    protected $signature = 'users:recalculate-tiers';
    protected $description = 'Recalculate loyalty tiers for all users based on their points';

    public function handle()
    {
        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        foreach ($users as $user) {
            $user->calculateAndUpdateLoyaltyTier();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All user tiers have been recalculated!');

        return Command::SUCCESS;
    }
}
