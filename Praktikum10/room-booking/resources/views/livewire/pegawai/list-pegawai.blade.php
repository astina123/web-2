<div>
    <input wire:model.live="search" placeholder="Cari pegawai...">
    <table>
        @foreach ($pegawais as $pegawai)
        <tr>
            <td>{{ $pegawai->nip }}</td>
            <td>{{ $pegawai->nama }}</td>
            <td>{{ $pegawai->unitKerja->nama }}</td>
            <!-- Tombol aksi -->
        </tr>
        @endforeach
    </table>
</div>
