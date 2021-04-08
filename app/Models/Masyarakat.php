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
        'foto'
    ];
    protected $hidden = [
        'password'
    ];

    public function reports()
    {
        return $this->hasMany(Pengaduan::class, 'id_masyarakat', 'id_masyarakat');
    }

    public function users()
    {
        return $this->morphMany(User::class, 'people');
    }    

    public function replies()
    {
        return $this->hasManyThrough(
            Tanggapan::class, 
            Pengaduan::class, 
            'id_pengaduan', 
            'id_tanggapan',
            'id_masyarakat',
            'id_pengaduan'
        );
    }
}
