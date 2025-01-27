@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2>Create Gaji Talent</h2>
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
                    <div class="form-group">
                        <label for="periode_gaji_akhir">Periode Gaji Akhir</label>
                        <input type="date" class="form-control" name="periode_gaji_akhir" id="periode_gaji_akhir"
                            required>
                    </div>

                    <h4>Perhitungan Gaji Talent</h4>
                    <div class="form-floating mb-2">
                        <input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control" readonly>
                        <label for="fee_live_perjam">Fee Live per Jam</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam" class="form-control"
                            readonly>
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
                        <input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control" readonly>
                        <label for="fee_live_didapat">Fee Live Didapat</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat" class="form-control"
                            readonly>
                        <label for="fee_take_video_didapat">Fee Take Video Didapat</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="number" name="jumlah_total_omset" id="jumlah_total_omset" class="form-control"
                            readonly>
                        <label for="jumlah_total_omset">Jumlah Total Omset</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="number" name="rate_omset_perjam" id="rate_omset_perjam" class="form-control" readonly>
                        <label for="rate_omset_perjam">Rate Omset per Jam</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="number" name="total_gaji" id="total_gaji" class="form-control" readonly>
                        <label for="total_gaji">Total Gaji</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

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
