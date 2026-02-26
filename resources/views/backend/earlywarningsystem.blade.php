@extends('backend.layouts.app')

@section('title', 'Monitoring Lapangan')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <img src="{{ asset('img/earlywarning.jpeg') }}" class="img-fluid featured-img"
                                alt="Monitoring Image" style="width: 100%; height: auto; display: block;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
