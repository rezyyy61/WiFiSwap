<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileUser extends Model
{
    use HasFactory;

    protected $table = 'profile_users';

    protected $fillable = ['user_id', 'profile_image', 'background_color', 'accountId', 'bio', 'phone'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
