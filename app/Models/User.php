<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\GeneralManagements;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * Retorna los datos básicos de todos los usuarios
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getBasicUserInfo()
    {
        return self::select('id', 'name', 'job_title_id', 'last_name')->get();
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
        return $this->updated_at->diffInDays(now()) >= 30;
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

}
