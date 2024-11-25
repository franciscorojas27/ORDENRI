<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;

class CheckUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:check-user-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marcar a los usuarios inactivos como desconectados';

    
    /**
     * Execute the console command.
     *
     * Busca a todos los usuarios que han superado el minuto sin actividad y los marca como desconectados.
     */
    public function handle()
    {
        $inactiveUsers = User::where('last_connection', '<', Carbon::now()->subMinutes(1))
            ->where('is_connected', true)
            ->get();

        foreach ($inactiveUsers as $user) {
            $user->is_connected = false;
            $user->save();
        }

        $this->info('Usuarios inactivos marcados como desconectados.');
    }
}
