<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const ADMINS = [
        'super-admin' => 1,
        'manager' => 3,
    ];

    public function users()
    {
        return $this->hasMany(User::class)->withTrashed();
    }
}
