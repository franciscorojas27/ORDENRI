<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NonConformityRecord extends Model
{
    /** @use HasFactory<\Database\Factories\NonConformityRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'start_at',
        'end_at',
        'client_description',
        'description',
        'non_conformity_done_by_user_id',
    ];
}
