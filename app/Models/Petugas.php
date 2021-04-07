<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = [        
        'nama_petugas',        
        'telp',
        'level'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'people');
    }
}
