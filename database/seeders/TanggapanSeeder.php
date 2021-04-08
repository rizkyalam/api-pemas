<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanggapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tanggapan')->insert([
            'id_pengaduan'      => 1,
            'tgl_tanggapan'     => date('Y-m-d'),
            'tanggapan'         => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium veniam nihil blanditiis minus iste voluptatibus, veritatis harum aut. Similique, itaque.',
            'id_petugas'        => 1,
            'status_laporan'    => 'valid'
        ]);
    }
}
