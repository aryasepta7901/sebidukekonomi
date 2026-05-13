@extends('landingpage.layouts.app')

@section('content')
    {{-- Hero --}}
    <section id="hero" class="hero section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">

                    <h1 class="hero-title"><span style="color: #fd7e14;">SE</span>biduk Ekonomi</h1>

                    <p class="hero-subtitle">Sistem Monitoring & Evaluasi Sensus Ekonomi 2026</p>

                    <p class="hero-description">
                        Platform integrasi pendataan untuk menjamin kualitas data sensus.
                        Mendukung penuh tahapan <strong>Ground Checking</strong>, manajemen <strong>Pra-Pendataan</strong>,
                        hingga validasi <strong>Pasca-Pencacahan</strong> untuk deteksi dini anomali data dan monitoring
                        performa petugas di lapangan.
                    </p>

                    <div class="event-details mb-4">
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-shield-check"></i>
                            <span>Quality Assurance & Anomaly Detection</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="350">
                            <i class="bi bi-geo-fill"></i>
                            <span>Real-time Ground Checking Tracking</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span>Progress Monitoring SE2026</span>
                        </div>
                    </div>

                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="450">
                        <a href="#monitoring" class="btn btn-primary btn-lg me-3">Mulai Monitoring</a>
                        <a href="/GroundCheck" class="btn btn-outline-primary btn-lg">Ground Check</a>
                    </div>

                    <div class="countdown-wrapper mt-4" data-aos="fade-up" data-aos-delay="500">
                        <h5 class="countdown-title">Sisa Waktu Pencacahan Lapangan SE2026</h5>
                        <div class="countdown d-flex justify-content-start" data-count="2026/09/01">
                            <div>
                                <h3 class="count-days"></h3>
                                <h4>Hari</h4>
                            </div>
                            <div>
                                <h3 class="count-hours "></h3>
                                <h4>Jam</h4>
                            </div>
                            <div>
                                <h3 class="count-minutes"></h3>
                                <h4>Menit</h4>
                            </div>
                            <div>
                                <h3 class="count-seconds"></h3>
                                <h4>Detik</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('img/landingpage.png') }}" alt="SEbiduk Ekonomi Dashboard"
                            class="img-fluid hero-image ">
                        {{-- 
                        <div class="floating-badges">
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="600">
                                <i class="bi bi-search"></i>
                                <span>Ground Checking</span>
                            </div>

                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="650">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>Deteksi Anomali</span>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="700">
                                <i class="bi bi-check-all"></i>
                                <span>Validasi Data</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Schedule --}}
    <section id="schedule" class="schedule section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Timeline SEbiduk Ekonomi</h2>
            <p>Rangkaian kegiatan komprehensif menuju sukses Sensus Ekonomi 2026</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="schedule-header">
                <ul class="nav nav-tabs" id="schedule-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" id="tab-1" data-bs-toggle="tab"
                            data-bs-target="#pane-1" type="button">Januari</button></li>
                    <li class="nav-item"><button class="nav-link" id="tab-2" data-bs-toggle="tab"
                            data-bs-target="#pane-2" type="button">Februari</button></li>
                    <li class="nav-item"><button class="nav-link" id="tab-3" data-bs-toggle="tab"
                            data-bs-target="#pane-3" type="button">Maret</button></li>
                    <li class="nav-item"><button class="nav-link" id="tab-4" data-bs-toggle="tab"
                            data-bs-target="#pane-4" type="button">April</button></li>
                    <li class="nav-item"><button class="nav-link" id="tab-5" data-bs-toggle="tab"
                            data-bs-target="#pane-5" type="button">Mei</button></li>
                    <li class="nav-item"><button class="nav-link" id="tab-6" data-bs-toggle="tab"
                            data-bs-target="#pane-6" type="button">Juni - Agustus</button></li>
                </ul>
            </div>

            <div class="tab-content" id="schedule-tabContent">

                <div class="tab-pane fade show active" id="pane-1" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Diskusi</span></div>
                                        <h3 class="session-title">RABU SE (Ruang Aktif untuk Berdiskusi Untuk Sensus
                                            Ekonomi)</h3>
                                        <p class="session-description">Forum rutin mingguan untuk membahas kendala teknis
                                            dan strategi percepatan persiapan SE2026.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track business">Kolaborasi</span></div>
                                        <h3 class="session-title">Koordinasi dan Kolaborasi Eksternal</h3>
                                        <p class="session-description">Koordinasi dengan Pemkot (Sekda, Pengusaha, PT,
                                            SPPG) terkait integrasi database usaha dan pembuatan PKS/MOU.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Ground Checking</span>
                                        </div>
                                        <h3 class="session-title">Ground Checking Pra-Pendataan</h3>
                                        <p class="session-description">Verifikasi lapangan awal untuk memastikan keberadaan
                                            unit usaha dan validasi Master File Desa.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Publisitas</span></div>
                                        <h3 class="session-title">Take Video Dukungan SE</h3>
                                        <p class="session-description">Produksi konten audiovisual dari tokoh daerah untuk
                                            meningkatkan kepercayaan masyarakat.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Publisitas</span></div>
                                        <h3 class="session-title">Himbauan Spanduk SE2026</h3>
                                        <p class="session-description">Pemasangan alat peraga kampanye (spanduk/banner) di
                                            seluruh kantor Pemda dan instansi terkait.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track business">Kelurahan</span></div>
                                        <h3 class="session-title">Pembentukan Agen Statistik Kelurahan</h3>
                                        <p class="session-description">Perekrutan agen tingkat kelurahan untuk membantu
                                            edukasi dan persiapan pendataan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Internal</span></div>
                                        <h3 class="session-title">Internalisasi SE2026 ke Pegawai BPS</h3>
                                        <p class="session-description">Penyelarasan pemahaman seluruh pegawai BPS mengenai
                                            mekanisme dan target Sensus Ekonomi 2026.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-2" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Ground Checking</span>
                                        </div>
                                        <h3 class="session-title">Ground Checking Lanjutan</h3>
                                        <p class="session-description">Pendalaman verifikasi lapangan pada wilayah dengan
                                            konsentrasi usaha tinggi.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Momentum</span></div>
                                        <h3 class="session-title">Moment Puasa Ramadhan</h3>
                                        <p class="session-description">Pemanfaatan suasana Ramadhan untuk pendekatan
                                            persuasif kepada masyarakat dan pelaku usaha.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Rekrutmen</span></div>
                                        <h3 class="session-title">Rekrutmen Petugas SE2026</h3>
                                        <p class="session-description">Seleksi terbuka untuk mencari petugas lapangan yang
                                            kompeten (Pertengahan bulan).</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Launching</span></div>
                                        <h3 class="session-title">Pencanangan SE Nasional & Daerah</h3>
                                        <p class="session-description">Peresmian tahapan besar Sensus Ekonomi secara
                                            serentak di tingkat pusat dan daerah.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track business">Inovasi</span></div>
                                        <h3 class="session-title">Gencarkan Inovasi Takjil & Booth SE</h3>
                                        <p class="session-description">Bagi takjil + flyer, booth di Pasar Bedug/Taman
                                            Kurma, dan pasar jajanan sumbangsih berstiker SE.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Edukasi</span></div>
                                        <h3 class="session-title">Sosialisasi Kontinu & Periodik</h3>
                                        <p class="session-description">Edukasi berkelanjutan secara periodik agar kesadaran
                                            publik tetap terjaga (bukan efek sementara).</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-3" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Religius</span></div>
                                        <h3 class="session-title">Puasa Ramadhan & Lebaran Idul Fitri</h3>
                                        <p class="session-description">Integrasi pesan sensus dalam kegiatan kemasyarakatan
                                            selama bulan suci dan libur lebaran.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track business">Advokasi</span></div>
                                        <h3 class="session-title">Surat Dukungan Forkopimda</h3>
                                        <p class="session-description">Penyediaan surat dukungan resmi dari Walikota,
                                            Kapolres, dan Dandim untuk kelancaran lapangan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-4" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Kapasitas</span></div>
                                        <h3 class="session-title">Pelatihan Instruktur</h3>
                                        <p class="session-description">Pembekalan teknis bagi instruktur daerah yang akan
                                            membawahi para petugas.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Publisitas</span></div>
                                        <h3 class="session-title">Publisitas Masif Media & Baliho</h3>
                                        <p class="session-description">Kampanye besar-besaran di media cetak, radio,
                                            baliho, dan tempat-tempat strategis.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track business">Edukasi</span></div>
                                        <h3 class="session-title">Kunjungan Universitas & SMA/SMK</h3>
                                        <p class="session-description">Sosialisasi ke sektor akademisi untuk memperluas
                                            jangkauan pemahaman Sensus Ekonomi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-5" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Sensus Online</span>
                                        </div>
                                        <h3 class="session-title">Sensus Online & Pendampingan</h3>
                                        <p class="session-description">Pelaksanaan sensus online serta pendampingan
                                            langsung bagi responden yang membutuhkan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Pelatihan</span></div>
                                        <h3 class="session-title">Pelatihan Petugas Lapangan</h3>
                                        <p class="session-description">Final briefing teknis tata cara pengisian dokumen
                                            dan penggunaan aplikasi monitoring.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Siaga</span></div>
                                        <h3 class="session-title">Apel Siaga Sensus Ekonomi 2026</h3>
                                        <p class="session-description">Upacara kesiapan akhir sebelum petugas diterjunkan
                                            secara serentak ke lapangan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-6" role="tabpanel">
                    <div class="schedule-content">
                        <div class="session-timeline">
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track development">Pencacahan</span></div>
                                        <h3 class="session-title">Pelaksanaan Lapangan</h3>
                                        <p class="session-description">Proses pendataan menyeluruh ke unit-unit usaha di
                                            seluruh wilayah tugas.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track design">Supervisi</span></div>
                                        <h3 class="session-title">Pengawasan Lapangan</h3>
                                        <p class="session-description">Monitoring intensif oleh supervisor untuk menjamin
                                            keakuratan data hasil pencacahan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="session-block">
                                <div class="session-card">
                                    <div class="session-info">
                                        <div class="session-meta"><span class="track keynote">Kualitas</span></div>
                                        <h3 class="session-title">Monitoring & Penjaminan Kualitas</h3>
                                        <p class="session-description">Pemeriksaan anomali dan validasi data akhir
                                            menggunakan dashboard SEbiduk Ekonomi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="testimonials" class="testimonials section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Profil KOSEKA & Wilayah Tugas</h2>
            <p>Koordinator Statistik Kecamatan untuk Sensus Ekonomi 2026 Kota Lubuklinggau</p>
        </div>

        <div class="container mb-3">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-lg border-0"
                        style="background: linear-gradient(45deg, #fd7e14, #ff9800); color: white; border-radius: 15px;">
                        <div class="card-body text-center p-4">
                            <div class="mb-2">
                                <i class="bi bi-graph-up-arrow" style="font-size: 2rem; opacity: 0.8;"></i>
                            </div>
                            <h5 class="card-title fw-light text-uppercase tracking-wider">Total Usaha Aktif</h5>
                            <h2 class="display-3 fw-bold my-2">
                                {{ number_format($totalUsahaAktif ?? 0, 0, ',', '.') }}
                            </h2>

                            <div class="row g-2 mt-3 mb-4">
                                <div class="col-4 border-end border-white border-opacity-25">
                                    <p class="mb-0 small opacity-75">UB</p>
                                    <h6 class="fw-bold mb-0">{{ number_format($totalUB ?? 0, 0, ',', '.') }}</h6>
                                </div>
                                <div class="col-4 border-end border-white border-opacity-25">
                                    <p class="mb-0 small opacity-75">UM</p>
                                    <h6 class="fw-bold mb-0">{{ number_format($totalUM ?? 0, 0, ',', '.') }}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="mb-0 small opacity-75">UMK</p>
                                    <h6 class="fw-bold mb-0">{{ number_format($totalUMK ?? 0, 0, ',', '.') }}</h6>
                                </div>
                            </div>

                            <div
                                style="background: rgba(255,255,255,0.2); border-radius: 50px; padding: 5px 15px; display: inline-block;">
                                <p class="mb-0 small">
                                    <i class="bi bi-check-circle-fill me-1"></i> Hasil Ground Checking SE2026
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonials-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
                {
                    "slidesPerView": 1,
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                    }
                }
            </script>

                <div class="swiper-wrapper">
                    @foreach ($listKoseka as $koseka)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h2 id="{{ $koseka['id'] }}">{{ $koseka['wilayah'] }}</h2>
                                        <p class="fst-italic text-muted">{{ $koseka['quote'] }}</p>

                                        <div class="d-flex align-items-stretch gap-3 mb-3">
                                            <div class="badge-rekap p-3 shadow-sm d-flex align-items-center justify-content-center gap-3"
                                                style="background: #fff; border: 2px solid #fd7e14; border-radius: 12px; color: #333; min-width: 180px; flex: 1.5;">

                                                <i class="bi bi-shop-window"
                                                    style="font-size: 2.2rem; color: #fd7e14;"></i>

                                                <div class="text-center">
                                                    <small class="text-muted d-block text-uppercase fw-bold"
                                                        style="font-size: 0.7rem; letter-spacing: 1px;">Usaha Aktif</small>
                                                    <span class="fw-bold"
                                                        style="color: #fd7e14; font-size: 2rem; line-height: 1;">
                                                        {{ number_format($rekapPerKoseka[$koseka['id']]['total'] ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="badge-rekap p-2 px-3 shadow-sm d-flex align-items-center flex-grow-1"
                                                style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 12px; color: #333; flex: 2;">

                                                <div class="d-flex justify-content-around w-100 text-center">
                                                    <div class="px-2">
                                                        <i class="bi bi-building d-block mb-1 text-muted"
                                                            style="font-size: 1.1rem;"></i>
                                                        <small class="text-muted d-block"
                                                            style="font-size: 0.65rem;">UB</small>
                                                        <span class="fw-bold" style="font-size: 1.1rem;">
                                                            {{ number_format($rekapPerKoseka[$koseka['id']]['ub'] ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>

                                                    <div class="border-start"></div>

                                                    <div class="px-2">
                                                        <i class="bi bi-house-door d-block mb-1 text-muted"
                                                            style="font-size: 1.1rem;"></i>
                                                        <small class="text-muted d-block"
                                                            style="font-size: 0.65rem;">UM</small>
                                                        <span class="fw-bold" style="font-size: 1.1rem;">
                                                            {{ number_format($rekapPerKoseka[$koseka['id']]['um'] ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>

                                                    <div class="border-start"></div>

                                                    <div class="px-2">
                                                        <i class="bi bi-basket d-block mb-1 text-muted"
                                                            style="font-size: 1.1rem;"></i>
                                                        <small class="text-muted d-block"
                                                            style="font-size: 0.65rem;">UMK</small>
                                                        <span class="fw-bold" style="font-size: 1.1rem;">
                                                            {{ number_format($rekapPerKoseka[$koseka['id']]['umk'] ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p>{{ $koseka['deskripsi'] }}</p>

                                        <div class="profile d-flex align-items-center">
                                            <img src="{{ asset('img/' . $koseka['foto']) }}" class="profile-img"
                                                alt="{{ $koseka['nama'] }}">
                                            <div class="profile-info">
                                                <h3>{{ $koseka['nama'] }}</h3>
                                                <span>{{ $koseka['jabatan'] }}</span>
                                            </div>
                                            <a href="{{ route('koseka.detail', $koseka['id']) }}"
                                                class="btn btn-primary shadow-sm ms-auto"
                                                style="background-color: #fd7e14; border: none; padding: 10px 25px; border-radius: 30px;">
                                                <i class="bi bi-geo-alt-fill me-2"></i> Lihat Wilayah
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="featured-img-wrapper">
                                            <img src="{{ asset('img/' . $koseka['foto_wil']) }}" class="featured-img"
                                                alt="{{ $koseka['nama'] }} Large">
                                        </div>
                                        <p class="mt-3 text-center featured-name-caption">
                                            {{ $koseka['korwil1'] }} — <strong>{{ $koseka['koseka'] }}</strong> —
                                            {{ $koseka['korwil2'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil bulan sekarang (0 = Januari, 1 = Februari, dst)
            const now = new Date();
            const currentMonth = now.getMonth() + 1; // Januari jadi 1, Februari jadi 2

            let targetTabId = "";

            // 2. Tentukan target ID berdasarkan bulan
            // Kita sesuaikan dengan struktur tab Anda (1-5 bulan spesifik, 6 untuk Juni-Juli)
            if (currentMonth === 1) {
                targetTabId = "tab-1"; // Januari
            } else if (currentMonth === 2) {
                targetTabId = "tab-2"; // Februari
            } else if (currentMonth === 3) {
                targetTabId = "tab-3"; // Maret
            } else if (currentMonth === 4) {
                targetTabId = "tab-4"; // April
            } else if (currentMonth === 5) {
                targetTabId = "tab-5"; // Mei
            } else if (currentMonth >= 6 && currentMonth <= 7) {
                targetTabId = "tab-6"; // Juni - Juli
            } else if (currentMonth > 7) {
                targetTabId = "tab-6"; // Jika sudah lewat Juli, tetap di tab terakhir
            }

            // 3. Eksekusi perpindahan tab jika target ditemukan
            if (targetTabId) {
                const activeTab = document.getElementById(targetTabId);
                if (activeTab) {
                    // Hapus class 'active' dari tab default (Januari)
                    document.querySelectorAll('.schedule .nav-link').forEach(el => {
                        el.classList.remove('active');
                    });
                    document.querySelectorAll('.schedule .tab-pane').forEach(el => {
                        el.classList.remove('show', 'active');
                    });

                    // Aktifkan tab yang sesuai bulan sekarang
                    activeTab.classList.add('active');
                    const targetPaneId = activeTab.getAttribute('data-bs-target');
                    const targetPane = document.querySelector(targetPaneId);
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }
                }
            }
        });
    </script>
@endsection
