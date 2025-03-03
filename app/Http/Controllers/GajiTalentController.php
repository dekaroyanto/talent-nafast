<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Talent;
use App\Models\GajiTalent;
use App\Models\SesiTalent;
use Illuminate\Http\Request;
use App\Exports\GajiTalentExport;
use Maatwebsite\Excel\Facades\Excel;

class GajiTalentController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = GajiTalent::with('talent');

        // Hanya filter jika kedua tanggal diisi
        if ($startDate && $endDate) {
            $query->whereBetween('periode_gaji_awal', [
                Carbon::parse($startDate)->format('Y-m-d'),
                Carbon::parse($endDate)->format('Y-m-d')
            ]);
        }

        $gajiTalentList = $query->get();

        return view('gaji_talent.index', compact('gajiTalentList', 'startDate', 'endDate'));
    }



    public function filter(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $gajiTalentList = GajiTalent::with('talent')
            ->whereBetween('periode_gaji_awal', [$startDate, $endDate])
            ->get();

        return view('gaji_talent.partial_table', compact('gajiTalentList'))->render();
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
        }

        return Excel::download(new GajiTalentExport($startDate, $endDate), 'Gaji_Talent_' . Carbon::now()->format('d-m-Y') . '.xlsx');
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

        return redirect()->route('gaji-talent.index')->with('success', 'Gaji Talent berhasil ditambahkan.');
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

        return redirect()->route('gaji-talent.index')->with('success', 'Gaji Talent berhasil diperbarui.');
    }

    public function rekapTalent()
    {
        $talents = Talent::all();
        return view('gaji_talent.rekap', compact('talents'));
    }

    // Function to calculate salary based on selected talent and period
    public function calculateSalary(Request $request)
    {
        $talent = Talent::find($request->talent_id);

        $startDate = Carbon::parse($request->periode_gaji_awal)->startOfDay();
        $endDate = Carbon::parse($request->periode_gaji_akhir)->endOfDay();

        $sesiLive = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$startDate, $endDate])
            ->where('jenis_sesi', 'live')
            ->sum('lama_sesi');

        $sesiVideo = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$startDate, $endDate])
            ->where('jenis_sesi', 'take_video')
            ->sum('lama_sesi');

        $omsetTotal = SesiTalent::where('talent_id', $request->talent_id)
            ->whereBetween('tanggal_waktu_mulai', [$startDate, $endDate])
            ->sum('total_omset');

        $feeLiveDidapat = round($talent->fee_live_perjam * $sesiLive, 2);
        $feeTakeVideoDidapat = round($talent->fee_take_video_perjam * $sesiVideo, 2);
        $rateOmsetPerJam = round(($omsetTotal / ($sesiLive ?: 1)), 2);

        $bonus = $request->bonus ?? 0;
        $totalGaji = round($feeLiveDidapat + $feeTakeVideoDidapat + $bonus, 2);

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

    public function destroy($id)
    {
        GajiTalent::findOrFail($id)->delete();
        return redirect()->route('gaji-talent.index')->with('success', 'Gaji Talent berhasil dihapus.');
    }
}
