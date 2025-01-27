@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2>Create Gaji Talent</h2>
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
            <div class="form-group">
                <label for="periode_gaji_akhir">Periode Gaji Akhir</label>
                <input type="date" class="form-control" name="periode_gaji_akhir" id="periode_gaji_akhir" required>
            </div>

            <h4>Perhitungan Gaji Talent</h4>
            <table class="table">
                <tr>
                    <td>Fee Live per Jam</td>
                    <td><input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Fee Take Video per Jam</td>
                    <td><input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam" class="form-control"
                            readonly></td>
                </tr>
                <tr>
                    <td>Total Lama Sesi Live</td>
                    <td><input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live" class="form-control"
                            readonly></td>
                </tr>
                <tr>
                    <td>Total Lama Sesi Take Video</td>
                    <td><input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                            class="form-control" readonly></td>
                </tr>
                <tr>
                    <td>Fee Live Didapat</td>
                    <td><input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Fee Take Video Didapat</td>
                    <td><input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat" class="form-control"
                            readonly></td>
                </tr>
                <tr>
                    <td>Jumlah Total Omset</td>
                    <td><input type="number" name="jumlah_total_omset" id="jumlah_total_omset" class="form-control"
                            readonly></td>
                </tr>
                <tr>
                    <td>Rate Omset per Jam</td>
                    <td><input type="number" name="rate_omset_perjam" id="rate_omset_perjam" class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Total Gaji</td>
                    <td><input type="number" name="total_gaji" id="total_gaji" class="form-control" readonly></td>
                </tr>
            </table>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script>
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
                        // Pastikan data sudah diterima dan pastikan isi data dengan console.log jika perlu
                        console.log(data); // Debugging output

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
                        document.getElementById('total_gaji').value = data.total_gaji || 0;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

        // Trigger calculation when periode dates are changed
        document.getElementById('periode_gaji_awal').addEventListener('change', function() {
            document.getElementById('talent_id').dispatchEvent(new Event('change'));
        });
        document.getElementById('periode_gaji_akhir').addEventListener('change', function() {
            document.getElementById('talent_id').dispatchEvent(new Event('change'));
        });
    </script>
@endsection
