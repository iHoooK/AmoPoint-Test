<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'admin:create {email} {password} {--name=Admin}';

    protected $description = 'Create or update an administrator account for the statistics dashboard';

    public function handle(): int
    {
        $user = User::query()->updateOrCreate(
            ['email' => $this->argument('email')],
            [
                'name' => $this->option('name'),
                'password' => Hash::make($this->argument('password')),
            ],
        );

        $this->info(sprintf('Administrator account is ready: %s', $user->email));

        return self::SUCCESS;
    }
}
