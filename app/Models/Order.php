<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\UserRelationResource;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'applicant_to_id',
        'responsible_id',
        'is_deleted',
        'delete_by_user_id',
        'resolution_area_id',
        'type_id',
        'status_id',
        'client_description',
        'description',
        'created_at',
        'updated_at',
        'evaluation_at',
        'start_at',
        'end_at',
        'closed_at',
    ];
    public static function getSelectOptions()
    {
        return [
            'type' => Type::pluck('type', 'id'),
            'status' => Status::pluck('status', 'id'),
            'resolutionAreas' => Resolution_Area::pluck('area', 'id'),
        ];
    }
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function applicantTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_to_id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function resolutionArea(): BelongsTo
    {
        return $this->belongsTo(Resolution_Area::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
    
}
