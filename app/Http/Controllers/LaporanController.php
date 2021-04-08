<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;

class LaporanController extends Controller
{
    public function show_pengaduan() {
        $pengaduan = Pengaduan::all();

        foreach ($pengaduan as $row) {
            $data[] = [
                'id_pengaduan' => $row->id_pengaduan,
                'tgl_pengaduan' => date('d-m-Y', strtotime($row->tgl_pengaduan)),
                'status' => $row->status,
                'nama_pelapor' => $row->masyarakat->nama,
            ];
        }

        return response()->json($data);
    }
}
