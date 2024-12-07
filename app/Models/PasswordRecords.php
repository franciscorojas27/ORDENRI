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
        $maxPasswords = config('custom.password_history_limit', 5);

        $passwordRecords = self::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        if ($passwordRecords->count() >= $maxPasswords) {
            $passwordRecords->last()->delete();
        }
        self::create([
            'user_id' => $user->id,
            'password' => FacadesHash::make($newPassword),
        ]);
    }


}
