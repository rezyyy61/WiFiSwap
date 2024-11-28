<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'is_seen',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'description',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function isImage(): bool
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    public function isVideo(): bool
    {
        return strpos($this->mime_type, 'video/') === 0;
    }

}
