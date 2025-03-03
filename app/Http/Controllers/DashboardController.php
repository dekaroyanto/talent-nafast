<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Talent;
use App\Models\SesiTalent;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request atau gunakan bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Query data sesuai filter
        $talentcount = Talent::count();
        $sesi = SesiTalent::with('talent')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $totalomset = SesiTalent::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('total_omset');

        // Format bulan dalam bahasa Indonesia
        $currentMonth = Carbon::createFromDate($year, $month, 1)->locale('id')->isoFormat('MMMM YYYY');

        return view('dashboard', compact('talentcount', 'totalomset', 'currentMonth', 'sesi', 'month', 'year'));
    }
}
