<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function input_user(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string',
            'level' => 'required|string',
            'no_telp' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|confirmed',
            'email' => 'required|string',
            'nik' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        // Simpan file foto ke storage
        $fotoPath = $request->file('foto')->store('public/foto_user');

        $user = new User([
            'nama' => $request->nama,
            'level' => $request->level,
            'no_telp' => $request->no_telp,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'nik' => $request->nik,
            'foto' => $fotoPath, // Ubah '=' menjadi '=>'
        ]);

        $user->save();
        return response()->json($user, 201);
    }


    public function login_user(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'level' => 'required|string|in:owner,karyawan',
        ]);

        // Cari user berdasarkan username dan level
        $user = User::where('username', $request->username)
            ->where('level', $request->level)
            ->first();

        // Verifikasi password
        if ($user && Hash::check($request->password, $user->password)) {
            // Buat token API untuk user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Kembalikan respons dengan token
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);
        }

        // Kembalikan respons error jika login gagal
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function getall_user()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    public function delete_user($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'Successfully delete user!'
        ], 200);
    }

    public function update_user(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required|string',
            'no_telp' => 'required|string',
            'username' => 'required|string',
            'nik' => 'required|string',
            'password' => 'nullable|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000', // tambahkan validasi foto
        ]);

        $user = User::findOrFail($id);
        $user->nama = $request->nama;
        $user->no_telp = $request->no_telp;
        $user->username = $request->username;
        $user->nik = $request->nik;

        // Update password jika disediakan dan tidak kosong
        if ($request->has('password') && $request->password !== null) {
            $user->password = bcrypt($request->password);
        }

        // Update foto jika disediakan
        if ($request->hasFile('foto')) {
            // Simpan file foto ke storage
            $fotoPath = $request->file('foto')->store('public/foto_user');
            $user->foto = $fotoPath;
        }

        $user->save();
        return response()->json($user, 200);
    }

    public function get_detail_user($id)
    {
        $user = User::with(['jadwal1', 'jadwal2', 'jadwal3', 'jadwal4'])->find($id);
        return response()->json($user, 200);
    }

    public function get_search_user(Request $request, $parameter)
    {
        $user = User::where('nama', 'like', '%' . $parameter . '%')
            ->orWhere('created_at', 'like', '%' . $parameter . '%')
            ->orWhere('nik', 'like', '%' . $parameter . '%')
            ->orWhere('no_telp', 'like', '%' . $parameter . '%')
            ->orWhere('username', 'like', '%' . $parameter . '%')
            ->orWhere('level', 'like', '%' . $parameter . '%')
            ->get();

        return response()->json($user, 200);
    }
}
