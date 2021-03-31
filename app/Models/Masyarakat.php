<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat';
    protected $fillable = [
        'nik',
        'nama',
        'telp',
    ];
    protected $hidden = [
        'password'
    ];

    public function reports()
    {
        return $this->hasMany(Pengaduan::class, 'nik', 'nik');
    }

    public function users()
    {
        return $this->morphMany(User::class, 'people');
    }
}
