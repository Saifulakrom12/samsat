<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function dashboard() {
        $jumlahUsers = User::count();
        return view('layout.config.dashboard', compact('jumlahUsers'));
    }

    // Menampilkan data user
    public function index() {
        $users = User::all();
        return view('layout.config.user.index', compact('users'));
    }

    // Menampilkan formulir tambah user
    public function user_create() {
        return view('layout.config.user.create');
    }

    // Menyimpan data user baru
    public function user_simpan(Request $request): RedirectResponse {
        $validator = \Validator::make($request->all(), [
            'nama'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.index')->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan formulir edit user
    public function user_edit($id) {
        $user = User::findOrFail($id);
        return view('layout.config.user.edit', compact('user'));
    }

    // Mengupdate data user
    public function user_update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'nama'     => 'required',
            'email'    => 'required|email',
            'password' => 'nullable', // Password bersifat opsional
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user->name = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
