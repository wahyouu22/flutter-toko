<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
        font-size: 12px; /* Ukuran font untuk cetakan */
    }

    table tr td, table th {
        padding: 6px;
        border: 1px solid #ccc;
    }

    table th {
        font-weight: bold;
    }

    @media print {
        table {
            margin: 0 auto;
            width: 90%; /* Sesuaikan lebar cetakan */
        }
    }
</style>

<table>
    <tr>
        <td align="left">
            Perihal : {{ $judul ?? 'Laporan' }} <br>
            Tanggal Awal: {{ $tanggalAwal ?? '-' }} s/d Tanggal Akhir: {{ $tanggalAkhir ?? '-' }}
        </td>
    </tr>
</table>

<p></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($cetak as $row)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $row->email }} </td>
                <td> {{ $row->nama }} </td>  
                <td> 
                    @if ($row->role == 1) 
                        Super Admin 
                    @elseif($row->role == 0) 
                        Admin 
                    @else 
                        Tidak Diketahui 
                    @endif 
                </td>
                <td> 
                    @if ($row->status == 1) 
                        Aktif 
                    @elseif($row->status == 0) 
                        NonAktif 
                    @else 
                        Tidak Diketahui 
                    @endif 
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="center">Tidak ada data untuk ditampilkan</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
    window.onload = function() {
        const tbody = document.querySelector('tbody');
        if (tbody && tbody.children.length > 0) {
            printStruk();
        }
    }

    function printStruk() {
        window.print();
    }
</script>
