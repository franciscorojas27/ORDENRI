<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'applicant_to_id',
        'responsible_id',
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
    
    
    public function userRelations(): array
    {
            return [   
                'client' => $this->client()->with('jobTitle')->first(),
                'applicantTo' => $this->applicantTo()->with('jobTitle')->first(),
                'responsible' => $this->responsible()->with('jobTitle')->first(),
                'resolutionArea' => $this->resolutionArea,
                'type' => $this->type,
                'status' => $this->status,
            ];
        }
        
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function applicantTo()
    {
        return $this->belongsTo(User::class, 'applicant_to_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function resolutionArea()
    { 
        return $this->belongsTo(Resolution_Area::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}