<?php

namespace App\Http\Controllers;

use App\Models\GajiTalent;
use App\Models\Talent;
use App\Models\SesiTalent;
use Illuminate\Http\Request;

class GajiTalentController extends Controller
{
    public function index()
    {
        // Ambil semua data gaji talent dari database
        $gajiTalentList = GajiTalent::with('talent')->get(); // Menyertakan relasi dengan tabel talent

        return view('gaji_talent.index', compact('gajiTalentList'));
    }

    public function create()
    {
        $talents = Talent::all();
        return view('gaji_talent.create', compact('talents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'talent_id' => 'required',
            'periode_gaji_awal' => 'required|date',
            'periode_gaji_akhir' => 'required|date',
        ]);

        GajiTalent::create($request->all());

        return redirect()->route('gaji-talent.index');
    }

    public function edit($id)
    {
        $gajiTalent = GajiTalent::findOrFail($id);
        $talents = Talent::all();
        return view('gaji_talent.edit', compact('gajiTalent', 'talents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'talent_id' => 'required',
            'periode_gaji_awal' => 'required|date',
            'periode_gaji_akhir' => 'required|date',
        ]);

        $gajiTalent = GajiTalent::findOrFail($id);
        $gajiTalent->update($request->all());

        return redirect()->route('gaji-talent.index');
    }

    public function destroy($id)
    {
        GajiTalent::findOrFail($id)->delete();
        return redirect()->route('gaji-talent.index');
    }

    // Function to calculate salary based on selected talent and period
    public function calculateSalary(Request $request)
    {
        $talent = Talent::find($request->talent_id);

        // Ambil data sesi talent berdasarkan periode yang dipilih
        $sesiLive = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$request->periode_gaji_awal, $request->periode_gaji_akhir])
            ->where('jenis_sesi', 'live')
            ->sum('lama_sesi');

        $sesiVideo = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$request->periode_gaji_awal, $request->periode_gaji_akhir])
            ->where('jenis_sesi', 'take_video')
            ->sum('lama_sesi');

        $omsetTotal = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$request->periode_gaji_awal, $request->periode_gaji_akhir])
            ->sum('total_omset');

        // Menghitung fee dan total gaji, lalu membulatkan hasilnya
        $feeLiveDidapat = round($talent->fee_live_perjam * $sesiLive, 2);
        $feeTakeVideoDidapat = round($talent->fee_take_video_perjam * $sesiVideo, 2);
        $rateOmsetPerJam = round(($omsetTotal / ($sesiLive ?: 1)), 2); // Pastikan tidak terjadi pembagian dengan 0
        $totalGaji = round($feeLiveDidapat + $feeTakeVideoDidapat, 2);

        // Mengirimkan response JSON dengan nilai yang sudah dibulatkan
        return response()->json([
            'fee_live_perjam' => round($talent->fee_live_perjam, 2),
            'fee_take_video_perjam' => round($talent->fee_take_video_perjam, 2),
            'total_lama_sesi_live' => round($sesiLive, 2),
            'total_lama_sesi_take_video' => round($sesiVideo, 2),
            'fee_live_didapat' => $feeLiveDidapat,
            'fee_take_video_didapat' => $feeTakeVideoDidapat,
            'jumlah_total_omset' => round($omsetTotal, 2),
            'rate_omset_perjam' => $rateOmsetPerJam,
            'total_gaji' => $totalGaji,
        ]);
    }
}
