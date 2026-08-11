<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'IDPersona', 'IDrol', 'Nombre_usuario', 'Activo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'Activo' => 'boolean',
        ];
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'IDPersona', 'ID_Cedula');
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'IDrol', 'ID_Roles');
    }

    public function personasAsignadas()
    {
        return $this->hasMany(PersonaAsignada::class, 'ID_Usuario', 'id');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'ID_Usuario', 'id');
    }
}
