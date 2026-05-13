@extends('backend.layouts.app')

@section('title', 'Dashboard GC')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Ground Check</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/backend">Home</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="callout callout-info bg-white shadow-sm">
                        <h5><i class="fas fa-hand-peace text-info mr-2"></i> Selamat Datang,
                            <strong>{{ Auth::user()->name }}</strong>!
                        </h5>
                        <p>Anda login sebagai <span class="badge badge-primary">{{ strtoupper(Auth::user()->role) }}</span>.
                            Silakan pilih menu di bawah untuk mulai mengelola data SE2026.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>GC</h3>
                            <p>Dashboard Ground Check</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <a href="{{ url('/DashboardGC') }}" class="small-box-footer">
                            Buka Pemantauan <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                {{-- 
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>BRS</h3>
                            <p>Berita Resmi Statistik</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <a href="{{ route('berita.index') }}" class="small-box-footer">
                            Kelola Berita <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Info</h3>
                            <p>Panduan & Bantuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Lihat Panduan <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>


@endsection
