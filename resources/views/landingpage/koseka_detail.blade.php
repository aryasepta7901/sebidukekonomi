@extends('landingpage.layouts.app')

@section('content')
    <style>
        #map {
            height: 550px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info.legend {
            line-height: 18px;
            color: #555;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            /* Jarak antar legenda */
        }

        .info.legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }

        .legend-line {
            height: 4px !important;
            margin-top: 7px !important;
        }

        .legend-sls {
            background: transparent !important;
            border: 2px dashed #27ae60 !important;
            height: 0px !important;
            margin-top: 10px !important;
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
    </style>
    <br>
    <br>
    <br>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2>Detail Wilayah Tugas KOSEKA</h2>
                <h5 class="text-muted" id="active-location">Seluruh Wilayah Kecamatan</h5>
            </div>
            <div class="d-flex gap-2">
                <select id="filter-desa" class="form-select" style="width: 250px;">
                    <option value="all">-- Semua Kelurahan --</option>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Kecamatan</h6>
                    <h4 class="fw-bold mb-0 text-primary" id="stat-kec">-</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Kelurahan</h6>
                    <h4 class="fw-bold mb-0 text-info" id="stat-nama-desa">Semua</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3"
                    style="background: #fff5eb; border: 1px solid #fd7e14 !important;">
                    <h6 class="text-muted mb-1">Usaha Aktif (SE)</h6>
                    <h4 class="fw-bold mb-0" style="color: #fd7e14;" id="stat-usaha">0</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Total SLS</h6>
                    <h4 class="fw-bold mb-0 text-warning" id="stat-sls">0</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Sub-SLS</h6>
                    <h4 class="fw-bold mb-0 text-danger" id="stat-subsls">0</h4>
                </div>
            </div>
        </div>

        <div id="map"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.11.0/proj4.js"></script>

    <script>
        const dataKec = @json($targetKec);
        const dataDesa = @json($targetDesa);
        const dataSubSLS = @json($targetSubSLS);
        const totalKecamatan = {{ $totalKecamatan }};
        const rekapKelurahan = @json($rekapKelurahan);

        const sourceCRS = 'EPSG:3857';
        const destCRS = 'EPSG:4326';

        var map = L.map('map').setView([-3.29, 102.85], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var layerGroupKec = L.layerGroup().addTo(map);
        var layerGroupDesa = L.layerGroup().addTo(map);
        var layerGroupSLS = L.layerGroup().addTo(map);



        function refreshMap(kddesaFilter = 'all') {
            layerGroupKec.clearLayers();
            layerGroupDesa.clearLayers();
            layerGroupSLS.clearLayers();

            const styleKec = {
                "color": "#d35400",
                "weight": 6,
                "fillOpacity": 0,
                "interactive": false // Agar klik tembus ke bawah (SLS)
            };

            const styleDesa = function(feature) {
                let kode = String(feature.properties.kddesa || feature.properties.KDDESA).padStart(3, '0');
                let jumlah = rekapKelurahan[kode] || 0;
                return {
                    "color": "#2980b9",
                    "weight": 2.5,
                    "fillColor": getColorHeatmap(jumlah),
                    "fillOpacity": 0.6,
                    "interactive": false // PENTING: Agar klik "tembus" ke layer SLS di atasnya
                };
            };

            const styleSLS = {
                "color": "#27ae60",
                "weight": 2, // Pertebal sedikit agar mudah diklik
                "dashArray": "5, 5",
                "fillColor": "transparent", // Gunakan transparan daripada fillOpacity: 0
                "fillOpacity": 0.1, // Beri sedikit opacity agar area di dalam SLS bisa diklik
                "interactive": true
            };

            // Filter Data (Gunakan slice(-3) untuk memastikan kecocokan kode)
            const filteredDesa = (kddesaFilter === 'all') ? dataDesa : {
                ...dataDesa,
                features: dataDesa.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA).slice(-3) == String(kddesaFilter).slice(-3)
                )
            };

            const filteredSLS = (kddesaFilter === 'all') ? dataSubSLS : {
                ...dataSubSLS,
                features: dataSubSLS.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA).slice(-3) == String(kddesaFilter).slice(-3)
                )
            };

            // URUTAN MENGGAMBAR:
            // 1. Gambar Desa paling bawah (sebagai background heatmap)
            drawGeoJSON(filteredDesa, styleDesa, 'desa', layerGroupDesa);

            // 2. Gambar SLS di atasnya (agar Popup berada di posisi paling depan/atas)
            drawGeoJSON(filteredSLS, styleSLS, 'sls', layerGroupSLS);

            // 3. Gambar Kecamatan paling atas sebagai bingkai
            drawGeoJSON(dataKec, styleKec, 'kec', layerGroupKec);

            // Auto Zoom
            if (layerGroupDesa.getLayers().length > 0) {
                const bounds = L.featureGroup(layerGroupDesa.getLayers()).getBounds();
                map.flyToBounds(bounds, {
                    padding: [20, 20]
                });
            }

            updateDashboard(kddesaFilter);
        }

        // Fungsi untuk menentukan warna heatmap berdasarkan jumlah usaha
        function getColorHeatmap(d) {
            return d > 1000 ? '#800026' :
                d > 500 ? '#BD0026' :
                d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                d > 0 ? '#FEB24C' :
                '#FFEDA0'; // Warna dasar jika data 0
        }

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

                    // 1. Ambil data & normalisasi
                    let nmkec = p.nmkec || p.NMKEC || "";
                    let nmdesa = p.nmdesa || p.NMDESA || "";
                    let nmsls = p.nmsls || p.NMSLS || "";

                    let idsubsls = p.idsubsls || p.IDSUBSLS || "";
                    let kdsubsls = p.kdsubsls || p.KDSUBSLS || "";

                    if (type === 'desa') {
                        layer.bindTooltip(nmdesa, {
                            permanent: true,
                            direction: 'center',
                            className: 'label-kelurahan'
                        });
                    }

                    let popupContent = "";

                    if (type === 'sls') {
                        const center = layer.getBounds().getCenter();
                        // Format URL Google Maps yang lebih kompatibel
                        const googleMapsUrl = `https://www.google.com/maps?q=${center.lat},${center.lng}`;

                        // --- PERBAIKAN URL DRIVE DENGAN QUERY OTOMATIS ---
                        const folderId = "1DvccR24rCDIl9N-oGTkBguJH949eXYbp";
                        const namaFile = idsubsls + "_WSS.jpg";

                        // Menggunakan parameter ?q= untuk memicu pencarian otomatis di folder tersebut
                        const driveSearchUrl =
                            `https://drive.google.com/drive/folders/${folderId}?usp=sharing&q=${idsubsls}_WSS`;

                        popupContent = `
                    <div style="min-width: 220px; padding: 5px;">
                        <h6 style="margin: 0 0 8px 0; color: #27ae60; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                            <i class="fas fa-map-marker-alt"></i> Info Wilayah SLS
                        </h6>
                        <table style="width: 100%; font-size: 11px; border-collapse: collapse; color: #333;">
                            <tr><td style="padding:2px 0; width: 85px;"><b>Kecamatan</b></td><td>: ${nmkec}</td></tr>
                            <tr><td style="padding:2px 0;"><b>Kelurahan</b></td><td>: ${nmdesa}</td></tr>
                            <tr><td style="padding:2px 0;"><b>Nama SLS</b></td><td>: ${nmsls}</td></tr>
                            <tr>
                                <td style="padding:2px 0;"><b>kdsubsls</b></td>
                                <td>: <span style="background-color: #f8f9fa; color: #333; border: 1px solid #ccc; font-weight: bold; padding: 1px 6px; border-radius: 3px;">${kdsubsls}</span></td>
                            </tr>
                        </table>
                        
                        <hr style="margin: 10px 0;">
                        
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <a href="${googleMapsUrl}" target="_blank" 
                               class="btn btn-primary btn-xs" 
                               style="color: white !important; text-decoration: none; text-align: center; padding: 8px; border-radius: 4px; font-size: 11px; background-color: #007bff; border: none; display: block;">
                                <i class="fas fa-route"></i> Get Direction
                            </a>
                            
                            <a href="${driveSearchUrl}" target="_blank" 
                               class="btn btn-success btn-xs" 
                               style="color: white !important; text-decoration: none; text-align: center; padding: 8px; border-radius: 4px; font-size: 11px; background-color: #28a745; border: none; display: block;">
                                <i class="fas fa-print"></i> Cari & Cetak Peta
                            </a>
                        </div>
                        <div style="background: #fff3cd; color: #856404; padding: 8px; border-radius: 4px; font-size: 10px; margin-top: 8px; border: 1px solid #ffeeba; line-height: 1.4;">
                            <strong>Instruksi:</strong><br>
                            Klik tombol hijau. Jika file tidak muncul otomatis, pastikan anda login Google dan file bernama: <b style="user-select: all; color: #000;">${namaFile}</b>
                        </div>
                    </div>
                `;
                    }

                    if (popupContent) {
                        layer.bindPopup(popupContent);
                    }
                }
            }).addTo(group);
        }

        function updateDashboard(kddesa) {
            let filteredSLS = [];
            let labelDesa = "";
            let jumlahUsaha = 0;

            // --- TAMBAHKAN LOGIKA UNTUK NAMA KECAMATAN DI SINI ---
            if (dataKec && dataKec.features && dataKec.features.length > 0) {
                // Mengambil properti dari fitur pertama karena ini sudah di-filter per kecamatan di Controller
                let propKec = dataKec.features[0].properties;
                document.getElementById('stat-kec').innerText = propKec.nmkec || propKec.NMKEC || "Kecamatan";
            }

            if (kddesa === 'all') {
                filteredSLS = dataSubSLS.features || [];
                labelDesa = (dataDesa.features ? dataDesa.features.length : 0) + " Kelurahan";
                document.getElementById('active-location').innerText = "Seluruh Wilayah Kecamatan";

                // Ambil total kecamatan yang dihitung di Controller
                jumlahUsaha = totalKecamatan;
            } else {
                // Filter SLS berdasarkan kddesa (biasanya 3 digit terakhir)
                filteredSLS = dataSubSLS.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesa).slice(-3)
                );

                // Cari nama desa dari GeoJSON desa
                let dObj = dataDesa.features.find(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesa).slice(-3)
                );

                labelDesa = dObj ? (dObj.properties.nmdesa || dObj.properties.NMDESA) : "-";
                document.getElementById('active-location').innerText = "Kelurahan " + labelDesa;

                // Ambil data rekap usaha dari Excel yang dikirim Controller
                let shortKD = String(kddesa).slice(-3);
                jumlahUsaha = rekapKelurahan[shortKD] || 0;
            }

            // Update elemen UI
            document.getElementById('stat-nama-desa').innerText = labelDesa;

            // Update elemen Usaha Aktif (pastikan ID ini ada di HTML Card Anda)
            const elUsaha = document.getElementById('stat-usaha');
            if (elUsaha) {
                elUsaha.innerText = jumlahUsaha.toLocaleString('id-ID');
            }

            let uniqueSLS = new Set(filteredSLS.map(f => f.properties.idsls || f.properties.IDSLS));
            document.getElementById('stat-sls').innerText = uniqueSLS.size;
            document.getElementById('stat-subsls').innerText = filteredSLS.length - uniqueSLS.size;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('filter-desa');
            if (dataDesa.features) {
                dataDesa.features.forEach(f => {
                    let opt = document.createElement('option');
                    opt.value = f.properties.kddesa || f.properties.KDDESA;
                    opt.text = f.properties.nmdesa || f.properties.NMDESA;
                    select.add(opt);
                });
            }
            select.addEventListener('change', function() {
                refreshMap(this.value);
            });
            refreshMap('all');
        });

        var legend = L.control({
            position: 'bottomright'
        });
        legend.onAdd = function() {
            var div = L.DomUtil.create('div', 'info legend');
            var grades = [0, 50, 100, 200, 500, 1000];

            div.innerHTML = '<strong>Legenda & Kepadatan</strong><br>';
            div.innerHTML +=
                '<i style="background: #d35400; height: 3px; width:18px; display:inline-block;"></i> Batas Kec<br>';
            // Tambahkan baris ini untuk Batas Kelurahan
            div.innerHTML +=
                '<i style="border: 2px solid #2980b9; height: 10px; width:18px; display:inline-block; background:rgba(41, 128, 185, 0.2)"></i> Batas Kelurahan<br>';
            div.innerHTML +=
                '<i class="legend-sls" style="border: 1.5px dashed #27ae60; width:18px; height:0px; display:inline-block;"></i> Batas SLS/ SUB SLS<br><hr style="margin:5px 0">';

            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColorHeatmap(grades[i] + 1) +
                    '; width:18px; height:18px; float:left; margin-right:8px; opacity:0.7;"></i> ' +
                    grades[i] + (grades[i + 1] ? '–' + grades[i + 1] + '<br>' : '+');
            }
            return div;
        };

        legend.addTo(map);
    </script>
@endsection
