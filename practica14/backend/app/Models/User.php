<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'rol' => 'string',
        ];
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esEditor(): bool
    {
        return $this->rol === 'editor';
    }

    public function esCliente(): bool
    {
        return $this->rol === 'cliente';
    }

    public function puedeCrearProductos(): bool
    {
        return in_array($this->rol, ['admin', 'editor'], true);
    }

    public function puedeEditarProductos(): bool
    {
        return in_array($this->rol, ['admin', 'editor'], true);
    }

    public function puedeEliminarProductos(): bool
    {
        return $this->esAdmin();
    }
}
