@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h3 class="mb-2">Daftar Talent</h3>

        <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Talent
        </button>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <td>Nama Talent</td>
                                <td>Fee Live Perjam</td>
                                <td>Fee Take Video Perjam</td>
                                <td>Fee Pervideo</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($talents as $talent)
                                <tr>
                                    <td>{{ $talent->nama_talent }}</td>
                                    <td>{{ 'Rp ' . number_format($talent->fee_live_perjam, 0, ',', '.') }}</td>
                                    <td>{{ 'Rp ' . number_format($talent->fee_take_video_perjam, 0, ',', '.') }}</td>
                                    <td>{{ 'Rp ' . number_format($talent->fee_pervideo, 0, ',', '.') }}</td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $talent->id }}">Edit</button>

                                        <form action="{{ route('talent.destroy', $talent) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus talent ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Talent -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Talent</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('talent.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control @error('nama_talent') is-invalid @enderror"
                                name="nama_talent" id="nama_talent" value="{{ old('nama_talent') }}">
                            <label for="nama_talent">Nama Talent</label>
                            @error('nama_talent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" class="form-control @error('fee_live_perjam') is-invalid @enderror"
                                name="fee_live_perjam" id="fee_live_perjam" value="{{ old('fee_live_perjam') }}">
                            <label for="fee_live_perjam">Fee Live Perjam</label>
                            @error('fee_live_perjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-2">
                            <input type="number" class="form-control @error('fee_take_video_perjam') is-invalid @enderror"
                                name="fee_take_video_perjam" id="fee_take_video_perjam"
                                value="{{ old('fee_take_video_perjam') }}">
                            <label for="fee_take_video_perjam">Fee Take Video Perjam</label>
                            @error('fee_take_video_perjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}

    <!-- Modal Edit Talent -->
    @foreach ($talents as $talent)
        <div class="modal fade" id="editModal{{ $talent->id }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Talent</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('talent.update', $talent->id) }}') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control @error('nama_talent') is-invalid @enderror"
                                    name="nama_talent" id="nama_talent"
                                    value="{{ old('nama_talent', $talent->nama_talent) }}">
                                <label for="nama_talent">Nama Talent</label>
                                @error('nama_talent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" class="form-control @error('fee_live_perjam') is-invalid @enderror"
                                    name="fee_live_perjam" id="fee_live_perjam"
                                    value="{{ old('fee_live_perjam', $talent->fee_live_perjam) }}">
                                <label for="fee_live_perjam">Fee Live Perjam</label>
                                @error('fee_live_perjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number"
                                    class="form-control @error('fee_take_video_perjam') is-invalid @enderror"
                                    name="fee_take_video_perjam" id="fee_take_video_perjam"
                                    value="{{ old('fee_take_video_perjam', $talent->fee_take_video_perjam) }}">
                                <label for="fee_take_video_perjam">Fee Take Video Perjam</label>
                                @error('fee_take_video_perjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" class="form-control @error('fee_pervideo') is-invalid @enderror"
                                    name="fee_pervideo" id="fee_pervideo"
                                    value="{{ old('fee_pervideo', $talent->fee_pervideo) }}">
                                <label for="fee_pervideo">Fee Pervideo</label>
                                @error('fee_pervideo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
