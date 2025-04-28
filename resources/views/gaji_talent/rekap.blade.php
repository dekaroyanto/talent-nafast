@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h2>Rekap Talent</h2>
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('gaji-talent.store') }}" method="POST">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="talent_id" class="form-label">Talent</label>
                                <select name="talent_id" id="talent_id" class="form-select">
                                    <option value="">Select Talent</option>
                                    @foreach ($talents as $talent)
                                        <option value="{{ $talent->id }}">{{ $talent->nama_talent }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_gaji_awal" class="form-label">Periode Awal</label>
                                <input type="date" class="form-control" name="periode_gaji_awal" id="periode_gaji_awal"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_gaji_akhir" class="form-label">Periode Akhir</label>
                                <input type="date" class="form-control" name="periode_gaji_akhir" id="periode_gaji_akhir"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control"
                                    readonly>
                                <label for="fee_live_perjam">Fee Live per Jam</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam"
                                    class="form-control" readonly>
                                <label for="fee_take_video_perjam">Fee Take Video per Jam</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="fee_pervideo" id="fee_pervideo" class="form-control" readonly>
                                <label for="fee_pervideo">Fee per Video</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="fee_live_didapat" id="fee_live_didapat" class="form-control"
                                    readonly>
                                <label for="fee_live_didapat">Fee Live Didapat</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="fee_take_video_didapat" id="fee_take_video_didapat"
                                    class="form-control" readonly>
                                <label for="fee_take_video_didapat">Fee Take Video Didapat</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="fee_pervideo_didapat" id="fee_pervideo_didapat"
                                    class="form-control" readonly>
                                <label for="fee_pervideo_didapat">Fee per Video Didapat</label>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live"
                                    class="form-control" readonly>
                                <label for="total_lama_sesi_live">Total Lama Sesi Live (jam)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                                    class="form-control" readonly>
                                <label for="total_lama_sesi_take_video">Total Lama Sesi Take Video (jam)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="total_video" id="total_video" class="form-control"
                                    min="0" readonly>
                                <label for="total_video">Total Video</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="jumlah_total_omset" id="jumlah_total_omset" class="form-control"
                                    readonly>
                                <label for="jumlah_total_omset">Jumlah Total Omset</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="rate_omset_perjam" id="rate_omset_perjam"
                                    class="form-control" readonly>
                                <label for="rate_omset_perjam">Rate Omset per Jam</label>
                            </div>

                            <div class="form-floating mb-3" style="display: none">
                                <input type="number" name="bonus" id="bonus" class="form-control" step="0.01"
                                    value="0">
                                <label for="bonus">Bonus</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3" style="display: none">
                        <input type="number" name="total_gaji" id="total_gaji" class="form-control fw-bold" readonly>
                        <label for="total_gaji">Total Gaji</label>
                    </div>

                    <div class="mb-3">
                        <label for="list_video" class="form-label">List Video</label>
                        <div id="list_video_container" class="mb-2"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add_video_btn"
                            style="display: none">
                            <i class="fas fa-plus"></i> Add Video
                        </button>
                    </div>
                    <input type="hidden" name="list_video_json" id="list_video_json">

                    <div class="d-flex justify-content-end mt-4" style="display: none">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Your existing JavaScript remains the same
        const calculateTotalSalary = () => {
            const feeLiveDidapat = parseFloat(document.getElementById('fee_live_didapat').value) || 0;
            const feeTakeVideoDidapat = parseFloat(document.getElementById('fee_take_video_didapat').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;

            const feePerVideo = parseFloat(document.getElementById('fee_pervideo').value) || 0;
            const totalVideo = parseFloat(document.getElementById('total_video').value) || 0;
            const feePervideoDidapat = feePerVideo * totalVideo;
            document.getElementById('fee_pervideo_didapat').value = feePervideoDidapat.toFixed(2);

            const totalGaji = feeLiveDidapat + feeTakeVideoDidapat + feePervideoDidapat + bonus;
            document.getElementById('total_gaji').value = totalGaji.toFixed(2);
        };

        document.getElementById('periode_gaji_akhir').addEventListener('change', function() {
            const awal = document.getElementById('periode_gaji_awal').value;
            const akhir = this.value;

            if (akhir && awal && new Date(akhir) < new Date(awal)) {
                alert('Periode akhir tidak boleh lebih awal dari periode awal');
                this.value = '';
            }
        });

        document.getElementById('total_video').addEventListener('input', calculateTotalSalary);

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
                        document.getElementById('fee_pervideo').value = data.fee_pervideo || 0;
                        document.getElementById('fee_pervideo_didapat').value = data.fee_pervideo_didapat || 0;
                        document.getElementById('total_video').value = data.total_video || 0;

                        if (data.list_video && Array.isArray(data.list_video)) {
                            const container = document.getElementById('list_video_container');
                            container.innerHTML = '';

                            data.list_video.forEach(videoUrl => {
                                const div = document.createElement('div');
                                div.classList.add('mb-2', 'p-2', 'border', 'rounded', 'bg-light');

                                const link = document.createElement('a');
                                link.href = videoUrl;
                                link.target = '_blank';
                                link.textContent = videoUrl;
                                link.classList.add('d-block', 'text-primary', 'text-decoration-none');

                                // Hover effect
                                link.addEventListener('mouseover', () => {
                                    link.style.textDecoration = 'underline';
                                });
                                link.addEventListener('mouseout', () => {
                                    link.style.textDecoration = 'none';
                                });

                                div.appendChild(link);
                                container.appendChild(div);
                            });

                            document.getElementById('list_video_json').value = JSON.stringify(data.list_video);
                            document.getElementById('total_video').value = data.list_video.length;
                        }

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

        document.getElementById('add_video_btn').addEventListener('click', function() {
            const container = document.getElementById('list_video_container');

            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group', 'mb-2');

            const input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control');
            input.name = 'list_video[]';
            input.placeholder = 'Nama Video';

            input.oninput = updateListVideoJson;

            inputGroup.appendChild(input);
            // inputGroup.appendChild(button);
            container.appendChild(inputGroup);

            updateListVideoJson();
        });

        function updateListVideoJson() {
            const inputs = document.querySelectorAll('#list_video_container input');
            const values = Array.from(inputs).map(input => input.value).filter(val => val.trim() !== '');
            document.getElementById('list_video_json').value = JSON.stringify(values);
            document.getElementById('total_video').value = values.length;
            calculateTotalSalary();
        }
    </script>
@endsection
