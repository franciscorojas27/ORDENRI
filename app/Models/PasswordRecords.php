<?php

namespace App\Models;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'password',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Agrega un nuevo registro de contraseña al historial del usuario, asegurando que no se sobrepasen
     * el número máximo de contraseñas almacenadas para un usuario, eliminando la más antigua si es necesario.
     *
     * @param  \App\Models\User  $user          El usuario cuyo historial de contraseñas se actualizará.
     * @param  string  $newPassword            La nueva contraseña que se almacenará en el historial.
     * 
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un usuario con el ID proporcionado.
     */
    public static function addPasswordRecord($user, $newPassword)
    {
        // Obtener el número máximo de contraseñas a almacenar desde la configuración
        $maxPasswords = config('custom.password_history_limit', 5); // Número acordado

        // Obtener los registros de contraseñas del usuario, ordenados por fecha de creación (de más reciente a más antiguo)
        $passwordRecords = self::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Si el número de contraseñas almacenadas es igual o superior al máximo permitido, eliminar la más antigua
        if ($passwordRecords->count() >= $maxPasswords) {
            $passwordRecords->last()->delete(); // Eliminar el registro de la contraseña más antigua
        }

        // Crear un nuevo registro de contraseña con la nueva contraseña proporcionada
        self::create([
            'user_id' => $user->id,          // Asignar el ID del usuario al nuevo registro
            'password' => FacadesHash::make($newPassword), // Guardar la nueva contraseña cifrada
        ]);
    }


}
