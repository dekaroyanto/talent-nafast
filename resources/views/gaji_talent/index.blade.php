@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2>Daftar Gaji Talent</h2>

        <!-- Form Import Excel -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('gaji-talent.import-excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center d-flex">
                        <div class="col-md-4">
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Import Excel</button>
                            <a href="{{ route('gaji-talent.template-excel') }}" class="btn btn-success">Download Template</a>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form Filter Tanggal -->
        <form id="filterForm" method="GET" action="{{ route('gaji-talent.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Tanggal Awal:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date">Tanggal Akhir:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>
            </div>
        </form>
        <a href="{{ route('gaji-talent.index') }}" class="btn btn-secondary">Reset</a>
        <a href="{{ route('gaji-talent.create') }}" class="btn btn-primary">Tambah Gaji</a>

        <!-- Tombol Export Excel -->
        <form action="{{ route('gaji-talent.export-excel') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <button type="submit" class="btn btn-success">Export Excel</button>
        </form>



        <!-- Tabel Data Gaji Talent -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
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
                                <th>Bonus</th>
                                <th>Total Gaji</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($gajiTalentList as $gaji)
                                <tr>
                                    <td>{{ $gaji->talent->nama_talent }}</td>
                                    <td>{{ \Carbon\Carbon::parse($gaji->periode_gaji_awal)->translatedFormat('d F Y') }} -
                                        {{ \Carbon\Carbon::parse($gaji->periode_gaji_akhir)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>Rp. {{ number_format($gaji->fee_live_perjam, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_take_video_perjam, 2) }}</td>
                                    <td>{{ number_format($gaji->total_lama_sesi_live, 2) }} Jam</td>
                                    <td>{{ number_format($gaji->total_lama_sesi_take_video, 2) }} Jam</td>
                                    <td>Rp. {{ number_format($gaji->fee_live_didapat, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->fee_take_video_didapat, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->jumlah_total_omset, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->rate_omset_perjam, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->bonus, 2) }}</td>
                                    <td>Rp. {{ number_format($gaji->total_gaji, 2) }}</td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <!-- Action Buttons (Edit, Delete) -->
                                        <a href="{{ route('gaji-talent.edit', $gaji->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('gaji-talent.destroy', $gaji->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('start_date').addEventListener('change', filterData);
        document.getElementById('end_date').addEventListener('change', filterData);

        function filterData() {
            let startDate = document.getElementById('start_date').value;
            let endDate = document.getElementById('end_date').value;

            // Submit form hanya jika kedua tanggal sudah dipilih
            if (startDate && endDate) {
                document.getElementById('filterForm').submit();
            }
        }
    </script>
@endsection
