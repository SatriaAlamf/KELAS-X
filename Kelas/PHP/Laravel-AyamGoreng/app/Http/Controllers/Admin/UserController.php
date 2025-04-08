<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,staff,customer',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,staff,customer',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }
    
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('password'),
        ]);
        
        return back()->with('success', 'Password pengguna telah direset ke "password".');
    }
    

    public function destroy($id)
{
    $user = User::findOrFail($id);

    // Prevent deletion of admin or staff if they are the currently authenticated user
    if (($user->role == 'admin' || $user->role == 'staff') && $user->id == auth()) {
        return back()->with('error', 'Anda tidak dapat menghapus pengguna ini.');
    }

    $user->delete();

    return redirect()->route('admin.users.index')
        ->with('success', 'Pengguna berhasil dihapus.');
}


}