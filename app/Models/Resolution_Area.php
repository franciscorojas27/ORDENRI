<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resolution_Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'area'
    ]; 
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
