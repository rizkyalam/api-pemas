<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('masyarakat')->insert([            
            'nik'  => random_int(0, 99999999),
            'nama' => 'Abdul Aziz',
            'telp' => '081' . random_int(0, 99999999),
            'foto' => null
        ]);
    }
}
