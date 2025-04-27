@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h1 class="mb-2">Daftar Sesi Talent</h1>
        <!-- Add Sesi Button -->
        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addSesiModal">Tambah Sesi</button>

        <div class="card">
            <div class="card-header">
                <form action="{{ route('sesi-talent.index') }}" method="GET">
                    <div class="row gap-2">
                        <div class="col-md-4">
                            <select name="talent_id" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua Talent</option>
                                @foreach ($talents as $talent)
                                    <option value="{{ $talent->id }}"
                                        {{ request('talent_id') == $talent->id ? 'selected' : '' }}>
                                        {{ $talent->nama_talent }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="jenis_sesi" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua Jenis Sesi</option>
                                <option value="take_video" {{ request('jenis_sesi') == 'take_video' ? 'selected' : '' }}>
                                    Take Video
                                </option>
                                <option value="live" {{ request('jenis_sesi') == 'live' ? 'selected' : '' }}>Live</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
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
                                <th>Jumlah Video</th>
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
                                    <td>
                                        @if (!empty($item->list_video) && is_array($item->list_video))
                                            {{ count(array_filter($item->list_video, fn($v) => !is_null($v) && $v !== '')) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailSesiModal{{ $item->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editSesiModal{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteSesiModal{{ $item->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
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

        <!-- Detail Sesi Modal -->
        @foreach ($sesi as $item)
            <div class="modal fade" id="detailSesiModal{{ $item->id }}" tabindex="-1"
                aria-labelledby="detailSesiModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailSesiModalLabel{{ $item->id }}">Detail Sesi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Talent</label>
                                <input type="text" class="form-control" value="{{ $item->talent->nama_talent }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Sesi</label>
                                <input type="text" class="form-control" value="{{ ucfirst($item->jenis_sesi) }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Waktu Mulai</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($item->tanggal_waktu_mulai)->format('d M Y H:i') }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Waktu Selesai</label>
                                <input type="text" class="form-control"
                                    value="{{ $item->tanggal_waktu_selesai ? \Carbon\Carbon::parse($item->tanggal_waktu_selesai)->format('d M Y H:i') : '-' }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Omset</label>
                                <input type="text" class="form-control"
                                    value="{{ 'Rp ' . number_format($item->total_omset, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">List Video</label>
                                @if (
                                    !empty($item->list_video) &&
                                        is_array($item->list_video) &&
                                        array_filter($item->list_video, fn($v) => !is_null($v) && $v !== ''))
                                    @foreach ($item->list_video as $video)
                                        @if (!is_null($video) && $video !== '')
                                            <a href="{{ $video }}" target="_blank"
                                                class="d-block mb-2 text-decoration-none text-primary border border-1 p-2 rounded"
                                                style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"
                                                title="{{ $video }}">
                                                {{ $video }}
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <input type="text" class="form-control" value="Tidak ada video" readonly>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Add Sesi Modal -->
        <div class="modal fade" id="addSesiModal" tabindex="-1" aria-labelledby="addSesiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSesiModalLabel">Tambah Sesi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('sesi-talent.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="talent_id" class="form-label">Nama Talent</label>
                                <select name="talent_id" id="talent_id" class="form-control" required>
                                    <option value="">Pilih Talent</option>
                                    @foreach ($talents as $talent)
                                        <option value="{{ $talent->id }}">{{ $talent->nama_talent }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_sesi" class="form-label">Jenis Sesi</label>
                                <select name="jenis_sesi" id="jenis_sesi" class="form-control" required>
                                    <option value="">Pilih Jenis Sesi</option>
                                    <option value="take_video">Take Video</option>
                                    <option value="live">Live</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_waktu_mulai" class="form-label">Tanggal Waktu Mulai</label>
                                <input type="datetime-local" name="tanggal_waktu_mulai" id="tanggal_waktu_mulai"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit Sesi Modal -->
        @foreach ($sesi as $item)
            <div class="modal fade" id="editSesiModal{{ $item->id }}" tabindex="-1"
                aria-labelledby="editSesiModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSesiModalLabel{{ $item->id }}">Edit Sesi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('sesi-talent.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="talent_id" class="form-label">Nama Talent</label>
                                    <select name="talent_id" id="talent_id" class="form-control" required>
                                        @foreach ($talents as $talent)
                                            <option value="{{ $talent->id }}"
                                                {{ $talent->id == $item->talent_id ? 'selected' : '' }}>
                                                {{ $talent->nama_talent }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_sesi" class="form-label">Jenis Sesi</label>
                                    <select name="jenis_sesi" id="jenis_sesi" class="form-control" required>
                                        <option value="take_video"
                                            {{ $item->jenis_sesi == 'take_video' ? 'selected' : '' }}>
                                            Take Video</option>
                                        <option value="live" {{ $item->jenis_sesi == 'live' ? 'selected' : '' }}>Live
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_waktu_mulai" class="form-label">Tanggal Waktu Mulai</label>
                                    <input type="datetime-local" name="tanggal_waktu_mulai" id="tanggal_waktu_mulai"
                                        class="form-control"
                                        value="{{ \Carbon\Carbon::parse($item->tanggal_waktu_mulai)->format('Y-m-d\TH:i') }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_waktu_selesai" class="form-label">Tanggal Waktu Selesai</label>
                                    <input type="datetime-local" name="tanggal_waktu_selesai" id="tanggal_waktu_selesai"
                                        class="form-control"
                                        value="{{ $item->tanggal_waktu_selesai ? \Carbon\Carbon::parse($item->tanggal_waktu_selesai)->format('Y-m-d\TH:i') : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="total_omset" class="form-label">Total Omset</label>
                                    <input type="number" step="0.01" name="total_omset" id="total_omset"
                                        class="form-control" value="{{ old('total_omset', $item->total_omset) }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">List Video</label>
                                    <div id="list-video-wrapper-{{ $item->id }}">
                                        @if (!empty($item->list_video))
                                            @foreach ($item->list_video as $index => $video)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="list_video[]" class="form-control"
                                                        value="{{ $video }}" placeholder="Nama video...">
                                                    <button type="button" class="btn btn-danger remove-video">X</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2">
                                                <input type="text" name="list_video[]" class="form-control"
                                                    placeholder="Nama video...">
                                                <button type="button" class="btn btn-danger remove-video">X</button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="addVideoField({{ $item->id }})">+ Tambah Video</button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    function addVideoField(id) {
                        const wrapper = document.getElementById(`list-video-wrapper-${id}`);
                        const div = document.createElement('div');
                        div.classList.add('input-group', 'mb-2');
                        div.innerHTML = `
                            <input type="text" name="list_video[]" class="form-control" placeholder="Nama video...">
                            <button type="button" class="btn btn-danger remove-video">X</button>
                        `;
                        wrapper.appendChild(div);
                    }

                    document.addEventListener('click', function(e) {
                        if (e.target && e.target.classList.contains('remove-video')) {
                            e.target.closest('.input-group').remove();
                        }
                    });
                </script>
            </div>
        @endforeach

        <!-- Delete Sesi Modal -->
        @foreach ($sesi as $item)
            <div class="modal fade" id="deleteSesiModal{{ $item->id }}" tabindex="-1"
                aria-labelledby="deleteSesiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteSesiModalLabel">Hapus Sesi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('sesi-talent.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus sesi ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
