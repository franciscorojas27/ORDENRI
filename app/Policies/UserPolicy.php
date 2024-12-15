<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Verifica si el usuario tiene el rol de "Supervisor".
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @return bool Verdadero si el usuario tiene el rol de "Supervisor", falso de lo contrario.
     */
    public function isSupervisor(User $user)
    {
        return $user->hasRole('Supervisor');
    }

    /**
     * Verifica si el usuario tiene el rol de "Cliente".
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @return bool Verdadero si el usuario tiene el rol de "Cliente", falso de lo contrario.
     */
    public function isCLient(User $user)
    {
        return $user->hasRole('Cliente');
    }

    /**
     * Verifica si el usuario tiene el rol de "Analista".
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @return bool Verdadero si el usuario tiene el rol de "Analista", falso de lo contrario.
     */
    public function isAnalyzer(User $user)
    {
        return $user->hasRole('Analista');
    }

    /**
     * Verifica si el usuario tiene el rol de "Administrador".
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @return bool Verdadero si el usuario tiene el rol de "Administrador", falso de lo contrario.
     */
    public function isAdmin(User $user)
    {
        return $user->hasRole('Administrador');
    }

    /**
     * Verifica si el usuario es miembro de un grupo con el mismo área de coordinación
     * que el usuario solicitado.
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @param \App\Models\User $applicantTo El usuario al que se compara el área de coordinación.
     * @return bool Verdadero si el usuario pertenece al mismo grupo y tiene el mismo área de coordinación, falso de lo contrario.
     */
    public function isGroupMember(User $user, User $applicantTo)
    {
        return $user->isGroup() && $user->coordination_management == $applicantTo->coordination_management;
    }

    /**
     * Verifica si el usuario tiene permiso para crear órdenes.
     *
     * @param \App\Models\User $user El usuario a verificar.
     * @return bool Verdadero si el usuario tiene permiso para crear órdenes, falso de lo contrario.
     */
    public function canCreateOrder(User $user)
    {
        return $user->can_create_orders;
    }
    
}
