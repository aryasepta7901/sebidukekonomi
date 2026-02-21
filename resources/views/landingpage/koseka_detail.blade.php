@extends('landingpage.layouts.app')

@section('content')
    <style>
        #map {
            height: 550px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info.legend {
            padding: 10px 15px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            line-height: 24px;
            color: #333;
        }

        .info.legend i {
            width: 20px;
            height: 14px;
            float: left;
            margin-right: 10px;
            margin-top: 5px;
            opacity: 0.8;
            border: 1px solid #999;
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
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Kecamatan</h6>
                    <h4 class="fw-bold mb-0 text-primary" id="stat-kec">-</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Kelurahan Terpilih</h6>
                    <h4 class="fw-bold mb-0 text-info" id="stat-nama-desa">Semua</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Total SLS</h6>
                    <h4 class="fw-bold mb-0 text-warning" id="stat-sls">0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h6 class="text-muted mb-1">Total Sub-SLS</h6>
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

        const sourceCRS = 'EPSG:3857';
        const destCRS = 'EPSG:4326';

        var map = L.map('map').setView([-3.29, 102.85], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var layerGroupKec = L.layerGroup().addTo(map);
        var layerGroupDesa = L.layerGroup().addTo(map);
        var layerGroupSLS = L.layerGroup().addTo(map);

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

        function refreshMap(kddesaFilter = 'all') {
            layerGroupKec.clearLayers();
            layerGroupDesa.clearLayers();
            layerGroupSLS.clearLayers();

            const styleKec = {
                "color": "#d35400",
                "weight": 6,
                "fillOpacity": 0
            };
            const styleDesa = {
                "color": "#2980b9",
                "weight": 3,
                "fillColor": "#3498db",
                "fillOpacity": 0.1
            };
            const styleSLS = {
                "color": "#27ae60",
                "weight": 1.5,
                "dashArray": "5, 5",
                "fillColor": "#2ecc71",
                "fillOpacity": 0.3
            };

            let filteredDesa = JSON.parse(JSON.stringify(dataDesa));
            let filteredSLS = JSON.parse(JSON.stringify(dataSubSLS));

            if (kddesaFilter !== 'all') {
                filteredDesa.features = dataDesa.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesaFilter)
                );
                filteredSLS.features = dataSubSLS.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesaFilter)
                );
            }

            // Gambar semua layer
            let lKec = drawGeoJSON(dataKec, styleKec, 'kec', layerGroupKec);
            let lDesa = drawGeoJSON(filteredDesa, styleDesa, 'desa', layerGroupDesa);
            drawGeoJSON(filteredSLS, styleSLS, 'sls', layerGroupSLS);

            // LOGIKA ZOOM OUT / ZOOM IN
            setTimeout(() => {
                let targetBounds;

                if (kddesaFilter === 'all') {
                    // Jika pilih "Semua", ambil batas dari layer Kecamatan agar Zoom Out
                    if (lKec) targetBounds = lKec.getBounds();
                } else {
                    // Jika pilih Kelurahan spesifik, ambil batas dari layer Desa tersebut
                    if (lDesa) targetBounds = lDesa.getBounds();
                }

                if (targetBounds && targetBounds.isValid()) {
                    // flyToBounds memberikan efek animasi transisi yang lebih bagus
                    map.flyToBounds(targetBounds, {
                        padding: [40, 40],
                        duration: 1.5 // Durasi animasi dalam detik
                    });
                }
            }, 300);

            updateDashboard(kddesaFilter);
        }

        function updateDashboard(kddesa) {
            if (dataKec.features && dataKec.features.length > 0) {
                let pKec = dataKec.features[0].properties;
                document.getElementById('stat-kec').innerText = pKec.nmkec || pKec.NMKEC || "-";
            }

            let filteredSLS = [];
            let labelDesa = "";

            if (kddesa === 'all') {
                filteredSLS = dataSubSLS.features || [];
                labelDesa = (dataDesa.features ? dataDesa.features.length : 0) + " Kelurahan";
                document.getElementById('active-location').innerText = "Seluruh Wilayah Kecamatan";
            } else {
                filteredSLS = dataSubSLS.features.filter(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesa)
                );
                let dObj = dataDesa.features.find(f =>
                    String(f.properties.kddesa || f.properties.KDDESA) === String(kddesa)
                );
                labelDesa = dObj ? (dObj.properties.nmdesa || dObj.properties.NMDESA) : "-";
                document.getElementById('active-location').innerText = "Kelurahan " + labelDesa;
            }

            document.getElementById('stat-nama-desa').innerText = labelDesa;
            let uniqueSLS = new Set(filteredSLS.map(f => f.properties.idsls || f.properties.IDSLS));
            document.getElementById('stat-sls').innerText = uniqueSLS.size;
            document.getElementById('stat-subsls').innerText = filteredSLS.length;
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
            div.innerHTML =
                '<strong>Legenda</strong><br><i style="background: #d35400; height: 3px;"></i> Batas Kec<br><i style="background: rgba(52, 152, 219, 0.2); border: 2px solid #2980b9;"></i> Batas Kelurahan<br><i class="legend-sls"></i> Batas SLS';
            return div;
        };
        legend.addTo(map);
    </script>
@endsection
