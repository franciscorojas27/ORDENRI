<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\GeneralManagements;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
    public static function getBasicUserInfo()
    {
        return self::select('id', 'name', 'job_title_id', 'last_name')->get();
    }
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    public function generalManagement()
    {
        return $this->belongsTo(GeneralManagements::class, 'general_management_id');
    }
    public function resolutionArea()
    {
        return $this->belongsTo(Resolution_Area::class, 'resolution_area_id');
    }
    public function passwordRecords()
    {
        return $this->hasMany(PasswordRecords::class);
    }
    public function hasRole($job)
    {
        return $this->jobTitle->title === $job;
    }
    public function isSupervisor()
    {
        return $this->hasRole('Supervisor');
    }
    public function isAdmin()
    {
        return $this->hasRole('Administrador');
    }
    public function isCLient()
    {
        return $this->hasRole('Cliente');
    }
    public function isBlocked()
    {
        return $this->is_blocked;
    }
    public function atValidate()
    {
        return $this->updated_at->diffInDays(now()) >= 30;
    }
    public function isDeleted()
    {
        return $this->is_deleted;
    }
    public function isGroup()
    {
        return $this->group;
    }
    public function passwordRecordVerification()
    {
        // 
    }
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
