<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use App\Models\SesiTalent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SesiTalentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SesiTalent::with('talent');

        // Filter berdasarkan nama talent
        if ($request->has('talent_id') && $request->talent_id != '') {
            $query->where('talent_id', $request->talent_id);
        }

        // Filter berdasarkan jenis sesi
        if ($request->has('jenis_sesi') && $request->jenis_sesi != '') {
            $query->where('jenis_sesi', $request->jenis_sesi);
        }

        // Mengurutkan berdasarkan tanggal waktu mulai dari yang terlama hingga terbaru
        $sesi = $query->orderBy('tanggal_waktu_mulai', 'desc')->get();  // 'desc' untuk urutan dari yang terbaru

        $talents = Talent::all();

        return view('sesi_talent.index', compact('sesi', 'talents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'talent_id' => 'required|exists:talent,id',
            'jenis_sesi' => 'required|in:take_video,live',
            'tanggal_waktu_mulai' => 'required|date',
        ]);

        // Buat sesi talent baru
        SesiTalent::create($validated);
        return redirect()->back()->with('success', 'Sesi Talent berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SesiTalent $sesiTalent)
    {
        $talents = Talent::all(); // Ambil data talent
        return view('sesi_talent.edit', compact('sesiTalent', 'talents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SesiTalent $sesiTalent)
    {
        $validated = $request->validate([
            'talent_id' => 'required|exists:talent,id',
            'jenis_sesi' => 'required|in:take_video,live',
            'tanggal_waktu_mulai' => 'required|date',
            'tanggal_waktu_selesai' => 'nullable|date|after:tanggal_waktu_mulai',
            'total_omset' => 'nullable|numeric',
            'list_video' => 'nullable|array',
            'list_video.*' => 'nullable|string|max:255',
        ]);

        $validated['list_video'] = $request->list_video ?? [];

        // Update sesi talent
        $sesiTalent->update($validated);

        // Jika tanggal_waktu_selesai ada, hitung lama sesi
        if ($sesiTalent->tanggal_waktu_selesai) {
            $tanggalWaktuMulai = Carbon::parse($sesiTalent->tanggal_waktu_mulai);
            $tanggalWaktuSelesai = Carbon::parse($sesiTalent->tanggal_waktu_selesai);

            $lamaSesi = $tanggalWaktuMulai->diffInMinutes($tanggalWaktuSelesai) / 60;
            $sesiTalent->update([
                'lama_sesi' => round($lamaSesi, 2),
                'total_omset' => $request->total_omset
            ]);
        }

        return redirect()->back()->with('success', 'Sesi Talent berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SesiTalent $sesiTalent)
    {
        $sesiTalent->delete();
        return redirect()->back()->with('success', 'Sesi Talent berhasil dihapus.');
    }
}
