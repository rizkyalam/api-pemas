<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Exception;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{    
    public function show_all($id_masyarakat)
    {
        $reports = Masyarakat::find($id_masyarakat)->reports()->get();

        foreach ($reports as $row) {
            $data[] = [
                'id_pengaduan'  => $row->id_pengaduan,
                'id_masyarakat' => $row->id_masyarakat,
                'tgl_pengaduan' => date('d-m-Y', strtotime($row->tgl_pengaduan)),
                'isi_laporan'   => $row->isi_laporan,
                'foto'          => $row->foto,
                'status'        => $row->status,
            ];
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_masyarakat' => 'required',
                'isi_laporan'   => 'required', 
                'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',           
            ]);

            $imgName = time() . $request->foto->getClientOriginalName();

            $request->foto->move(public_path('img/reports'), $imgName);

            Pengaduan::create([
                'id_masyarakat' => $request->id_masyarakat,
                'tgl_pengaduan' => date('Y-m-d'),
                'isi_laporan' => $request->isi_laporan,
                'foto' => $imgName,
                'status' => 'proses'
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Laporan berhasil di publikasikan !',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);            
        }        
    }

    public function show_once($id_pengaduan)
    {
        $reports = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();
                            
        if ($reports->status === 'selesai') {
            $petugas = Petugas::where('id_petugas', $reports->comment->id_petugas)->first();

            $data = [
                'id_pengaduan' => $reports->id_pengaduan,
                'tgl_pengaduan' => date('d-m-Y',strtotime($reports->tgl_pengaduan)),
                'isi_laporan' => $reports->isi_laporan,
                'foto' => $reports->foto,
                'status' => $reports->status,
                'tgl_tanggapan' => $reports->comment->tgl_tanggapan,
                'tanggapan' => $reports->comment->tanggapan,
                'validasi'  => $reports->comment->status_laporan,
                'nama_petugas' => $petugas->nama_petugas
            ];            
        } else {
            $data = [
                'id_pengaduan' => $reports->id_pengaduan,
                'tgl_pengaduan' => date('d-m-Y',strtotime($reports->tgl_pengaduan)),
                'isi_laporan' => $reports->isi_laporan,
                'foto' => $reports->foto,
                'status' => $reports->status,
            ];
        }


        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengaduan $pengaduan)
    {
        //
    }
}
