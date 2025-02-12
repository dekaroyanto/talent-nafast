<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Talent;
use App\Models\SesiTalent;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $talentcount = Talent::count();
        $sesi = SesiTalent::with('talent')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at terbaru
            ->get()
            ->take(3);
        $totalomset = SesiTalent::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_omset');
        $currentMonth = Carbon::now()->locale('id')->isoFormat('MMMM');
        return view('dashboard', compact('talentcount', 'totalomset', 'currentMonth', 'sesi'));
    }
}
