<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            DB::transaction(function () use ($request) {
                $request->validate([
                    'id_pengaduan'      => 'required',
                    'id_petugas'        => 'required',
                    'tanggapan'         => 'required',
                    'status_laporan'    => 'required|in:hoax,valid'
                ]);            
    
                Pengaduan::where('id_pengaduan', $request->id_pengaduan)
                ->update([
                    'status' => 'selesai'
                ]);

                Tanggapan::create([
                    'id_pengaduan'      => $request->id_pengaduan,
                    'tgl_tanggapan'     => date('Y-m-d'),
                    'tanggapan'         => $request->tanggapan,
                    'id_petugas'        => $request->id_petugas,
                    'status_laporan'    => $request->status_laporan,
                ]);
                    
                return response()->json([
                    'status'  => true,
                    'message' => 'Laporan berhasil di publikasikan !',
                ], 200);
            });
            
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function show_all(Tanggapan $tanggapan)
    {
        $rows = Pengaduan::with('masyarakat')->get();

        foreach ($rows as $row) {
            $data[] = [
                'id_pengaduan' => $row->id_pengaduan,
                'nama_pelapor'  => $row->masyarakat->nama,
                'tgl_pengaduan' => date('d-m-Y', strtotime($row->tgl_pengaduan)),
                'status'    => $row->status
            ];
        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }
}
