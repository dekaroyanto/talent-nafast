<!-- resources/views/gaji_talent/create.blade.php -->
@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h1>Form Gaji Talent</h1>
        <form action="{{ route('gaji-talent.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="talent_id">Talent</label>
                <select class="form-control" id="talent_id" name="talent_id">
                    <option value="">Pilih Talent</option>
                    @foreach ($talents as $talent)
                        <option value="{{ $talent->id }}" data-fee-live="{{ $talent->fee_live_perjam }}"
                            data-fee-video="{{ $talent->fee_take_video_perjam }}">{{ $talent->nama_talent }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="periode_awal">Periode Awal</label>
                <input type="date" class="form-control" id="periode_awal" name="periode_awal" required>
            </div>

            <div class="form-group">
                <label for="periode_akhir">Periode Akhir</label>
                <input type="date" class="form-control" id="periode_akhir" name="periode_akhir" required>
            </div>

            <div class="form-group">
                <label for="fee_live_perjam">Fee Live Per Jam</label>
                <input type="number" class="form-control" id="fee_live_perjam" name="fee_live_perjam" readonly>
            </div>

            <div class="form-group">
                <label for="fee_take_video_perjam">Fee Take Video Per Jam</label>
                <input type="number" class="form-control" id="fee_take_video_perjam" name="fee_take_video_perjam" readonly>
            </div>

            <div class="form-group">
                <label for="total_lama_sesi_live">Total Lama Sesi Live</label>
                <input type="number" class="form-control" id="total_lama_sesi_live" name="total_lama_sesi_live" readonly>
            </div>

            <div class="form-group">
                <label for="total_lama_sesi_take_video">Total Lama Sesi Take Video</label>
                <input type="number" class="form-control" id="total_lama_sesi_take_video" name="total_lama_sesi_take_video"
                    readonly>
            </div>

            <div class="form-group">
                <label for="jumlah_total_omset">Jumlah Total Omset</label>
                <input type="number" class="form-control" id="jumlah_total_omset" name="jumlah_total_omset" readonly>
            </div>

            <div class="form-group">
                <label for="rate_omset_perjam">Rate Omset Per Jam</label>
                <input type="number" class="form-control" id="rate_omset_perjam" name="rate_omset_perjam" readonly>
            </div>

            <div class="form-group">
                <label for="total_fee_live">Total Fee Live</label>
                <input type="number" class="form-control" id="total_fee_live" name="total_fee_live" readonly>
            </div>

            <div class="form-group">
                <label for="total_fee_take_video">Total Fee Take Video</label>
                <input type="number" class="form-control" id="total_fee_take_video" name="total_fee_take_video" readonly>
            </div>

            <div class="form-group">
                <label for="gaji_talent">Gaji Talent</label>
                <input type="number" class="form-control" id="gaji_talent" name="gaji_talent" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        document.getElementById('talent_id').addEventListener('change', function() {
            var talentId = this.value;
            var feeLivePerJam = this.selectedOptions[0].dataset.feeLive;
            var feeTakeVideoPerJam = this.selectedOptions[0].dataset.feeVideo;

            document.getElementById('fee_live_perjam').value = feeLivePerJam;
            document.getElementById('fee_take_video_perjam').value = feeTakeVideoPerJam;

            updatePerhitungan(talentId);
        });

        document.getElementById('periode_awal').addEventListener('change', function() {
            var talentId = document.getElementById('talent_id').value;
            updatePerhitungan(talentId);
        });

        document.getElementById('periode_akhir').addEventListener('change', function() {
            var talentId = document.getElementById('talent_id').value;
            updatePerhitungan(talentId);
        });

        function updatePerhitungan(talentId) {
            var periodeAwal = document.getElementById('periode_awal').value;
            var periodeAkhir = document.getElementById('periode_akhir').value;

            if (talentId && periodeAwal && periodeAkhir) {
                fetch(`/api/gaji-talent/perhitungan/${talentId}?periode_awal=${periodeAwal}&periode_akhir=${periodeAkhir}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('total_lama_sesi_live').value = data.total_lama_sesi_live;
                        document.getElementById('total_lama_sesi_take_video').value = data.total_lama_sesi_take_video;
                        document.getElementById('jumlah_total_omset').value = data.jumlah_total_omset;
                        document.getElementById('rate_omset_perjam').value = data.rate_omset_perjam;
                        document.getElementById('total_fee_live').value = data.total_fee_live;
                        document.getElementById('total_fee_take_video').value = data.total_fee_take_video;
                        document.getElementById('gaji_talent').value = data.gaji_talent;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
@endsection
