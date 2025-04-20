<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris=Kategori::all();

        $menus=Menu::join('kategoris','menus.idkategori','=','kategoris.idkategori')->select(['menus.*','kategoris.*'])->paginate(2);
        return view('backend.menu.select',['menus'=>$menus,'kategoris'=>$kategoris]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris=Kategori::all();
        return view('backend.menu.insert',['kategoris'=>$kategoris]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'gambar' => 'required|max:2049',
            'menu' => 'required',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);
        
        $id=$request->idkategori;
        $namagambar=$request->file('gambar')->getClientOriginalName();
        $request->gambar->move(public_path('gambar'),$namagambar);
        Menu::create([
            'idkategori'=>$id,
            'menu'=>$data['menu'],
            'deskripsi'=>$data['deskripsi'],
            'harga'=>$data['harga'],    
            'gambar'=>$namagambar,
        ]);
        return redirect('admin/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Menu::where('id', '=', $id)->delete(); // Change 'idmenu' to 'id'
        return redirect('admin/menu');
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($idmenu)
    {
        $kategoris = Kategori::all();
        $menu = Menu::where('idmenu', $idmenu)->first();
        return view('backend.menu.update', ['menu' => $menu, 'kategoris' => $kategoris]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idmenu)
    {
        if (isset($request->gambar)) {
            // Handle image upload
            $namagambar = $request->file('gambar')->getClientOriginalName();

            
            $data = $request->validate([
                'gambar'=>'required|max:2048',
                'menu' => 'required',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric',
            ]);
            
            Menu::where('idmenu', $idmenu)->update([
                'idkategori' => $request->idkategori,
                'menu' => $data['menu'],
                'deskripsi' => $data['deskripsi'],
                'harga' => $data['harga'],
                'gambar' => $namagambar
            ]);
            $request->gambar->move(public_path('gambar'), $namagambar);
        } else {
            $data = $request->validate([
                'menu' => 'required',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric',
            ]);
            
            Menu::where('idmenu', $idmenu)->update([
                'idkategori' => $request->idkategori,
                'menu' => $data['menu'],
                'deskripsi' => $data['deskripsi'],
                'harga' => $data['harga']
            ]);
            
        }
        
        return redirect('admin/menu');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
    public function select(Request $request){
        $id=$request->idkategori;
        $kategoris=Kategori::all();

        $menus=Menu::join('kategoris','menus.idkategori','=','kategoris.idkategori')
        ->select(['menus.*','kategoris.*'])
        ->where('menus.idkategori',$id)
        ->paginate(2);
        return view('backend.menu.select',['menus'=>$menus,'kategoris'=>$kategoris]);
    }
}
