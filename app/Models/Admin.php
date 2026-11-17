<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLES = [
        'super_admin',
        'admin',
        'manager',
        'support',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin'], true);
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['super_admin', 'manager'], true);
    }

    public function isSupport(): bool
    {
        return in_array($this->role, ['super_admin', 'support'], true);
    }

    public function canManageProducts(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager'], true);
    }

    public function canManageCategories(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager'], true);
    }

    public function canViewUsers(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager', 'support'], true);
    }

    public function canModerateReviews(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager', 'support'], true);
    }

    public function canManageCoupons(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager'], true);
    }
}
