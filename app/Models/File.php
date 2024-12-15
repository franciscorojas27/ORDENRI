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
    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo Order.
     * Establece que el modelo actual (File) pertenece a una orden (Order).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
