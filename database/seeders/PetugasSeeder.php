<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petugas')->insert([
            [
                'nama_petugas' => 'Admin',
                'telp'         => '081' . random_int(0, 99999999),
                'level'        => 'admin'
            ],
            [
                'nama_petugas' => 'Abdul Aziz',
                'telp'         => '081' . random_int(0, 99999999),
                'level'        => 'petugas'
            ],
        ]);
    }
}
