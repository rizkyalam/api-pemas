<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengaduan')->insert([
            'id_masyarakat' => 1,
            'tgl_pengaduan' => date('Y-m-d'),
            'isi_laporan'   => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eos nihil neque distinctio, possimus sed modi laudantium qui ullam numquam earum.',
            'foto'          => 'demo.jpeg',
            'status'        => 'selesai',            
        ]);
    }
}
