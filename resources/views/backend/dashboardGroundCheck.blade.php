@extends('backend.layouts.app')

@section('title', 'Dashboard GC')

@section('content')
    {{-- CSS Tambahan khusus Peta --}}
    <style>
        #map {
            height: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .label-kelurahan {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid #2980b9;
            color: #2980b9;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 10px;
        }

        .info.legend {
            padding: 10px;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            font-size: 12px;
        }

        .legend-sls {
            display: inline-block;
            width: 20px;
            height: 0;
            border: 1px dashed #27ae60;
            margin-right: 5px;
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Ground Check</h1>
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
            {{-- Peta Wilayah di Bagian Paling Atas --}}
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-map-marked-alt mr-1"></i> Pemetaan Wilayah Kerja</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-2">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Filter Kecamatan</label>
                                    <select id="filter-kecamatan" class="form-control select2bs4">
                                        <option value="all">-- Semua Kecamatan --</option>
                                        @foreach ($listKecamatan as $kec)
                                            <option value="{{ $kec->kdkec }}">{{ $kec->nmkec }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Filter Kelurahan/Desa</label>
                                    <select id="filter-kelurahan" class="form-control select2bs4" disabled>
                                        <option value="all">-- Semua Kelurahan --</option>
                                    </select>
                                </div>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
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
        var table
        $(document).ready(function() {
            // Hancurkan datatable jika sudah diinisialisasi sebelumnya
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            table = $('#example1').DataTable({
                "responsive": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "dom": "<'row'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                "lengthMenu": [
                    [10, 25, 50, 100, 1000],
                    [10, 25, 50, 100, 1000]
                ],
                "ajax": {
                    "url": "{{ route('DashboardGC.index') }}",
                    "data": function(d) {
                        // Menambahkan parameter tambahan saat request ke server
                        d.filter_kec = $('#filter-kecamatan').val();
                        d.filter_desa = $('#filter-kelurahan').val();
                    }
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
                    },
                    // Buat Peta
                    {
                        "data": "latitude",
                        "visible": false,
                        "defaultContent": ""
                    },
                    {
                        "data": "longitude",
                        "visible": false,
                        "defaultContent": ""
                    },
                    {
                        "data": "foto_usaha_url",
                        "visible": false,
                        "defaultContent": ""
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
                ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    // Ambil data murni dalam bentuk Array
                    var dataTampil = api.rows({
                        page: 'current'
                    }).data().toArray();

                    // Panggil fungsi draw
                    drawMarkers(dataTampil);
                }
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
{{-- Peta --}}
@push('scripts')
    {{-- Tambahkan library Leaflet jika belum ada di layout --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.11.0/proj4.js"></script>

    <script>
        var map;
        var layerGroupMarkers;

        function drawMarkers(data) {
            if (!layerGroupMarkers) return;
            layerGroupMarkers.clearLayers();

            data.forEach(function(item) {
                var lat = parseFloat(item.latitude);
                var lng = parseFloat(item.longitude);

                if (!isNaN(lat) && !isNaN(lng) && lat !== 0) {
                    var marker = L.marker([lat, lng]);

                    // Perbaikan URL Google Maps (Template Literal menggunakan ${})
                    var googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

                    // Logika untuk menampilkan foto atau placeholder jika foto kosong
                    var foto = item.foto_usaha_url ? item.foto_usaha_url :
                        'https://placehold.co/200x150?text=No+Photo';

                    marker.bindPopup(`
                <div style="width:200px">
                    <img src="${foto}" style="width:100%; border-radius:5px; margin-bottom:5px">
                    <b>${item.nama_usaha}</b><br>
                    <small>${item.alamat}</small><br><br>
                    
                    <a href="${googleMapsUrl}" target="_blank" class="btn btn-primary btn-xs btn-block" style="color:white">
                        <i class="fas fa-directions"></i> Petunjuk Arah
                    </a>
                </div>
            `);
                    layerGroupMarkers.addLayer(marker);
                }
            });
        }
        $(document).ready(function() {
            // 1. Inisialisasi Data dari Controller
            const dataKec = @json($targetKec);
            const dataDesa = @json($targetDesa);
            const dataSubSLS = @json($targetSubSLS);

            const sourceCRS = 'EPSG:3857';
            const destCRS = 'EPSG:4326';

            // 2. Inisialisasi Map (SetView default ke wilayah Anda)
            map = L.map('map').setView([-3.29, 102.85], 11);
            // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            // Menjadi ini (Google Satellite/Earth):
            var googleSatelit = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Map data &copy; Google'
            }).addTo(map);

            layerGroupKec = L.layerGroup().addTo(map);
            layerGroupDesa = L.layerGroup().addTo(map);
            layerGroupSLS = L.layerGroup().addTo(map);
            layerGroupMarkers = L.layerGroup().addTo(map); // Layer khusus titik usaha

            // 3. Fungsi Gambar GeoJSON
            function drawGeoJSON(data, style, type, group) {
                if (!data || !data.features || data.features.length === 0) return null;

                return L.geoJSON(data, {
                    style: style,
                    coordsToLatLng: function(coords) {
                        var pt = proj4(sourceCRS, destCRS, [coords[0], coords[1]]);
                        return L.latLng(pt[1], pt[0]);
                    },
                    onEachFeature: function(feature, layer) {
                        let p = feature.properties;
                        let nmkec = p.nmkec || p.NMKEC || "Kecamatan";
                        let nmdesa = p.nmdesa || p.NMDESA || "Kelurahan";
                        let nmsls = p.nmsls || p.NMSLS || "";
                        let idsubsls = p.idsubsls || p.IDSUBSLS || "";
                        let kdsubsls = p.kdsubsls || p.KDSUBSLS || "";


                        // --- PERUBAHAN DISINI ---
                        // Label hanya muncul untuk layer Kecamatan (hanya satu nama per kecamatan)
                        if (type === 'kec') {
                            layer.bindTooltip("KEC. " + nmkec, {
                                permanent: true,
                                direction: 'center',
                                className: 'label-kelurahan', // Tetap pakai class CSS Anda agar style konsisten
                                sticky: false
                            });
                        }

                        // Popup tetap informatif menunjukkan lokasi spesifik saat diklik
                        let popupContent = `
                <div style="text-align: center;">
                    <strong style="color: #d35400;">Kecamatan ${nmkec}</strong><br>
                    <span style="color: #2980b9;">Kelurahan ${nmdesa}</span>
                </div>`;

                        if (type === 'sls' && nmsls !== "") {
                            popupContent += `<hr style="margin:5px 0;"><b>SLS:</b> ${nmsls}`;
                            popupContent += `<hr style="margin:5px 0;"><b>SUB SLS:</b> ${kdsubsls}`;
                        }

                        layer.bindPopup(popupContent);
                    }
                }).addTo(group);
            }
            // 4. Gambar Seluruh Wilayah Langsung
            const styleKec = {
                "color": "#d35400",
                "weight": 5,
                "fillOpacity": 0
            };
            const styleDesa = {
                "color": "#2980b9",
                "weight": 2,
                "fillColor": "#3498db",
                "fillOpacity": 0.1
            };
            const styleSLS = {
                "color": "#27ae60",
                "weight": 1,
                "dashArray": "5, 5",
                "fillOpacity": 0.2
            };

            let lKec = drawGeoJSON(dataKec, styleKec, 'kec', layerGroupKec);
            drawGeoJSON(dataDesa, styleDesa, 'desa', layerGroupDesa);
            drawGeoJSON(dataSubSLS, styleSLS, 'sls', layerGroupSLS);

            // Otomatis Zoom ke seluruh wilayah kecamatan yang dimuat
            if (lKec) {
                map.fitBounds(lKec.getBounds());
            }

            function refreshMap(kecVal, desaVal) {
                // Bersihkan layer lama
                layerGroupKec.clearLayers();
                layerGroupDesa.clearLayers();
                layerGroupSLS.clearLayers();

                // 1. Logika Filter Data
                let filteredKec = JSON.parse(JSON.stringify(dataKec));
                let filteredDesa = JSON.parse(JSON.stringify(dataDesa));
                let filteredSLS = JSON.parse(JSON.stringify(dataSubSLS));

                // Jika tidak memilih 'all', lakukan filter array
                if (kecVal !== 'all') {
                    filteredKec.features = dataKec.features.filter(f => (f.properties.kdkec || f.properties
                        .KDKEC) == kecVal);
                    filteredDesa.features = dataDesa.features.filter(f => (f.properties.kdkec || f.properties
                        .KDKEC) == kecVal);
                    filteredSLS.features = dataSubSLS.features.filter(f => (f.properties.kdkec || f.properties
                        .KDKEC) == kecVal);
                }

                if (desaVal !== 'all' && desaVal !== undefined) {
                    filteredDesa.features = filteredDesa.features.filter(f => (f.properties.kddesa || f.properties
                        .KDDESA) == desaVal);
                    filteredSLS.features = filteredSLS.features.filter(f => (f.properties.kddesa || f.properties
                        .KDDESA) == desaVal);
                }

                // 2. Gambar Ulang ke Peta
                let lKec = drawGeoJSON(filteredKec, styleKec, 'kec', layerGroupKec);
                let lDesa = drawGeoJSON(filteredDesa, styleDesa, 'desa', layerGroupDesa);
                drawGeoJSON(filteredSLS, styleSLS, 'sls', layerGroupSLS);

                // 3. LOGIKA ZOOM (KEMBALI KE SEMULA)
                if (kecVal === 'all') {
                    // Jika pilih semua, zoom out ke seluruh wilayah kecamatan yang ada
                    if (lKec) map.fitBounds(lKec.getBounds());
                } else {
                    // Jika filter aktif, zoom ke wilayah yang terpilih saja
                    if (desaVal !== 'all' && lDesa) {
                        map.fitBounds(lDesa.getBounds());
                    } else if (lKec) {
                        map.fitBounds(lKec.getBounds());
                    }
                }
            }



            // Listener Dropdown Kecamatan
            $('#filter-kecamatan').on('change', function() {
                let kecId = $(this).val();
                let kelSelect = $('#filter-kelurahan');

                // Reset dropdown kelurahan
                kelSelect.empty().append('<option value="all">-- Semua Kelurahan --</option>');

                if (kecId === 'all') {
                    kelSelect.prop('disabled', true);
                    refreshMap('all', 'all'); // Kembali ke tampilan awal
                } else {
                    kelSelect.prop('disabled', false);
                    // Isi kelurahan berdasarkan kecamatan terpilih
                    let listDesa = dataDesa.features.filter(f => (f.properties.kdkec || f.properties
                        .KDKEC) == kecId);
                    listDesa.forEach(f => {
                        let code = f.properties.kddesa || f.properties.KDDESA;
                        let name = f.properties.nmdesa || f.properties.NMDESA;
                        kelSelect.append(`<option value="${code}">${name}</option>`);
                    });

                    refreshMap(kecId, 'all');
                }
                // Panggil reload setelah dropdown berubah
                if (table) table.ajax.reload();
            });

            // Listener Dropdown Kelurahan
            $('#filter-kelurahan').on('change', function() {
                refreshMap($('#filter-kecamatan').val(), $(this).val());
                // Panggil reload setelah dropdown berubah
                if (table) table.ajax.reload();
            });
        });
    </script>
@endpush
