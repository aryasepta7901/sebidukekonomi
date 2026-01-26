@extends('frontend.app')

@section('title', 'Halaman Dashboard')
@section('header_title', 'Ground Check')

@section('breadcrumb')

    <li class="breadcrumb-item active">Ground Check</li>
@endsection
@push('styles')
@endpush
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Prelist Ground Check</h3>

            <div class="card-tools">
                <div class="d-flex flex-column flex-md-row justify-content-end">
                    {{-- Filter Kecamatan --}}
                    <div class="mr-md-2 mb-2 mb-md-0" style="min-width: 200px;">
                        <select id="filterKecamatan" class="form-control form-control-sm select2bs4">
                            <option value="">-- Semua Kecamatan --</option>
                            @foreach ($listKecamatan as $kec)
                                <option value="{{ $kec['id'] }}">{{ $kec['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Kelurahan --}}
                    <div style="min-width: 200px;">
                        <select id="filterKelurahan" class="form-control form-control-sm select2bs4">
                            <option value="">-- Semua Kelurahan --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID SBR</th>
                            <th>Nama Usaha</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Petugas</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Akan diisi oleh DataTables Ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Gabungkan inisialisasi menjadi satu menggunakan ID yang benar (#example1)
            var table = $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('GroundCheck.index') }}",
                    "data": function(d) {
                        // Tambahkan parameter filter agar terbaca oleh Controller
                        d.filterKec = $('#filterKecamatan').val();
                        d.filterDesa = $('#filterKelurahan').val();
                    }
                },
                "columns": [{
                        "data": "idsbr",
                        "name": "idsbr"
                    },
                    {
                        "data": "nama_usaha",
                        "name": "nama_usaha"
                    },
                    {
                        "data": "alamat",
                        "name": "alamat"
                    },
                    {
                        "data": "kdkec",
                        "name": "kdkec",
                        "render": function(data, type, row) {
                            return (data == 0 || data == "0" || data == null || data == "-") ?
                                '<div class="text-center">-</div>' : data;
                        }
                    },
                    {
                        "data": "kddesa",
                        "name": "kddesa",
                        "render": function(data, type, row) {
                            return (data == 0 || data == "0" || data == null || data == "-") ?
                                '<div class="text-center">-</div>' : data;
                        }
                    },
                    {
                        "data": "petugas",
                        "name": "petugas.nama",
                        "render": function(data, type, row) {
                            return data ? '<span class="badge badge-info">' + data.nama +
                                '</span>' :
                                '<span class="badge badge-secondary">Belum Ditugaskan</span>';
                        }
                    },
                    {
                        "data": "idsbr",
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row) {
                            // Link mengarah ke /GroundCheck/{idsbr}
                            let viewUrl = "{{ url('/GroundCheck') }}/" + data;
                            return ` <div class="text-center"><a href="${viewUrl}" class="btn btn-sm btn-warning" title="Lihat/Edit Data"> <i class="fas fa-edit"></i> Edit</a></div>`;
                        }
                    }
                ],
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            });

            // Pindahkan buttons ke container
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Event saat Kecamatan dipilih
            $('#filterKecamatan').on('change', function() {
                var kdkec = $(this).val();

                // Reset dropdown kelurahan
                $('#filterKelurahan').html('<option value="">-- Semua Kelurahan --</option>');

                if (kdkec) {
                    // Ambil data kelurahan via AJAX
                    var urlDesa = "{{ route('GroundCheck.listDesa', ':id') }}";
                    urlDesa = urlDesa.replace(':id', kdkec);

                    $.get(urlDesa, function(data) {
                        $.each(data, function(key, value) {
                            $('#filterKelurahan').append('<option value="' + value.id +
                                '">' + value.nama + '</option>');
                        });
                    });
                }

                // Jalankan filter DataTable
                table.draw();
            });

            // Event saat Kelurahan dipilih
            $('#filterKelurahan').on('change', function() {
                // Jalankan filter DataTable
                table.draw();
            });
        });
    </script>
@endpush
