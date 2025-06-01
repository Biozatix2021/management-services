@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Uji Fungsi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Uji Fungsi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="border-radius: 5px;">
                    <div class="text-center">
                        <div class="input-group" style="width: 100%; max-width: 50%; margin: 0 auto; margin-bottom: 10px;">
                            {{-- make select option --}}
                            <select id="filter" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                <option value="">Pilih Alat</option>
                                @foreach ($alats as $alat)
                                    <option value="{{ $alat->id }}">{{ $alat->merk }} {{ $alat->tipe }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-secondary" style="background-color: #3c8dbc; color:white" onclick="filter()">Terapkan</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabel-uji-fungsi" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>SN</th>
                                    <th>No Order</th>
                                    <th>No Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Tgl Terima</th>
                                    <th>Tgl Selesai</th>
                                    <th>Status</th>
                                    <th width="20px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail-uji-fungsi" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loader" style="display: none; position: fixed; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; text-align: center;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(37, 33, 33, 0.082);"></div>
                        <img src="{{ asset('img/spinner.gif') }}" style="width: 90px" alt="Loading..." />
                    </div>
                    {{-- Data will be displayed here --}}
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle img-alat" src="" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center nama-alat"></h3>

                                    <p class="text-muted text-center"></p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>S/N</b> <a class="float-right no_seri"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>No Order</b> <a class="float-right no-order"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>No Faktur</b> <a class="float-right no-faktur"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tgl Faktur</b> <a class="float-right tgl-faktur"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tgl Terima</b> <a class="float-right tgl-terima"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tgl Selesai</b> <a class="float-right tgl-selesai"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> <a class="float-right status"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Teknisi</b> <a class="float-right teknisi"></a>
                                        </li>
                                    </ul>
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-text-width"></i>

                                            <h3 class="box-title">Keterangan</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <blockquote class="keterangan">
                                                {{-- berisi keterangan --}}
                                            </blockquote>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <button type="button" class="btn btn-default" onclick="downloadData()"><i class="fa fa-download" aria-hidden="true"></i>
                                        Download</button>
                                    <button type="button" class="btn btn-default" onclick="printData()"> <i class="fa fa-print" aria-hidden="true"></i>
                                        Print</button>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-9" style="overflow-y: auto; max-height: 700px;">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Detail Data Uji Fungsi</h3>
                                </div>
                                <div class="box-body" style="overflow-x: auto;">
                                    <div class="data-tables">
                                        <table class="table table-bordered" id="detail-data-uji-fungsi" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Item Check</th>
                                                    <th>Qty</th>
                                                    <th>Check / Not</th>
                                                    <th>Dokumentasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


        function showData(id) {
            $.ajax({
                url: "{{ url('data-uji-fungsi') }}" + '/' + id,
                type: "GET",
                beforeSend: function() {
                    $('.overlay').show();
                },
                complete: function() {
                    setTimeout(function() {
                        $('.overlay').hide();
                    }, 1000); // Delay for 2 seconds before hiding the loader and overlay
                },
                success: function(data) {
                    console.log(data);
                    $('#detail-uji-fungsi').modal('show');
                    $('.img-alat').attr('src', '/storage/alat/' + data.alat.gambar);
                    $('.nama-alat').text(data.alat.brand + ' ' + data.alat.tipe);
                    $('.text-muted.text-center').text(data.alat.nama);
                    $('.no_seri').text(data.no_seri);
                    $('.no-order').text(data.no_order);
                    $('.no-faktur').text(data.no_faktur);
                    $('.tgl-faktur').text(data.tgl_faktur);
                    $('.tgl-terima').text(data.tgl_terima);
                    $('.tgl-selesai').text(data.tgl_selesai);
                    $('.status').html(data.status == 1 ? '<span class="badge badge-success">Qualified</span>' :
                        '<span class="badge badge-danger">Not Qualified</span>');
                    $('.teknisi').text(data.teknisi);
                    $('.keterangan').text(data.keterangan);
                    $('.btn[onclick="downloadData()"]').attr('onclick', 'downloadData(' + data.id + ')');


                    $.each(data.detail_uji_fungsi, function(index, item) {
                        var check = item.status == 1 ? '<span class="badge badge-success">Check</span>' :
                            '<span class="badge badge-danger">Not Checked</span>';
                        var dokumentasi = item.foto ? '<a href="/storage/foto_dokumentasiQC/' + item.foto +
                            '" target="_blank"><img src="/storage/foto_dokumentasiQC/' + item.foto +
                            '" alt="Dokumentasi" style="width: 50px; height: 50px;"></a>' : '-';
                        $('#detail-data-uji-fungsi tbody').append(
                            '<tr><td>' + (index + 1) + '</td><td>' + item.item + '</td><td>' + item.qty + '</td><td>' + check + '</td><td>' +
                            dokumentasi + '</td></tr>');
                    });

                    return $('#detail-data-uji-fungsi').DataTable({
                        processing: true,
                        serverSide: false,
                        responsive: true,
                        searching: false,
                        ordering: false,
                        paging: false,
                        info: false,
                        columns: [{
                                data: 'no',
                                name: 'no'
                            },
                            {
                                data: 'item',
                                name: 'item'
                            },
                            {
                                data: 'qty',
                                name: 'qty'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'dokumentasi',
                                name: 'dokumentasi'
                            }
                        ]
                    });


                },
                error: function() {
                    alert('Oops! Something error!');
                }
            });
        }

        function filter() {
            var filter = $('#filter').val();
            console.log(filter);
            table.draw();
        }

        table = $('#tabel-uji-fungsi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    window.location.href = "{{ route('data-uji-fungsi.create') }}";
                }
            }],
            ajax: {
                url: "{{ route('data-uji-fungsi.index') }}",
                type: 'GET',
                data: function(data) {
                    data.filter = $('#filter').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'no_seri',
                    name: 'no_seri'
                },
                {
                    data: 'no_order',
                    name: 'no_order'
                },
                {
                    data: 'no_faktur',
                    name: 'no_faktur'
                },
                {
                    data: 'tgl_faktur',
                    name: 'tgl_faktur'
                },
                {
                    data: 'tgl_terima',
                    name: 'tgl_terima'
                },
                {
                    data: 'tgl_selesai',
                    name: 'tgl_selesai'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-green">Qualified</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-danger">Not Qualified</span>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        function downloadData(id) {
            if (id) {
                window.location.href = "{{ url('data-uji-fungsi/generate-pdf') }}/" + id;
            } else {
                alert('ID tidak ditemukan!');
            }
        }
    </script>
@endsection
