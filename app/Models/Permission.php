<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }
}
