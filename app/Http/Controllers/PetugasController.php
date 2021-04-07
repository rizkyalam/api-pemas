<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
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
                'nama_petugas'  => 'required|max:35',
                'username'      => 'required|unique:users,username|max:25',
                'password1'     => 'required|min:4|max:32|same:password2',
                'password2'     => 'required|min:4|max:32|same:password1',
                'telp'          => 'max:13',
                'level'         => 'required|in:admin,petugas'
            ]);
    
            Petugas::create([
                'nama_petugas' => $request->nama_petugas,
                'telp' => $request->telp,
                'level' => $request->level
            ])->users()->create([
                'username' => $request->username,
                'password' => Hash::make($request->password1)
            ]);
    
            return response()->json([
                'status'  => true,
                'message' => 'Akun berhasil di buat',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Display all data Petugas.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_all()
    {
        $petugas = Petugas::with('users')->get();

        foreach ($petugas as $row) {
            $data[] = [
                'id_petugas' => $row->id_petugas,
                'id_users'      => $row->users[0]->id,
                'username'      => $row->users[0]->username,
                'nama_petugas'  => $row->nama_petugas,
                'telp'          => $row->telp,
                'level'         => $row->level,
            ];
        }

        return response()->json($data, 200);
    }

    /**
     * Display once of data Petugas.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_once($id_petugas)
    {
        $data = Petugas::firstWhere('id_petugas', $id_petugas);

        return response()->json($data);
    }

    /**
     * Update the profile account of petugas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        try {
            $request->validate([
                'id_petugas'    => 'required',
                'nama_petugas'  => 'required',
                'telp'          => 'max:13',
                'level'         => 'required|in:admin,petugas'
            ]);

            Petugas::where('id_petugas', $request->id_petugas)->update([
                'nama_petugas' => $request->nama_petugas,
                'telp'         => $request->telp,
                'level'        => $request->level
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Profile berhasil di ubah',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, Petugas $petugas)
    {
        try {
            $request->validate([
                'id_petugas'    => 'required',
                'old_password'  => 'required',
                'new_password1' => 'required|min:4|max:32|same:new_password2',
                'new_password2' => 'required|min:4|max:32|same:new_password1',
            ]);

            $data = Petugas::where('id_petugas', $request->id_petugas)->first();

            // cek password lama
            $check = Hash::check($request->old_password, $data->password);

            if ($check) {
                $data->update([
                    'password' => $request->new_password1
                ]);
            } else {
                throw new Exception('Password lama tidak sesuai !');
            }

            return response()->json([
                'status'  => true,
                'message' => 'Password berhasil di ubah',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {            
            
            DB::transaction(function () use ($request) {
                Petugas::where('id_petugas', $request->id_petugas)->delete();
                    
                \App\Models\User::find($request->id_users)->delete();
    
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil di hapus !',
                ], 200);
            });

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
            
        }
    }
}
