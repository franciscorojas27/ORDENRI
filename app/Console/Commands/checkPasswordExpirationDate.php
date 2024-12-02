<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;

class checkPasswordExpirationDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-password-expiration-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para verificar si una cuenta ya se le expiro la contraseña';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        // Implementar la lógica para verificar si una cuenta ya se le expiro la contraseña
        $users = User::where('password_may_expire', true)
            ->whereDate('password_may_expire_at', Carbon::now()->subDays(30)->toDateString())
            ->get();

        foreach ($users as $user) {
            $user->notify(new \App\Notifications\PasswordExpirationNotification($user));
        }
    }
}
