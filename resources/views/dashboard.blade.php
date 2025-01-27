@extends('layouts.navbar')

@section('content')
    <div class="col-xl-4 col-md-6">
        <div class="card bg-green-500 dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-users"></i>
                        </div>
                    </div>

                </div>
                <span class="text-white d-block f-34 f-w-500 my-2">
                    69
                </span>
                <p class="mb-0 opacity-100">Total Talent</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="text-white ti ti-credit-card"></i>
                        </div>
                    </div>

                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                    <div class="tab-pane show active" id="chart-tab-home" role="tabpanel"
                        aria-labelledby="chart-tab-home-tab" tabindex="0">
                        <div class="row">
                            <div class="col-8">
                                <span class="text-white d-block f-34 f-w-500 my-2">
                                    Rp.
                                </span>
                                <p class="mb-0 opacity-100">Total Omset Bulan Januari</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2>Sesi Talent Terbaru</h2>
    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-striped">
                        <thead>
                            <tr>
                                <td>Nama Talent</td>
                                <td>Jenis Sesi</td>
                                <td>Waktu Mulai</td>
                                <td>Waktu Selesai</td>
                                <td>Lama Sesi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Take Video</td>
                                <td>2023-01-01 10:00:00</td>
                                <td>2023-01-01 11:00:00</td>
                                <td>1 Jam</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
