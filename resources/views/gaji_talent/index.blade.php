@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2>Daftar Gaji Talent</h2>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Talent</th>
                                <th>Periode Gaji</th>
                                <th>Fee Live/Jam</th>
                                <th>Fee Take Video/Jam</th>
                                <th>Total Lama Sesi Live</th>
                                <th>Total Lama Sesi Take Video</th>
                                <th>Fee Live Didapat</th>
                                <th>Fee Take Video Didapat</th>
                                <th>Jumlah Total Omset</th>
                                <th>Rate Omset per Jam</th>
                                <th>Total Gaji</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gajiTalentList as $index => $gaji)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $gaji->talent->nama_talent }}</td>
                                    <td>{{ \Carbon\Carbon::parse($gaji->periode_gaji_awal)->format('j M Y') }} -
                                        {{ \Carbon\Carbon::parse($gaji->periode_gaji_akhir)->format('j M Y') }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_live_perjam, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_take_video_perjam, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->total_lama_sesi_live, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->total_lama_sesi_take_video, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_live_didapat, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_take_video_didapat, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->jumlah_total_omset, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->rate_omset_perjam, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->total_gaji, 2) }}</td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <!-- Action Buttons (Edit, Delete) -->
                                        <a href="{{ route('gaji-talent.edit', $gaji->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('gaji-talent.destroy', $gaji->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
