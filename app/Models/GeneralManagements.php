<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralManagements extends Model
{
    use HasFactory;

    protected $fillable = [
        'department'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
