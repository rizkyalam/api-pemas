<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username'    => 'admin',
                'password'    => Hash::make('admin'),
                'people_id'   => 1,
                'people_type' => 'App\Models\Petugas'
            ],
            [
                'username'    => 'petugas1',
                'password'    => Hash::make('petugas1'),
                'people_id'   => 2,
                'people_type' => 'App\Models\Petugas'
            ],
            [
                'username'    => 'abdul',
                'password'    => Hash::make('abdul'),
                'people_id'   => 1,
                'people_type' => 'App\Models\Masyarakat'
            ],
        ]);
    }
}
