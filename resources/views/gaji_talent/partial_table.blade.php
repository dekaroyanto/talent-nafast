@forelse ($gajiTalentList as $gaji)
    <tr>
        <td>{{ $gaji->talent->nama_talent }}</td>
        <td>{{ \Carbon\Carbon::parse($gaji->periode_gaji_awal)->translatedFormat('d F Y') }} -
            {{ \Carbon\Carbon::parse($gaji->periode_gaji_akhir)->translatedFormat('d F Y') }}</td>
        <td>Rp. {{ number_format($gaji->fee_live_perjam, 2) }}</td>
        <td>Rp. {{ number_format($gaji->fee_take_video_perjam, 2) }}</td>
        <td>Rp. {{ number_format($gaji->total_lama_sesi_live, 2) }}</td>
        <td>Rp. {{ number_format($gaji->total_lama_sesi_take_video, 2) }}</td>
        <td>Rp. {{ number_format($gaji->fee_live_didapat, 2) }}</td>
        <td>Rp. {{ number_format($gaji->fee_take_video_didapat, 2) }}</td>
        <td>Rp. {{ number_format($gaji->jumlah_total_omset, 2) }}</td>
        <td>Rp. {{ number_format($gaji->rate_omset_perjam, 2) }}</td>
        <td>Rp. {{ number_format($gaji->bonus, 2) }}</td>
        <td>Rp. {{ number_format($gaji->total_gaji, 2) }}</td>
        <td class="d-flex gap-2 justify-content-center">
            <a href="{{ route('gaji-talent.edit', $gaji->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form action="{{ route('gaji-talent.destroy', $gaji->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="13">Tidak ada data</td>
    </tr>
@endforelse
