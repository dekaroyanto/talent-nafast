@extends('layouts.navbar')

@section('content')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
        }
    </style>
    <div class="container">
        <h2>Rekap Talent</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('gaji-talent.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="talent_id">Talent</label>
                        <select name="talent_id" id="talent_id" class="form-control">
                            <option value="">Select Talent</option>
                            @foreach ($talents as $talent)
                                <option value="{{ $talent->id }}">{{ $talent->nama_talent }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="periode_gaji_awal">Periode Gaji Awal</label>
                        <input type="date" class="form-control" name="periode_gaji_awal" id="periode_gaji_awal" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="periode_gaji_akhir">Periode Gaji Akhir</label>
                        <input type="date" class="form-control" name="periode_gaji_akhir" id="periode_gaji_akhir"
                            required>
                    </div>

                    <table>
                        <tbody>
                            <tr>
                                <td>Total Lama Sesi Live</td>
                                <td><input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live"
                                        class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Total Lama Sesi Take Video</td>
                                <td><input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                                        class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Fee Live Didapat</td>
                                <td><input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control"
                                        readonly></td>
                            </tr>
                            <tr>
                                <td>Fee Take Video Didapat</td>
                                <td><input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat"
                                        class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Jumlah Total Omset</td>
                                <td><input type="number" name="jumlah_total_omset" id="jumlah_total_omset"
                                        class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Rate Omset Perjam</td>
                                <td><input type="number" name="rate_omset_perjam" id="rate_omset_perjam"
                                        class="form-control" readonly></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="display: none">
                        <div class="form-floating mb-2">
                            <input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control" readonly>
                            <label for="fee_live_perjam">Fee Live per Jam</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam"
                                class="form-control" readonly>
                            <label for="fee_take_video_perjam">Fee Take Video per Jam</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live" class="form-control"
                                readonly>
                            <label for="total_lama_sesi_live">Total Lama Sesi Live</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                                class="form-control" readonly>
                            <label for="total_lama_sesi_take_video">Total Lama Sesi Take Video</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control"
                                readonly>
                            <label for="fee_live_didapat">Fee Live Didapat</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat"
                                class="form-control" readonly>
                            <label for="fee_take_video_didapat">Fee Take Video Didapat</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="jumlah_total_omset" id="jumlah_total_omset" class="form-control"
                                readonly>
                            <label for="jumlah_total_omset">Jumlah Total Omset</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="rate_omset_perjam" id="rate_omset_perjam" class="form-control"
                                readonly>
                            <label for="rate_omset_perjam">Rate Omset per Jam</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="bonus" id="bonus" class="form-control" step="0.01"
                                value="0">
                            <label for="bonus">Bonus</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" name="total_gaji" id="total_gaji" class="form-control" readonly>
                            <label for="total_gaji">Total Gaji</label>
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>

    <script>
        const calculateTotalSalary = () => {
            const feeLiveDidapat = parseFloat(document.getElementById('fee_live_didapat').value) || 0;
            const feeTakeVideoDidapat = parseFloat(document.getElementById('fee_take_video_didapat').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;

            const totalGaji = feeLiveDidapat + feeTakeVideoDidapat + bonus;
            document.getElementById('total_gaji').value = totalGaji.toFixed(2);
        };

        document.getElementById('talent_id').addEventListener('change', function() {
            const talent_id = this.value;
            const periode_awal = document.getElementById('periode_gaji_awal').value;
            const periode_akhir = document.getElementById('periode_gaji_akhir').value;

            if (talent_id && periode_awal && periode_akhir) {
                fetch('{{ route('gaji-talent.calculate-salary') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            talent_id,
                            periode_gaji_awal: periode_awal,
                            periode_gaji_akhir: periode_akhir,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('fee_live_perjam').value = data.fee_live_perjam || 0;
                        document.getElementById('fee_take_video_perjam').value = data.fee_take_video_perjam ||
                            0;
                        document.getElementById('total_lama_sesi_live').value = data.total_lama_sesi_live || 0;
                        document.getElementById('total_lama_sesi_take_video').value = data
                            .total_lama_sesi_take_video || 0;
                        document.getElementById('fee_live_didapat').value = data.fee_live_didapat || 0;
                        document.getElementById('fee_take_video_didapat').value = data.fee_take_video_didapat ||
                            0;
                        document.getElementById('jumlah_total_omset').value = data.jumlah_total_omset || 0;
                        document.getElementById('rate_omset_perjam').value = data.rate_omset_perjam || 0;

                        calculateTotalSalary();
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        document.getElementById('bonus').addEventListener('input', calculateTotalSalary);
        document.getElementById('periode_gaji_awal').addEventListener('change', function() {
            document.getElementById('talent_id').dispatchEvent(new Event('change'));
        });
        document.getElementById('periode_gaji_akhir').addEventListener('change', function() {
            document.getElementById('talent_id').dispatchEvent(new Event('change'));
        });
    </script>
@endsection
