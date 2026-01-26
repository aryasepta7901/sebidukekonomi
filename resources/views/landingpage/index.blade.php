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
                        <h5 class="countdown-title">Kick-off Pencacahan Lapangan SE2026:</h5>
                        <div class="countdown d-flex justify-content-start" data-count="2026/05/01">
                            <div>
                                <h3 class="count-days"></h3>
                                <h4>Hari</h4>
                            </div>
                            <div>
                                <h3 class="count-hours"></h3>
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
                        <img src="{{ asset('img/depan.JPG') }}" alt="SEbiduk Ekonomi Dashboard"
                            class="img-fluid hero-image">

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
                        </div>
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
                            data-bs-target="#pane-6" type="button">Juni - Juli</button></li>
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
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Barat I</h2>
                                    <p class="fst-italic text-muted">
                                        "Masa depanmu dimulai dari apa yang kamu pelajari hari ini."
                                    </p>
                                    <p>
                                        Bertanggung jawab dalam koordinasi lapangan, pengawasan pendaftaran usaha, dan
                                        menjamin kualitas data di seluruh kelurahan wilayah Lubuk Linggau Barat I.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/ade.png') }}" class="profile-img" alt="Ade Suteja">
                                        <div class="profile-info">
                                            <h3>Ade Suteja</h3>
                                            <span>KOSEKA Barat I</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/ade.png') }}" class="featured-img"
                                            alt="Ade Suteja Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Barat II</h2>
                                    <p class="fst-italic text-muted">
                                        "Talk is Cheap. Show me The Code."
                                    </p>
                                    <p>
                                        Memastikan integritas data sensus ekonomi di wilayah Barat II melalui pemantauan
                                        intensif dan dukungan teknis kepada para petugas lapangan.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/arya_fix.png') }}" class="profile-img" alt="Arya Septa">
                                        <div class="profile-info">
                                            <h3>M. Arya Septa Kovitra, S.Tr.Stat.</h3>
                                            <span>KOSEKA Barat II</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/arya_fix.png') }}" class="featured-img"
                                            alt="Arya Septa Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Selatan I</h2>
                                    <p class="fst-italic text-muted">
                                        "Fokuslah mengembangkan diri, agar tak larut dalam opini mereka yang tak peduli."
                                    </p>
                                    <p>
                                        Mengawal jalannya Sensus Ekonomi 2026 di wilayah Selatan I demi mewujudkan basis
                                        data ekonomi yang akurat dan terpercaya.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/arif.png') }}" class="profile-img"
                                            alt="Arif Hidayatullah">
                                        <div class="profile-info">
                                            <h3>M. Arif Hidayatullah, A.Md.T.</h3>
                                            <span>KOSEKA Selatan I</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/arif.png') }}" class="featured-img"
                                            alt="Arif Hidayatullah Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Selatan II</h2>
                                    <p class="fst-italic text-muted">
                                        "Don't watch the clock; do what it does. Keep going!"
                                    </p>
                                    <p>
                                        Berkomitmen tinggi dalam mensukseskan pendataan ekonomi di wilayah Selatan II dengan
                                        koordinasi tim yang solid.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/fathur.png') }}" class="profile-img" alt="Fathu Rahman">
                                        <div class="profile-info">
                                            <h3>M. Fathu Rahman, S.Tr.Stat.</h3>
                                            <span>KOSEKA Selatan II</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/fathur.png') }}" class="featured-img"
                                            alt="Fathu Rahman Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Timur I</h2>
                                    <p class="fst-italic text-muted">
                                        "Dedikasi dan ketelitian adalah kunci kualitas data yang berharga."
                                    </p>
                                    <p>
                                        Bertanggung jawab penuh dalam mengoordinasikan pendataan ekonomi di wilayah Timur I
                                        untuk memastikan setiap unit usaha tercatat dengan akurat.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/novi.png') }}" class="profile-img" alt="Novi Marlina">
                                        <div class="profile-info">
                                            <h3>Novi Marlina, S.Si.</h3>
                                            <span>KOSEKA Timur I</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/novi.png') }}" class="featured-img"
                                            alt="Novi Marlina Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Timur II</h2>
                                    <p class="fst-italic text-muted">
                                        "Bekerja keras dalam diam, biarkan data yang berbicara."
                                    </p>
                                    <p>
                                        Mengawal kualitas pendaftaran usaha dan sinergi tim lapangan di wilayah Timur II
                                        guna mensukseskan Sensus Ekonomi 2026.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/yessy.png') }}" class="profile-img" alt="Yessy">
                                        <div class="profile-info">
                                            <h3>Yessy Zaliah Purnama Sari, A.Md.</h3>
                                            <span>KOSEKA Timur II</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/yessy.png') }}" class="featured-img" alt="Yessy Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Utara I</h2>
                                    <p class="fst-italic text-muted">
                                        "Kualitas data adalah cerminan integritas dalam setiap langkah pendataan."
                                    </p>
                                    <p>
                                        Memastikan kelancaran koordinasi dan akurasi cakupan unit usaha di wilayah Utara I
                                        demi mewujudkan basis data ekonomi yang handal dan terpercaya.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/luluk.png') }}" class="profile-img"
                                            alt="Luluk Indryas Mufida">
                                        <div class="profile-info">
                                            <h3>Luluk Indryas Mufida, S.Tr.Stat.</h3>
                                            <span>KOSEKA Utara I</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/luluk.png') }}" class="featured-img"
                                            alt="Luluk Indryas Mufida Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Lubuk Linggau Utara II</h2>
                                    <p class="fst-italic text-muted">
                                        "Sinergi lapangan yang kuat melahirkan data statistik yang tepat."
                                    </p>
                                    <p>
                                        Mengawasi jalannya pendaftaran usaha di wilayah Utara II dengan pendekatan strategis
                                        untuk mendukung kesuksesan sensus ekonomi yang komprehensif.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('img/raden.png') }}" class="profile-img" alt="Raden Mulia">
                                        <div class="profile-info">
                                            <h3>Raden Mulia, S.Tr.Stat.</h3>
                                            <span>KOSEKA Utara II</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('img/raden.png') }}" class="featured-img"
                                            alt="Raden Mulia Large">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
