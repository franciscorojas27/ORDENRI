<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function isSupervisor(User $user)
    {
        return $user->hasRole('Supervisor'); 
    }
    public function isCLient(User $user){
        return $user->hasRole('Cliente');
    }
    public function isAnalyzer(User $user){
        return $user->hasRole('Analista');
    }
    public function isAdmin(User $user){
        return $user->hasRole('Administrador');
    }
}
