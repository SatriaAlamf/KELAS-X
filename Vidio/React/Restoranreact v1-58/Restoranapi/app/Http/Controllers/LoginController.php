<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(){
        $data = User::where('level','<>','pelanggan')->get();
        return response()->json($data);
    } 

    public function register(Request $request){
        
        $data = [
            'email' => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'level' => $request->input('level'),
            'api_token' => '12345',
            'status' => '1',
            'relasi' => $request->input('relasi'),
        ];

        User::create($data);

        return response()->json($data);
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
    
        $user = User::where('email', $email)->first();
    
        if ($user) {
            if ($user->status === 1) {
                if (Hash::check($password, $user->password)) {
                    $token = Str::random(40);
    
                    $user->update([
                        'api_token' => $token
                    ]);
    
                    // Kirim juga level user ke frontend agar bisa dipakai buat hak akses
                    return response()->json([
                        'pesan' => 'login berhasil',
                        'token' => $token,
                        'data' => [
                            'id' => $user->id,
                            'email' => $user->email,
                            'level' => $user->level, // pastikan ada field level di tabel user
                            'name' => $user->name // opsional, kalau perlu
                        ]
                    ]);
                } else {
                    return response()->json([
                        'pesan' => 'login gagal, password salah',
                        'data' => null
                    ], 401);
                }
            } else {
                return response()->json([
                    'pesan' => 'login gagal, user tidak aktif',
                    'data' => null
                ], 403);
            }
        } else {
            return response()->json([
                'pesan' => 'login gagal, user tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        //
        $user = User::where('id',$id)->update($request->all());

        if ($user) {
            return response()->json([
                'pesan' => 'Data Berhasil Di Update'
            ]);
        }
    }
}
