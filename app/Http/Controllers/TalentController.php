<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talents = Talent::all();
        return view('talent.index', compact('talents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_talent' => 'required',
            'fee_live_perjam' => 'required',
            'fee_take_video_perjam' => 'required',
        ], [
            'nama_talent.required' => 'Nama talent harus diisi.',
            'fee_live_perjam.required' => 'Fee live perjam harus diisi.',
            'fee_take_video_perjam.required' => 'Fee take video perjam harus diisi.',
        ]);

        Talent::create([
            'nama_talent' => $request->nama_talent,
            'fee_live_perjam' => $request->fee_live_perjam,
            'fee_take_video_perjam' => $request->fee_take_video_perjam
        ]);

        return redirect()->route('talent.index')->with('success', 'Talent berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Talent $talent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talent $talent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $talent = Talent::findOrFail($id);

        $validated = $request->validate([
            'nama_talent' => 'required|string|max:255',
            'fee_live_perjam' => 'required|numeric',
            'fee_take_video_perjam' => 'required|numeric',
        ]);

        $talent->update($validated);

        return redirect()->route('talent.index')->with('success', 'Talent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talent $talent)
    {
        $talent->delete();
        return redirect()->route('talent.index')->with('success', 'Talent deleted successfully.');
    }
}
