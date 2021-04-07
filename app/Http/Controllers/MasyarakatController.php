<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class MasyarakatController extends Controller
{
    /**
     * Display all data Masyarakat.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_all()
    {
        $masyarakat = Masyarakat::with('users')->get();

        foreach ($masyarakat as $row) {
            $data[] = [
                'id_masyarakat' => $row->id_masyarakat,
                'id_users'      => $row->users[0]->id,
                'nik'           => $row->nik,
                'nama'          => $row->nama,
                'telp'          => $row->telp,
                'foto'          => $row->foto,
                'username'      => $row->users[0]->username,
            ];
        }

        return response()->json($data, 200);
    }

    /**
     * Display once of data Masyarakat
     * 
     * @param int $nik
     * @return \Illuminate\Http\Response
     */
    public function show_once($id_masyarakat)
    {
        $data = Masyarakat::firstWhere('id_masyarakat', $id_masyarakat);

        return response()->json($data);
    }

    /**
     * Store a new data Masyarakat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {                
        try {
            $request->validate([
                'nik'       => 'required|unique:masyarakat,nik|max:16',
                'nama'      => 'required|max:35',
                'username'  => 'required|unique:users,username|max:25',
                'password1' => 'required|min:4|max:32|same:password2',
                'password2' => 'required|min:4|max:32|same:password1',
                'telp'      => 'max:13',
                'foto'      => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024'
            ]);

            $imgName = time() . $request->foto->getClientOriginalName();

            $request->foto->move(public_path('img/user'), $imgName);
    
            $data = Masyarakat::create([
                'nik'  => $request->nik,
                'nama' => $request->nama,
                'telp' => $request->telp,
                'foto' => $imgName
            ]);

            $data->users()->create([
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
     * Update the profile account of Masyarakat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        try {
            $request->validate([
                'id_masyarakat' => 'required',
                'nik'           => 'required',
                'nama'          => 'required|unique:masyarakat,nama|max:25',
                'telp'          => 'required|max:13',
            ]);

            Masyarakat::where('id_masyarakat', $request->id_masyarakat)->update([
                'nik'      => $request->nik,
                'nama'     => $request->nama,
                'telp'     => $request->telp,
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
     * Update the password account of Masyarakat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        try {
            $request->validate([
                'nik'           => 'required',
                'old_password'  => 'required',
                'new_password1' => 'required|min:4|max:32|same:new_password2',
                'new_password2' => 'required|min:4|max:32|same:new_password1',
            ]);

            $data = Masyarakat::firstWhere('nik', $request->nik);

            // cek password lama
            $check = Hash::check($request->old_password, $data->password);

            if ($check) {
                $data->where('nik', $request->nik)->update([
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
     * Remove the specified data Masyarakat by NIk
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $masyarakat = Masyarakat::where('id_masyarakat', $request->id_masyarakat)->first();
    
                File::delete("img/user/{$masyarakat->foto}");
    
                $masyarakat->delete();
                
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
