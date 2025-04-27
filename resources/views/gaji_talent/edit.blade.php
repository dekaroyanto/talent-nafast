@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Gaji Talent</h2>
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('gaji-talent.update', $gajiTalent->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="talent_id" class="form-label">Talent</label>
                                <select name="talent_id" id="talent_id" class="form-select" style="pointer-events: none">
                                    <option value="">Select Talent</option>
                                    @foreach ($talents as $talent)
                                        <option value="{{ $talent->id }}"
                                            {{ $talent->id == $gajiTalent->talent_id ? 'selected' : '' }}>
                                            {{ $talent->nama_talent }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_gaji_awal" class="form-label">Periode Awal</label>
                                <input type="date" class="form-control" name="periode_gaji_awal" id="periode_gaji_awal"
                                    value="{{ $gajiTalent->periode_gaji_awal }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_gaji_akhir" class="form-label">Periode Akhir</label>
                                <input type="date" class="form-control" name="periode_gaji_akhir" id="periode_gaji_akhir"
                                    value="{{ $gajiTalent->periode_gaji_akhir }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Calculation Section -->
                    <h4 class="mb-3 border-bottom pb-2">Perhitungan Gaji Talent</h4>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control"
                                    value="{{ $gajiTalent->fee_live_perjam }}" step="0.01"
                                    onchange="calculateTotalSalary()">
                                <label for="fee_live_perjam">Fee Live per Jam</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam"
                                    class="form-control" value="{{ $gajiTalent->fee_take_video_perjam }}" step="0.01"
                                    onchange="calculateTotalSalary()">
                                <label for="fee_take_video_perjam">Fee Take Video per Jam</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_pervideo" id="fee_pervideo" class="form-control"
                                    value="{{ $gajiTalent->fee_pervideo }}" step="0.01"
                                    onchange="calculateTotalSalary()">
                                <label for="fee_pervideo">Fee per Video</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control"
                                    value="{{ $gajiTalent->fee_live_didapat }}" readonly>
                                <label for="fee_live_didapat">Fee Live Didapat</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat"
                                    class="form-control" value="{{ $gajiTalent->fee_take_video_didapat }}" readonly>
                                <label for="fee_take_video_didapat">Fee Take Video Didapat</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_pervideo_didapat" id="fee_pervideo_didapat"
                                    class="form-control" value="{{ $gajiTalent->fee_pervideo_didapat }}" readonly>
                                <label for="fee_pervideo_didapat">Fee per Video Didapat</label>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live"
                                    class="form-control" value="{{ $gajiTalent->total_lama_sesi_live }}" readonly>
                                <label for="total_lama_sesi_live">Total Lama Sesi Live (jam)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                                    class="form-control" value="{{ $gajiTalent->total_lama_sesi_take_video }}" readonly>
                                <label for="total_lama_sesi_take_video">Total Lama Sesi Take Video (jam)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="total_video" id="total_video" class="form-control"
                                    min="0" value="{{ $gajiTalent->total_video }}"
                                    onchange="calculateTotalSalary()">
                                <label for="total_video">Total Video</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="jumlah_total_omset" id="jumlah_total_omset"
                                    class="form-control" value="{{ $gajiTalent->jumlah_total_omset }}" readonly>
                                <label for="jumlah_total_omset">Jumlah Total Omset</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="rate_omset_perjam" id="rate_omset_perjam"
                                    class="form-control" value="{{ $gajiTalent->rate_omset_perjam }}" readonly>
                                <label for="rate_omset_perjam">Rate Omset per Jam</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="bonus" id="bonus" class="form-control" step="0.01"
                                    value="{{ $gajiTalent->bonus }}" onchange="calculateTotalSalary()">
                                <label for="bonus">Bonus</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="total_gaji" id="total_gaji" class="form-control fw-bold"
                            value="{{ $gajiTalent->total_gaji }}" readonly>
                        <label for="total_gaji">Total Gaji</label>
                    </div>

                    <div class="mb-3">
                        <label for="list_video" class="form-label">List Video</label>
                        <div id="list_video_container" class="mb-2">
                            @foreach ($gajiTalent->list_video as $video)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="list_video[]"
                                        value="{{ $video }}" placeholder="Nama Video">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeVideo(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add_video_btn">
                            <i class="fas fa-plus"></i> Add Video
                        </button>
                    </div>
                    <input type="hidden" name="list_video_json" id="list_video_json">

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan tombol hapus berfungsi pada video lama
            const videoContainer = document.getElementById('list_video_container');
            videoContainer.querySelectorAll('.input-group').forEach(function(inputGroup) {
                const button = inputGroup.querySelector('button');
                button.onclick = function() {
                    removeVideo(inputGroup); // Tombol hapus berfungsi pada video lama
                };
            });

            updateListVideoJson();
            updateTotalVideo();
        });
        // Your existing JavaScript remains the same
        const calculateTotalSalary = () => {
            const feeLivePerJam = parseFloat(document.getElementById('fee_live_perjam').value) || 0;
            const feeTakeVideoPerJam = parseFloat(document.getElementById('fee_take_video_perjam').value) || 0;
            const feePerVideo = parseFloat(document.getElementById('fee_pervideo').value) || 0;
            const totalVideo = parseFloat(document.getElementById('total_video').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;

            // Perhitungan otomatis berdasarkan input
            const totalSesiLive = parseFloat(document.getElementById('total_lama_sesi_live').value) || 0;
            const totalSesiTakeVideo = parseFloat(document.getElementById('total_lama_sesi_take_video').value) || 0;

            // Hasil perhitungan Fee Didapat
            const feeLiveDidapat = feeLivePerJam * totalSesiLive;
            const feeTakeVideoDidapat = feeTakeVideoPerJam * totalSesiTakeVideo;
            const feePerVideoDidapat = feePerVideo * totalVideo;

            document.getElementById('fee_live_didapat').value = feeLiveDidapat.toFixed(2);
            document.getElementById('fee_take_video_didapat').value = feeTakeVideoDidapat.toFixed(2);
            document.getElementById('fee_pervideo_didapat').value = feePerVideoDidapat.toFixed(2);

            // Total gaji
            const totalGaji = feeLiveDidapat + feeTakeVideoDidapat + feePerVideoDidapat + bonus;
            document.getElementById('total_gaji').value = totalGaji.toFixed(2);
        };

        // Fungsi untuk menghapus video
        function removeVideo(inputGroup) {
            const container = document.getElementById('list_video_container');
            container.removeChild(inputGroup); // Hapus video dari DOM
            updateListVideoJson();
            updateTotalVideo();
        }

        // Fungsi untuk memperbarui data video dalam format JSON
        function updateListVideoJson() {
            const videos = Array.from(document.querySelectorAll('[name="list_video[]"]'))
                .map(input => input.value);
            document.getElementById('list_video_json').value = JSON.stringify(videos);
        }

        // Fungsi untuk memperbarui total video
        function updateTotalVideo() {
            const totalVideo = document.querySelectorAll('[name="list_video[]"]').length;
            document.getElementById('total_video').value = totalVideo; // Update total video
            calculateTotalSalary(); // Recalculate total salary
        }

        // Fungsi untuk menambah video baru
        document.getElementById('add_video_btn').addEventListener('click', function() {
            const container = document.getElementById('list_video_container');

            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group', 'mb-2');

            const input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control');
            input.name = 'list_video[]';
            input.placeholder = 'Nama Video';

            const button = document.createElement('button');
            button.type = 'button';
            button.classList.add('btn', 'btn-outline-danger');
            button.innerHTML = '<i class="fas fa-times"></i>';
            button.onclick = function() {
                removeVideo(inputGroup);
            };

            input.oninput = function() {
                updateListVideoJson();
                updateTotalVideo();
            };

            inputGroup.appendChild(input);
            inputGroup.appendChild(button);
            container.appendChild(inputGroup);

            updateListVideoJson();
            updateTotalVideo();
        });
    </script>
@endsection
