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
    public function isGroupMember(User $user,User $applicantTo){
        return $user->isGroup() && $user->coordination_management == $applicantTo->coordination_management;
    }
}
