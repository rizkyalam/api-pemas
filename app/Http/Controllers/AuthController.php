<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\Petugas;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {        
        $user = Auth::user();
        $people_type = explode('\\', $user->people_type);
        
        if($people_type[2] === 'Masyarakat') {
            $masyarakat = Masyarakat::find($user->people_id);

            $data = [
                'id_users' => $user->id,
                'id_masyarakat' => $user->people_id,
                'username' => $user->username,
                'nama' => $masyarakat->nama,
                'nik' => $masyarakat->nik,
                'telp' => $masyarakat->telp,
                'foto' => $masyarakat->foto,
                'level' => 'masyarakat'
            ];
        } else if ($people_type[2] === 'Petugas') {
            $petugas = Petugas::find($user->people_id);

            $data = [
                'id_users' => $user->id,
                'id_petugas' => $user->people_id,
                'username' => $user->username,
                'nama' => $petugas->nama_petugas,
                'telp' => $petugas->telp,
                'level' => $petugas->level
            ];
        }

        return response()->json($data);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}