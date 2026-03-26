<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tenant_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ownedTenants()
    {
        return $this->hasMany(Tenant::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
