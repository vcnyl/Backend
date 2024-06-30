<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function input_pelanggan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'no_telp' => 'required|max:50',
            'alamat' => 'required|max:200',
            'maps' => 'required|url',
            'foto_rumah' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan response dengan status 422 dan pesan error
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->input('nama');
        $pelanggan->no_telp = $request->input('no_telp');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->maps = $request->input('maps');
        $pelanggan->foto_rumah = $request->file('foto_rumah')->store('public/foto_rumah');
        $pelanggan->save();

        return response()->json($pelanggan, 200);
    }

    //Fuction ini untuk mengambil semua data akun admin dan di tampilkan di data admin (sudut pandang admin)
    public function getall_pelanggan()
    {
        $pelanggan = Pelanggan::all();
        return response()->json($pelanggan, 200);
    }

    public function get_detail_pelanggan($id)
    {
        $pelanggan = Pelanggan::with('jadwal')->find($id);

        return response()->json($pelanggan, 200);
    }

    public function delete_pelanggan($id)
    {
        $pelanggan = Pelanggan::find($id);
        $pelanggan->delete();

        return response()->json([
            'message' => 'Successfully delete pelanggan!'
        ], 200);
    }

    public function update_pelanggan(Request $request, $id)
    {
        // Validasi data yang dibutuhkan
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'no_telp' => 'required|max:50',
            'alamat' => 'required|max:200',
            'maps' => 'required|url',
            'foto_rumah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan response dengan status 422 dan pesan error
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // Update data karya di database
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->nama = $request->input('nama');
        $pelanggan->no_telp = $request->input('no_telp');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->maps = $request->input('maps');

        if ($request->hasFile('foto_rumah')) {

            if ($pelanggan->foto_rumah) {
                Storage::delete($pelanggan->foto_rumah);
            }

            // Mengunggah foto profil baru dan menyimpan path-nya
            $pelanggan->foto_rumah = $request->file('foto_rumah')->store('public/foto_rumah');
        }

        $pelanggan->save();

        // Kembalikan response dengan status 200 dan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data pelanggan berhasil diupdate'
        ], 200);
    }


    public function get_search_pelanggan(Request $request, $parameter)
    {
        $pelanggan = Pelanggan::where('nama', 'like', '%' . $parameter . '%')
            ->orWhere('created_at', 'like', '%' . $parameter . '%')
            ->orWhere('no_telp', 'like', '%' . $parameter . '%')
            ->orWhere('alamat', 'like', '%' . $parameter . '%')
            //  ->orWhere('nama_pembimbing', 'like', '%' . $parameter . '%')
            ->get();

        return response()->json($pelanggan, 200);
    }
}
