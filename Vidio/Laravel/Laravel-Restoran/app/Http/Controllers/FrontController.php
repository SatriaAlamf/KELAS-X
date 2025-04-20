<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{

    public function index()
    {
        $kategoris = Kategori::all();
        $menus = Menu::paginate(3);

        return view('menu', compact('kategoris', 'menus'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'jeniskelamin' => 'required',
            'email' => 'required | email | unique:pelanggans',
            'password' => 'required | min:3',
        ]);

        Pelanggan::create([
            'pelanggan' => $validated['pelanggan'],
            'jeniskelamin' => $validated['jeniskelamin'],
            'alamat' => $validated['alamat'],
            'telp' => $validated['telp'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'aktif' => 1
        ]);

        return redirect('/');
    }


    public function show(string $id)
    {
        $kategoris = Kategori::all();
        $menus = Menu::where('idkategori', $id)->paginate(3);

        return view('kategori', compact('kategoris', 'menus'));
    }


    public function register()
    {
        $kategoris = Kategori::all();
        return view('register', compact('kategoris'));
    }
    public function login()
    {
        $kategoris = Kategori::all();
        return view('login', compact('kategoris'));
    }
    public function postlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required | min:3',
        ]);
        
        $pelanggan = Pelanggan::where('email', $credentials['email'])->where('aktif', 1)->first();

        if ($pelanggan) {
            if (Hash::check($credentials['password'], $pelanggan['password'])) {
                $sessionData = [
                    'idpelanggan' => $pelanggan['idpelanggan'],
                    'email' => $pelanggan['email'],
                ];
                $request->session()->put('idpelanggan', $sessionData);
                return redirect('/');
            } else {
                return back()->with('pesan', 'Password Salah');
            }
        } else {
            return back()->with('pesan', 'Email Belum Terdaftar');
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}