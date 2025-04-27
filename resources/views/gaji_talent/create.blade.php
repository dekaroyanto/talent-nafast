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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-2">
                                <input type="number" name="fee_live_perjam" id="fee_live_perjam" class="form-control"
                                    readonly>
                                <label for="fee_live_perjam">Fee Live per Jam</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="fee_take_video_perjam" id="fee_take_video_perjam"
                                    class="form-control" readonly>
                                <label for="fee_take_video_perjam">Fee Take Video per Jam</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="fee_pervideo" id="fee_pervideo" class="form-control" readonly>
                                <label for="fee_pervideo">Fee per Video</label>
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
                                <input type="number" name="fee_pervideo_didapat" id="fee_pervideo_didapat"
                                    class="form-control" readonly>
                                <label for="fee_pervideo_didapat">Fee per Video Didapat</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-2">
                                <input type="number" name="total_lama_sesi_live" id="total_lama_sesi_live"
                                    class="form-control" readonly>
                                <label for="total_lama_sesi_live">Total Lama Sesi Live</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="total_lama_sesi_take_video" id="total_lama_sesi_take_video"
                                    class="form-control" readonly>
                                <label for="total_lama_sesi_take_video">Total Lama Sesi Take Video</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="total_video" id="total_video" class="form-control"
                                    min="0">
                                <label for="total_video">Total Video</label>
                            </div>

                            <div class="mb-3">
                                <label for="list_video">List Video</label>
                                <div id="list_video_container"></div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="add_video_btn">+ Add
                                    Video</button>
                            </div>
                            <input type="hidden" name="list_video_json" id="list_video_json">

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
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        // Update calculate when total_video is manually changed
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

                        // Tambahkan bagian ini untuk populate list video
                        if (data.list_video && Array.isArray(data.list_video)) {
                            const container = document.getElementById('list_video_container');
                            container.innerHTML = ''; // bersihkan dulu

                            data.list_video.forEach(video => {
                                const inputGroup = document.createElement('div');
                                inputGroup.classList.add('input-group', 'mb-2');

                                const input = document.createElement('input');
                                input.type = 'text';
                                input.classList.add('form-control');
                                input.name = 'list_video[]';
                                input.placeholder = 'Nama Video';
                                input.value = video;

                                const button = document.createElement('button');
                                button.type = 'button';
                                button.classList.add('btn', 'btn-danger');
                                button.innerText = 'Remove';
                                button.onclick = function() {
                                    container.removeChild(inputGroup);
                                    updateListVideoJson();
                                };

                                input.oninput = updateListVideoJson;

                                inputGroup.appendChild(input);
                                inputGroup.appendChild(button);
                                container.appendChild(inputGroup);
                            });

                            updateListVideoJson();
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

        // Dynamic Add List Video
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
            button.classList.add('btn', 'btn-danger');
            button.innerText = 'Remove';
            button.onclick = function() {
                container.removeChild(inputGroup);
                updateListVideoJson();
            };

            input.oninput = updateListVideoJson;

            inputGroup.appendChild(input);
            inputGroup.appendChild(button);
            container.appendChild(inputGroup);

            updateListVideoJson();
        });

        function updateListVideoJson() {
            const inputs = document.querySelectorAll('#list_video_container input');
            const values = Array.from(inputs).map(input => input.value).filter(val => val.trim() !== '');
            document.getElementById('list_video_json').value = JSON.stringify(values);

            // Update total video automatically from list_video
            document.getElementById('total_video').value = values.length;
            calculateTotalSalary();
        }
    </script>
@endsection
