<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'status',
        'theme_id',
        'plan_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
