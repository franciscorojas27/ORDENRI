<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;
    protected $fillable = [
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'size',
        'order_id',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
