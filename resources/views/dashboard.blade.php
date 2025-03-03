@extends('layouts.navbar')

@section('content')
    <div class="col-xl-4 col-md-6">
        <div class="card bg-green-500 dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-users"></i>
                        </div>
                    </div>

                </div>
                <span class="text-white d-block f-34 f-w-500 my-2">
                    {{ $talentcount }}
                </span>
                <p class="mb-0 opacity-100">Jumlah Talent</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-credit-card"></i>
                        </div>
                    </div>

                </div>
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select id="month" name="month" class="form-control">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="year" name="year" class="form-control">
                                @foreach (range(date('Y') - 5, date('Y')) as $y)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane show active" id="chart-tab-home" role="tabpanel"
                        aria-labelledby="chart-tab-home-tab" tabindex="0">
                        <div class="row">
                            <div class="col-8">
                                <span class="text-white d-block f-34 f-w-500 my-2">
                                    {{ 'Rp ' . number_format($totalomset, 0, ',', '.') }}
                                </span>
                                <p class="mb-0 opacity-100">Total Omset Bulan {{ $currentMonth }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <h2>Sesi Talent Terbaru</h2>
    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Nama Talent</th>
                                <th>Jenis Sesi</th>
                                <th>Tanggal Waktu Mulai</th>
                                <th>Tanggal Waktu Selesai</th>
                                <th>Lama Sesi (jam)</th>
                                <th>Total Omset</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($sesi as $item)
                                <tr>
                                    <td>{{ $item->talent->nama_talent }}</td>
                                    <td>{{ ucfirst($item->jenis_sesi) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_waktu_mulai)->format('d M Y H:i') }}</td>

                                    <td>{{ $item->tanggal_waktu_selesai ? \Carbon\Carbon::parse($item->tanggal_waktu_selesai)->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td>{{ $item->lama_sesi ?? '-' }}</td>
                                    <td>{{ 'Rp ' . number_format($item->total_omset, 0, ',', '.') }}</td>
                                    <td class="d-flex gap-2 justify-content-center">

                                        @if (!$item->tanggal_waktu_selesai)
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editSesiModal{{ $item->id }}">Edit</button>
                                        @else
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editSesiModal{{ $item->id }}">Edit</button>
                                        @endif
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteSesiModal{{ $item->id }}">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
