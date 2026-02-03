@extends('frontend.app')

@section('title', 'Halaman Dashboard')
@section('header_title', 'Ground Check')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/GroundCheck">Ground Check</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Usaha</h3>
                </div>

                <form action="{{ route('GroundCheck.update', $GroundCheck->idsbr) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- Nama Usaha --}}
                        <div class="form-group">
                            <label for="nama_usaha">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control" id="nama_usaha"
                                value="{{ $GroundCheck->nama_usaha }}" readonly>
                        </div>

                        {{-- Petugas --}}
                        <div class="form-group">
                            <label for="petugas">Petugas <span class="text-danger">*</span></label>
                            <select name="petugas_id"
                                class="form-control @error('petugas_id') is-invalid @enderror select2bs4" id="petugas"
                                style="width: 100%;">
                                <option value="">-- Pilih Petugas --</option>
                                @foreach ($listPetugas as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('petugas_id', $GroundCheck->petugas_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('petugas_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" readonly>{{ $GroundCheck->alamat }}</textarea>
                        </div>

                        {{-- Lokasi / Geotag --}}
                        <div class="form-group">
                            <label>Lokasi (Geotag) <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-6 col-md-5 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Lat</span>
                                        </div>
                                        <input type="text" name="latitude" id="latitude"
                                            class="form-control @error('latitude') is-invalid @enderror"
                                            value="{{ old('latitude', $GroundCheck->latitude != 0 ? $GroundCheck->latitude : '') }}"
                                            placeholder="Klik Deteksi..."
                                            {{ old('petugas_id', $GroundCheck->petugas_id) == '02' ? '' : 'readonly' }}
                                            onfocus="moveToInputLocation()">
                                    </div>
                                </div>

                                <div class="col-6 col-md-5 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Long</span>
                                        </div>
                                        <input type="text" name="longitude" id="longitude"
                                            class="form-control @error('longitude') is-invalid @enderror"
                                            value="{{ old('longitude', $GroundCheck->longitude != 0 ? $GroundCheck->longitude : '') }}"
                                            placeholder="Klik Deteksi..."
                                            {{ old('petugas_id', $GroundCheck->petugas_id) == '02' ? '' : 'readonly' }}
                                            onfocus="moveToInputLocation()">
                                    </div>
                                </div>

                                <div class="col-12 col-md-2 mb-2">
                                    <button type="button" class="btn btn-success btn-block" onclick="getLocation()">
                                        <i class="fas fa-map-marker-alt"></i> Deteksi
                                    </button>
                                </div>
                            </div>
                            {{-- Pesan Error Kolektif untuk Lat/Long --}}
                            @if ($errors->has('latitude') || $errors->has('longitude'))
                                <span class="text-danger small">Koordinat lokasi wajib dideteksi.</span>
                            @endif

                            <div id="map" style="height: 300px;" class="mt-2"></div>
                        </div>

                        {{-- Dokumentasi Foto --}}
                        <div class="form-group">
                            <label>Dokumentasi Foto Usaha <span id="bintang-foto" class="text-danger">*</span></label>
                            {{-- Foto yang sudah tersimpan di database --}}
                            @if ($GroundCheck->foto_usaha)
                                <div id="foto-lama-container" class="mb-2">
                                    {{-- Hapus 'storage/' karena path di DB sudah 'uploads/foto_groundcheck/...' --}}
                                    <img src="{{ asset($GroundCheck->foto_usaha) }}" class="img-thumbnail"
                                        style="max-height: 150px;" alt="Foto Saat Ini"
                                        onerror="this.src='https://placehold.co/300x200?text=Foto+Tidak+Ditemukan'">

                                    <p class="small text-muted">Foto saat ini</p>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-6">
                                    <label class="btn btn-primary btn-block">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                        <input type="file" id="input_kamera" accept="image/*" capture="camera"
                                            class="d-none" onchange="processImage(this)">
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="btn btn-info btn-block">
                                        <i class="fas fa-images"></i> Dari Galeri
                                        <input type="file" id="input_galeri" accept="image/*" class="d-none"
                                            onchange="processImage(this)">
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3">
                                {{-- 1. Loading Indicator (WAJIB ADA) --}}
                                <div id="loading-process" class="d-none text-primary mb-2 text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Memproses & Mengambil GPS...
                                </div>

                                {{-- 2. Wrapper Editor untuk Cropping (WAJIB ADA) --}}
                                <div id="wrapper-editor" class="d-none mb-3">
                                    <div style="max-height: 400px; overflow: hidden; background: #000;" class="rounded">
                                        <img id="image-to-crop" style="max-width: 100%;">
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="button" class="btn btn-success btn-block"
                                            onclick="finalizeImage()">
                                            <i class="fas fa-check"></i> Potong & Beri Watermark
                                        </button>
                                    </div>
                                </div>

                                {{-- 3. Preview Hasil Foto Baru --}}
                                <div id="wrapper-hasil" class="{{ old('foto_compressed') ? '' : 'd-none' }} text-center">
                                    <label class="d-block text-muted">Hasil Foto Baru:</label>
                                    <img id="final-preview" src="{{ old('foto_compressed') }}" class="img-thumbnail"
                                        style="max-height: 300px;">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                            <i class="fas fa-trash"></i> Hapus & Foto Ulang
                                        </button>
                                    </div>
                                </div>

                                {{-- Input Hidden untuk dikirim ke Controller --}}
                                <input type="hidden" name="foto_compressed" id="foto_compressed"
                                    value="{{ old('foto_compressed') }}">
                                <p id="size-info" class="text-muted small mt-2 text-center"></p>

                                @error('foto_compressed')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan">
                                Catatan Lapangan <span id="bintang-catatan" class="text-danger">*</span>
                            </label>
                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"
                                placeholder="Tambahkan catatan tambahan jika diperlukan...">{{ old('catatan', $GroundCheck->catatan) }}</textarea>
                            @error('catatan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('GroundCheck.index') }}" class="btn btn-default mr-3">
                            Batal <i class="fas fa-times"></i>
                        </a>
                        @if (!$GroundCheck->latitude || !$GroundCheck->longitude || !$GroundCheck->foto_usaha)
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Data Ground Check sudah lengkap dan telah tersimpan.
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- Peta --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 1. Ambil data dari Database via Blade
        // Jika data 0 atau null, gunakan default Jakarta
        var dbLat = parseFloat("{{ $GroundCheck->latitude }}") || -6.200000;
        var dbLng = parseFloat("{{ $GroundCheck->longitude }}") || 106.816666;

        // Inisialisasi Koordinat & Konfigurasi
        var defaultLat = dbLat;
        var defaultLng = dbLng;
        var maxRadius = 500;
        var centerPoint = L.latLng(defaultLat, defaultLng);
        var radiusCircle = null;

        // 2. Inisialisasi Peta - SetView langsung ke koordinat DB
        // Gunakan zoom 18 jika sudah ada koordinat, zoom 13 jika masih default
        var initialZoom = (dbLat !== -6.200000) ? 18 : 13;
        var map = L.map('map').setView(centerPoint, initialZoom);

        // --- LAYER GOOGLE MAPS HYBRID ---
        var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Google Maps Satellite'
        }).addTo(map);

        // 3. Tambah Marker di lokasi koordinat DB
        var marker = L.marker(centerPoint, {
            draggable: true
        }).addTo(map);

        // Fungsi menggambar visual radius 500m
        function drawRadius(latlng) {
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
            }
            radiusCircle = L.circle(latlng, {
                radius: maxRadius,
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.1,
                dashArray: '5, 10'
            }).addTo(map);
        }

        drawRadius(centerPoint);

        // LOGIKA PEMBATASAN RADIUS SAAT DIGESER
        marker.on('drag', function(e) {
            var currentPos = e.target.getLatLng();
            var distance = centerPoint.distanceTo(currentPos);

            if (distance > maxRadius) {
                var ratio = maxRadius / distance;
                var lat = (currentPos.lat - centerPoint.lat) * ratio + centerPoint.lat;
                var lng = (currentPos.lng - centerPoint.lng) * ratio + centerPoint.lng;
                marker.setLatLng([lat, lng]);
            }

            var finalPos = marker.getLatLng();
            document.getElementById('latitude').value = finalPos.lat.toFixed(8);
            document.getElementById('longitude').value = finalPos.lng.toFixed(8);
        });

        // Ambil lokasi otomatis dari browser (GPS)
        function getLocation() {
            if (navigator.geolocation) {
                var options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };

                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari Satelit...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    centerPoint = L.latLng(lat, lng);

                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);

                    marker.setLatLng(centerPoint);
                    map.setView(centerPoint, 18);

                    drawRadius(centerPoint);

                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, function(error) {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    alert("Error: " + error.message);
                }, options);
            }
        }
    </script>
    {{-- Foto --}}
    <script>
        let cropper = null;
        let tempGPS = {
            lat: "-",
            lng: "-"
        };
        let sumberFoto = "";

        function processImage(input) {
            const file = input.files[0];
            if (!file) return;

            sumberFoto = input.id;
            const loading = document.getElementById('loading-process');

            // Sembunyikan hasil lama dan editor saat memilih file baru
            loading.classList.remove('d-none');
            document.getElementById('wrapper-hasil').classList.add('d-none');
            document.getElementById('wrapper-editor').classList.add('d-none');

            if (sumberFoto === 'input_kamera') {
                // Ambil GPS dengan timeout agar tidak macet
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        tempGPS.lat = position.coords.latitude.toFixed(7);
                        tempGPS.lng = position.coords.longitude.toFixed(7);
                        loading.classList.add('d-none');
                        openEditor(file);
                    },
                    (error) => {
                        console.warn("GPS Gagal:", error);
                        tempGPS.lat = "-";
                        tempGPS.lng = "-";
                        loading.classList.add('d-none');
                        openEditor(file);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 5000
                    }
                );
            } else {
                loading.classList.add('d-none');
                openEditor(file);
            }
        }

        function openEditor(file) {
            const imgElement = document.getElementById('image-to-crop');
            const reader = new FileReader();

            reader.onload = function(e) {
                imgElement.src = e.target.result;

                // JIKA DARI KAMERA: Langsung finalize (Tanpa Crop)
                if (sumberFoto === 'input_kamera') {
                    // Tunggu gambar load sebentar agar canvas bisa menggambar
                    imgElement.onload = function() {
                        finalizeImage(true); // Kirim parameter true untuk skip cropper
                    };
                }
                // JIKA DARI GALERI: Tetap pakai Crop
                else {
                    document.getElementById('wrapper-editor').classList.remove('d-none');
                    if (document.getElementById('foto-lama-container')) {
                        document.getElementById('foto-lama-container').classList.add('d-none');
                    }

                    if (cropper) cropper.destroy();
                    cropper = new Cropper(imgElement, {
                        aspectRatio: 4 / 3,
                        viewMode: 1,
                        dragMode: 'move'
                    });
                }
            };
            reader.readAsDataURL(file);
        }

        function finalizeImage(skipCrop = false) {
            let canvas;
            const imgElement = document.getElementById('image-to-crop');

            if (skipCrop) {
                // Buat canvas manual dari gambar asli
                canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Tentukan ukuran maksimal (misal width 1024 agar tidak terlalu berat)
                const scale = 1024 / imgElement.naturalWidth;
                canvas.width = 1024;
                canvas.height = imgElement.naturalHeight * scale;

                ctx.drawImage(imgElement, 0, 0, canvas.width, canvas.height);
            } else {
                // Ambil hasil dari cropper (untuk galeri)
                if (!cropper) return;
                canvas = cropper.getCroppedCanvas({
                    width: 1024
                });
            }

            const ctx = canvas.getContext('2d');
            const height = canvas.height;

            // Tambahkan Watermark (Hanya jika dari kamera)
            if (sumberFoto === 'input_kamera') {
                ctx.fillStyle = "rgba(0, 0, 0, 0.6)";
                ctx.fillRect(0, height - 90, 450, 90);

                ctx.fillStyle = "#ffffff";
                ctx.font = "bold 24px Arial";
                ctx.fillText("KAMERA TERVERIFIKASI", 20, height - 55);
                ctx.font = "20px Monospace";
                ctx.fillText("LAT: " + tempGPS.lat + " | LNG: " + tempGPS.lng, 20, height - 20);
            }

            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            document.getElementById('foto_compressed').value = dataUrl;
            document.getElementById('final-preview').src = dataUrl;

            // Sembunyikan editor dan tampilkan hasil
            document.getElementById('wrapper-editor').classList.add('d-none');
            document.getElementById('wrapper-hasil').classList.remove('d-none');

            // Sembunyikan foto lama
            if (document.getElementById('foto-lama-container')) {
                document.getElementById('foto-lama-container').classList.add('d-none');
            }

            const fileSizeStr = Math.round((dataUrl.length * 3 / 4) / 1024);
            document.getElementById('size-info').innerHTML = "Ukuran: " + fileSizeStr + " KB " +
                (sumberFoto === 'input_kamera' ? "(Geotagged)" : "");

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        function removeImage() {
            document.getElementById('wrapper-hasil').classList.add('d-none');
            document.getElementById('foto_compressed').value = "";
            document.getElementById('input_kamera').value = "";
            document.getElementById('input_galeri').value = "";
            document.getElementById('size-info').innerHTML = "";

            // Tampilkan kembali foto lama jika ada
            if (document.getElementById('foto-lama-container')) {
                document.getElementById('foto-lama-container').classList.remove('d-none');
            }
        }
    </script>
    {{-- Script untuk agen statistik --}}
    <script>
        $(document).ready(function() {
            const targetPetugas = "Agen Statistik Universitas Bina Insan";

            $('#petugas').on('change', function() {
                let selectedText = $(this).find('option:selected').text().trim();

                let latInput = document.getElementById('latitude');
                let lngInput = document.getElementById('longitude');
                let bintangFoto = document.getElementById('bintang-foto');
                let bintangCatatan = document.getElementById('bintang-catatan');

                if (selectedText === targetPetugas) {
                    // Aktifkan input koordinat
                    latInput.readOnly = false;
                    lngInput.readOnly = false;

                    // Sembunyikan tanda wajib (*) pada Foto dan Catatan
                    if (bintangFoto) bintangFoto.classList.add('d-none');
                    if (bintangCatatan) bintangCatatan.classList.add('d-none');

                    // Matikan pembatas radius (seperti bahasan sebelumnya)
                    marker.off('drag');
                    marker.on('drag', function(e) {
                        var finalPos = e.target.getLatLng();
                        latInput.value = finalPos.lat.toFixed(8);
                        lngInput.value = finalPos.lng.toFixed(8);
                        centerPoint = finalPos;
                        drawRadius(finalPos);
                    });

                } else {
                    // Kembalikan ke mode normal
                    latInput.readOnly = true;
                    lngInput.readOnly = true;
                    if (bintangFoto) bintangFoto.classList.remove('d-none');
                    if (bintangCatatan) bintangCatatan.classList.remove('d-none');

                    resetRadiusLogic();
                }
            });

            // Trigger saat load pertama kali untuk handle mode Edit
            $('#petugas').trigger('change');
        });
    </script>
@endpush
