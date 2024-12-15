<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\GeneralManagements;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// implements MustVerifyEmail para poder usar la verificación de email.
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'userid',
        'email',
        'job_title_id',
        'password',
        'phone',
        'ip_address',
        'last_connection',
        'is_blocked',
        'group',
        'is_deleted',
        'resolution_area_id',
        'can_create_orders',
        'coordination_management',
        'password_may_expire_at',
        'password_may_expire',
        'general_management_id',
        'updated_at',
        'is_connected'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Generate a temporary signed URL for unlocking the user account.
     *
     * This method creates a secure, temporary URL that can be used to unlock
     * the user's account. The URL includes a unique hash based on the user's 
     * email and an expiration time specified in the configuration.
     *
     * @return string The temporary signed URL.
     */
    public function getUnlockUrl()
    {
        return URL::temporarySignedRoute(
            'user.verify',
            Carbon::now()->addMinutes(config('custom.auth_unlock_expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->email),
            ]
        );
    }
    /**
     * Retorna los datos básicos de los empleados según el título de trabajo.
     *
     * @param int $resolutionAreaId
     * @param mixed $jobTitle (puede ser un solo título o un array de títulos)
     * @return \Illuminate\Support\Collection
     */
    public static function getEmployeesByJobTitle($resolutionAreaId, $jobTitle)
    {
        return self::select('id', 'name', 'job_title_id', 'last_name')
            ->where('resolution_area_id', $resolutionAreaId)
            ->whereHas('jobTitle', function ($query) use ($jobTitle) {
                if (is_array($jobTitle)) {
                    $query->whereIn('title', $jobTitle);
                } else {
                    $query->where('title', $jobTitle);
                }
            })
            ->orderBy('name')
            ->get();
    }

    /**
     * Retorna el cargo del usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    /**
     * Retorna la gerencia general del usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function generalManagement()
    {
        return $this->belongsTo(GeneralManagements::class, 'general_management_id');
    }
    /**
     * Retorna el área de resolución del usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resolutionArea()
    {
        return $this->belongsTo(Resolution_Area::class, 'resolution_area_id');
    }
    /**
     * Retorna los registros de contraseñas del usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passwordRecords()
    {
        return $this->hasMany(PasswordRecords::class);
    }
    /**
     * Verifica si el usuario tiene un cargo específico
     *
     * @param string $job El cargo a verificar
     * @return bool
     */
    public function hasRole($job)
    {
        return $this->jobTitle->title === $job;
    }
    /**
     * Verifica si el usuario es Supervisor
     *
     * @return bool
     */
    public function isSupervisor()
    {
        return $this->hasRole('Supervisor');
    }
    /**
     * Verifica si el usuario es Administrador
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('Administrador');
    }
    /**
     * Verifica si el usuario es Analista
     *
     * @return bool
     */
    public function isAnalyzer()
    {
        return $this->hasRole('Analista');
    }
    /**
     * Verifica si el usuario es Cliente
     *
     * @return bool
     */
    public function isCLient()   
    {
        return $this->hasRole('Cliente');
    }
    /**
     * Verifica si el usuario est  bloqueado
     *
     * @return bool
     */
    public function isBlocked()
    {
        return $this->is_blocked;
    }
    /**
     * Verifica si el usuario debe validar su contraseña
     *
     * @return bool
     */
    public function atValidate()
    {
        // Asegúrate de convertir la fecha a un objeto Carbon
        $expirationDate = Carbon::parse($this->password_may_expire_at);

        // Verifica si la contraseña puede caducar y si la diferencia en días
        // desde la fecha de expiración es mayor o igual a 30 días
        return $this->password_may_expire && $expirationDate->diffInDays(now()) >= config('custom.days_before_notifying_password_expiration', 30);
    }
    /**
     * Verifica si la contraseña del usuario debe ser actualizada exactamente 30 días después de la fecha de expiración
     *
     * Este método comprueba si la contraseña del usuario está configurada para expirar y si la fecha de expiración 
     * es exactamente 30 días antes de la fecha actual. Si ambas condiciones se cumplen, la validación es exitosa.
     * 
     * @return bool Retorna `true` si la contraseña debe ser actualizada (hace exactamente 30 días), de lo contrario `false`.
     */
    public function atVerification()
    {
        return $this->password_may_expire && $this->password_may_expire_at->isSameDay(Carbon::now()->subDays(30));
    }
    /**
     * Genera un nuevo token de restablecimiento de contraseña, elimina el anterior y lo almacena en la base de datos.
     *
     * Este método genera un token aleatorio de 60 caracteres, lo cifra utilizando el algoritmo de hash, elimina cualquier token 
     * previo relacionado con el correo electrónico proporcionado y guarda el nuevo token en la tabla `password_reset_tokens`.
     * Finalmente, devuelve el token en texto plano para ser enviado al usuario.
     *
     * @return string El token de restablecimiento de contraseña en texto plano.
     */
    public function generateToken()
    {
        // Genera un token aleatorio de 60 caracteres
        $token = Str::random(60);

        // Elimina el token anterior si existe
        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        // Inserta el nuevo token cifrado en la base de datos
        DB::table('password_reset_tokens')->insert([
            'email' => $this->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Devuelve el token en texto plano
        return $token;
    }
    /**
     * Verifica si el usuario est  eliminado
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->is_deleted;
    }
    /**
     * Verifica si el usuario es un grupo
     *
     * @return bool
     */
    public function isGroup()
    {
        return $this->group;
    }
    /**
     * Verifica si el usuario ha verificado su registro de contraseña
     *
     * return bool
     */
    public function passwordRecordVerification()
    {
        // 
    }
    /**
     * Establece el correo electronico del usuario y el userid
     *
     * @param string $value El correo electronico
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $userid = substr($value, 0, strpos($value, '@'));
        if (strlen($userid) > 8) {
            throw ValidationException::withMessages(['email' => 'La parte del correo antes del @ no puede ser mayor a 8 caracteres.']);
        }
        $this->attributes['email'] = $value;
        $this->attributes['userid'] = $userid;
    }
    /**
     * Verifica si el usuario tiene permiso para crear órdenes.
     *
     * @param \App\Models\User $this El usuario a verificar.
     * @return bool Verdadero si el usuario tiene permiso para crear órdenes, falso de lo contrario.
     */
    public function canCreateOrder()
    {
        return $this->can_create_orders;
    }
}
