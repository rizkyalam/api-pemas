<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'people_id',
        'people_type'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Polymoprhism Relations with Masyarakat and Petugas table
     */
    public function people()
    {
        return $this->morphTo();
    }

    public function masyarakat()
    {
        return $this->hasOne(Masyarakat::class, 'id_masyarakat', 'people_id');
    }
    
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id_petugas', 'people_id');
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
