<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Jadwal;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function input_jadwal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pelanggan' => 'required|string',
            'progress' => 'required|max:20',
            'waktu' => 'required|date_format:H:i',
            'catatan' => 'required|max:200',
            'tugas' => 'required|max:200',
            'karyawan1' => 'required|string',
            'karyawan2' => 'nullable|string',
            'karyawan3' => 'nullable|string',
            'karyawan4' => 'nullable|string',
            'karyawan5' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan response dengan status 422 dan pesan error
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $jadwal = new Jadwal();
        $jadwal->tanggal = $request->input('tanggal');
        $jadwal->pelanggan = $request->input('pelanggan');
        $jadwal->progress = $request->input('progress');
        $jadwal->waktu = $request->input('waktu');
        $jadwal->catatan = $request->input('catatan');
        $jadwal->tugas = $request->input('tugas');
        $jadwal->karyawan1 = $request->input('karyawan1');
        $jadwal->karyawan2 = $request->input('karyawan2');
        $jadwal->karyawan3 = $request->input('karyawan3');
        $jadwal->karyawan4 = $request->input('karyawan4');
        $jadwal->karyawan5 = $request->input('karyawan5');
        $jadwal->save();

        return response()->json($jadwal, 200);
    }

    //Belum ditest
    public function getall_jadwal(Request $request)
    {

        $tanggal = date('Y');
        $progress = 'belum dikerjakan';

        // Ambil data karya berdasarkan tanggal dan progress
        $jadwal = Jadwal::whereDate('tanggal', $tanggal)
            ->where('progress', $progress)
            ->get();

        return response()->json($jadwal, 200);
    }

    public function get_detail_jadwal($id)
    {
        $jadwal = Jadwal::with(['pelanggan', 'karyawan1', 'karyawan2', 'karyawan3', 'karyawan4', 'karyawan5'])->find($id);

        return response()->json($jadwal, 200);
    }

    public function get_edit_jadwal($id)
    {
        $jadwal = Jadwal::with(['pelanggan', 'karyawan1', 'karyawan2', 'karyawan3', 'karyawan4', 'karyawan5'])->findOrFail($id);

        $parameter = 'karyawan';
        $karyawan = User::where('level', $parameter)->get();
        $pelanggan = Pelanggan::all();

        $data = [
            'jadwal' => $jadwal,
            'pelanggan' => $pelanggan,
            'karyawan' => $karyawan,
        ];

        return response()->json($data, 200);
    }


    public function delete_jadwal($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return response()->json([
            'message' => 'Successfully delete pelanggan!'
        ], 200);
    }


    public function update_jadwal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pelanggan' => 'required|string',
            'progress' => 'required|max:20',
            'waktu' => 'required|date_format:H:i',
            'catatan' => 'required|max:200',
            'tugas' => 'required|max:200',
            'karyawan1' => 'required|string',
            'karyawan2' => 'nullable|string',
            'karyawan3' => 'nullable|string',
            'karyawan4' => 'nullable|string',
            'karyawan5' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan response dengan status 422 dan pesan error
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }


        // Update data prestasi di database
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->tanggal = $request->input('tanggal');
        $jadwal->pelanggan = $request->input('pelanggan');
        $jadwal->progress = $request->input('progress');
        $jadwal->waktu = $request->input('waktu');
        $jadwal->catatan = $request->input('catatan');
        $jadwal->tugas = $request->input('tugas');
        $jadwal->karyawan1 = $request->input('karyawan1');
        $jadwal->karyawan2 = $request->input('karyawan2');
        $jadwal->karyawan3 = $request->input('karyawan3');
        $jadwal->karyawan4 = $request->input('karyawan4');
        $jadwal->karyawan5 = $request->input('karyawan5');
        $jadwal->save();

        // Kembalikan response dengan status 200 dan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data jadwal berhasil diupdate'
        ], 200);
    }

    public function getall_jadwal_bulan()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $progressStatuses = ['sedang dikerjakan', 'belum dikerjakan'];

        // $jadwal = Jadwal::whereYear('tanggal', $tahunIni)
        $jadwal =  Jadwal::with('pelanggan')->WhereYear('tanggal', $tahunIni)
            ->whereMonth('tanggal', $bulanIni)
            ->whereIn('progress', $progressStatuses)
            ->get();

        return response()->json($jadwal, 200);
    }

    public function delete_jadwal_pelanggan($id)
    {
        $jadwal = Jadwal::where('pelanggan', $id);
        $jadwal->delete();

        return response()->json([
            'message' => 'Successfully delete some jadwal!'
        ], 200);
    }

    public function getall_form_jadwal()
    {
        $parameter = 'karyawan';
        $karyawan = User::where('level', $parameter)->get();
        $pelanggan = Pelanggan::all();


        $data = [
            'pelanggan' => $pelanggan,
            'karyawan' => $karyawan,
        ];
        return response()->json($data, 200);
    }

    public function get_search_jadwal(Request $request, $parameter)
    {
        $jadwal = Jadwal::with('pelanggan')->where('tanggal', 'like', '%' . $parameter . '%')
            ->orWhere('created_at', 'like', '%' . $parameter . '%')
            ->orWhere('pelanggan', 'like', '%' . $parameter . '%')
            ->orWhere('progress', 'like', '%' . $parameter . '%')
            ->orWhere('waktu', 'like', '%' . $parameter . '%')
            ->orWhere('catatan', 'like', '%' . $parameter . '%')
            ->orWhere('tugas', 'like', '%' . $parameter . '%')
            ->orWhere('karyawan1', 'like', '%' . $parameter . '%')
            ->orWhere('karyawan2', 'like', '%' . $parameter . '%')
            ->orWhere('karyawan3', 'like', '%' . $parameter . '%')
            ->orWhere('karyawan4', 'like', '%' . $parameter . '%')
            ->orWhere('karyawan5', 'like', '%' . $parameter . '%')
            // ->orWhere('progress', 'like', '%' . $parameter . '%')
            ->get();

        return response()->json($jadwal, 200);
    }

    public function delete_jadwal_karyawan($id)
    {
        // Mencari dan menghapus jadwal yang memiliki id_karyawan di antara karyawan1, karyawan2, karyawan3, karyawan4
        $jadwal = Jadwal::where('karyawan1', $id)
            ->orWhere('karyawan2', $id)
            ->orWhere('karyawan3', $id)
            ->orWhere('karyawan4', $id)
            ->delete();

        return response()->json([
            'message' => 'Successfully delete some jadwal!'
        ], 200);
    }
}
