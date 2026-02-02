@extends('backend.layouts.app')

@section('title', 'Dashboard GC')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fixed Footer Layout</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard GC</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12"> {{-- Gunakan lebar penuh agar cukup untuk 2 kolom --}}
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i> Top 10 Progress Petugas </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Membagi data menjadi 2 bagian (masing-masing maksimal 5 data) --}}
                                @foreach ($topPetugas->take(10)->chunk(5) as $chunk)
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($chunk as $index => $tp)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                                    <div>
                                                        {{-- Menghitung nomor urut --}}
                                                        <span
                                                            class="badge badge-light mr-2">{{ $loop->parent->index * 5 + $loop->iteration }}.</span>
                                                        <strong>{{ $tp->nama }}</strong>
                                                    </div>
                                                    <span class="badge badge-success badge-pill">
                                                        {{ $tp->groundchecks_count }} GC
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-sync-alt mr-1"></i> Data diurutkan berdasarkan performa tertinggi
                                </small>
                                <small class="text-muted font-italic">
                                    <i class="far fa-clock mr-1"></i> Terakhir diperbarui:
                                    {{ now()->format('d M Y | H:i') }} WIB
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Hasil Ground Check Lapangan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>IDSBR</th>
                                    <th>Nama Usaha</th>
                                    <th>Alamat</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Petugas</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="modalGambar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pratinjau Foto</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body text-center">
                    <h4 id="namaUsahaFoto" class="mb-3" style="font-weight: bold; color: #333;"></h4>

                    <img id="imgShow" src="" class="img-fluid img-thumbnail" style="max-height: 400px;"
                        onerror="this.src='https://placehold.co/300x200?text=Foto+Tidak+Ditemukan'">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMap" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 id="namaUsahaMap" class="text-center mb-3" style="font-weight: bold; color: #333;"></h4>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="mapFrame" class="embed-responsive-item" src="" frameborder="0"
                            style="border:0;" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Hancurkan datatable jika sudah diinisialisasi sebelumnya
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            var table = $('#example1').DataTable({
                "responsive": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "dom": "<'row'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "ajax": {
                    "url": "{{ route('DashboardGC.index') }}",
                    "type": "GET"
                },
                "columns": [{
                        "data": null,
                        "render": (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        "data": "idsbr"
                    },
                    {
                        "data": "nama_usaha"
                    },
                    {
                        "data": "alamat"
                    },
                    {
                        "data": "kdkec"
                    },
                    {
                        "data": "kddesa"
                    },
                    {
                        "data": "nama_petugas"
                    },
                    {
                        "data": "catatan"
                    },
                    {
                        "data": "aksi_html",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "buttons": [{
                        text: '<i class="fas fa-file-excel"></i> Export Semua XLSX',
                        className: 'btn btn-success btn-sm',
                        action: function(e, dt, node, config) {
                            var btn = $(node);

                            // UI Loading
                            btn.html('<i class="fas fa-spinner fa-spin"></i> Mengambil  Data...')
                                .prop('disabled', true);

                            $.ajax({
                                url: "{{ route('DashboardGC.exportData') }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    // Mengubah object ke array jika perlu
                                    var jsonData = Array.isArray(response) ? response :
                                        Object.values(response);

                                    if (jsonData.length === 0) {
                                        alert(
                                            "Gagal: Tidak ada data dengan petugas_id yang ditemukan di database."
                                        );
                                    } else {
                                        // Membuat file Excel
                                        var ws = XLSX.utils.json_to_sheet(jsonData);
                                        var wb = XLSX.utils.book_new();
                                        XLSX.utils.book_append_sheet(wb, ws,
                                            "Ground Check");

                                        // Download file
                                        XLSX.writeFile(wb,
                                            "Data_GroundCheck_Export.xlsx");
                                    }

                                    // Reset Tombol
                                    btn.html(
                                        '<i class="fas fa-file-excel"></i> Export Semua XLSX'
                                    ).prop('disabled', false);
                                },
                                // Ganti bagian error: function(xhr) di script Anda dengan ini:
                                error: function(xhr) {
                                    // Ini akan menampilkan pesan error asli dari Laravel (misal: query error)
                                    var errorMsg = "Terjadi kesalahan server.";
                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                        errorMsg = xhr.responseJSON.error;
                                    } else {
                                        errorMsg = xhr
                                            .statusText; // Misal: "Internal Server Error"
                                    }

                                    console.error("Detail Error:", xhr.responseText);
                                    alert("Error: " + errorMsg);
                                    btn.html(
                                        '<i class="fas fa-file-excel"></i> Export Semua XLSX'
                                    ).prop('disabled', false);
                                }
                            });
                        }
                    },
                    "copy", "csv", "pdf", "print", "colvis"
                ]
            });

            // --- Event Delegation untuk tombol dalam table (Foto & Map) ---
            $('body').on('click', '.btn-gambar', function() {
                var src = $(this).data('foto');
                var title = $(this).data('usaha');

                // Set sumber gambar
                $('#imgShow').attr('src', src);

                // Set judul di header modal
                $('.modal-title').text("Foto: " + title);

                // TAMBAHKAN INI: Set nama usaha di bodi modal
                $('#namaUsahaFoto').text(title);

                $('#modalGambar').modal('show');
            });

            $('body').on('click', '.btn-map', function() {
                var lat = $(this).data('lat');
                var long = $(this).data('long');
                var title = $(this).data('usaha'); // Mengambil nama usaha

                // URL Google Maps Embed yang benar
                var embedUrl = "https://maps.google.com/maps?q=" + lat + "," + long +
                    "&hl=id&z=15&output=embed";

                // 1. Mengisi Judul Modal
                $('.modal-title').text("Lokasi: " + title);

                // 2. Mengisi Nama Usaha di dalam ID khusus (opsional, jika ingin di atas peta langsung)
                $('#namaUsahaMap').text(title);

                // 3. Set URL Iframe
                $('#mapFrame').attr('src', embedUrl);

                // 4. Tampilkan Modal
                $('#modalMap').modal('show');
            });
        });
    </script>
@endpush
