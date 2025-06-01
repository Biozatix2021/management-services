@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detail Instalasi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Instalasi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="/storage/alat/{{ $data->alat->gambar }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $data->alat->merk }} {{ $data->alat->nama }}</h3>

                    <p class="text-muted text-center">{{ $data->alat->tipe }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Kode Instalasi</b> <a class="float-right">{{ $data->kode_instalasi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>S/N</b> <a class="float-right">{{ $data->no_seri }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status Instalasi</b> <a class="float-right">{{ $data->status_instalasi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status Instalasi</b> <a class="float-right">{{ $data->tanggal_instalasi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tipe Garansi</b> <a class="float-right">{{ $data->tipe_garansi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Aktif</b> <a class="float-right">{{ $data->aktif_garansi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Habis Garansi</b> <a class="float-right">{{ $data->habis_garansi }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Diinstal Oleh</b> <a class="float-right">{{ $data->perusahaan->nama }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Uji Fungsi</b> <a class="float-right btn" onclick="ShowUjiFUngsi({{ $data->id }})"><span class="badge badge-info">Lihat</span></a>
                        </li>
                    </ul>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi Instalasi</strong>

                    <p class="text-muted mb-3">
                        {{ $data->rumah_sakit->nama }} <br>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $data->rumah_sakit->latitude }},{{ $data->rumah_sakit->longitude }}" class="text-white"
                            target="_blank"><span class="badge badge-danger">Lihat Lokasi</span></a> </span>
                    </p>

                    <hr>

                    <strong><i class="fas fa-user"></i> Teknisi</strong>

                    <p class="text-muted mb-3">
                        @foreach ($teknisi as $item)
                            @php
                                $colors = ['primary', 'secondary', 'success', 'warning', 'info', 'dark'];
                                $randomColor = $colors[array_rand($colors)];
                            @endphp
                            <span class="badge badge-{{ $randomColor }}">{{ $item }}</span>
                        @endforeach
                    </p>

                    <hr>

                    <strong><i class="fas fa-file-alt"></i> QR Code</strong>
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $data->qrcode_path) }}" alt="QR Code" class="img-thumbnail">
                        <a href="{{ route('download-qrcode', ['id' => $data->id]) }}" class="btn btn-secondary mt-3"><i class="fas fa-download"></i> Unduh QR Code</a>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#lampiran" data-toggle="tab">Lampiran</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane" id="lampiran">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-center"><b>Dokumentasi Foto</b></h4>
                                    @foreach ($foto_instalasi as $foto)
                                        <a href="{{ asset('storage/' . $foto->path) }}" data-toggle="lightbox" data-gallery="gallery" target="_blank">
                                            <img src="{{ asset('storage/' . $foto->path) }}" class="img-thumbnail mb-2" alt="{{ $foto->judul }}"
                                                style="height: 150px; width: 25%; object-fit: cover; display: inline-block; margin-right: 10px;">
                                        </a>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <h4 class="text-center"><b>File Lampiran</b></h4>
                                    @foreach ($lampiran as $file)
                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                                            <div class="thumbnail-box" tabindex="0">
                                                <img class="thumbnail-image" src="{{ asset('img/pdf-thumbnail.png') }}"
                                                    style="height:120px; width: auto; object-fit:fill; display: inline-block; margin-right: 10px;" />
                                                <div class="file-label" title="mountain.jpg">{{ $file->nama_dokumen }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="active tab-pane" id="activity">
                            <!-- The timeline -->
                            <div class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                @foreach ($services as $item)
                                    <div class="time-label">
                                        <span class="bg-danger">
                                            {{ date('d M. Y', strtotime($item->created_at)) }}
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->

                                    <div>
                                        <i class="fas fa-tools bg-primary"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                            <h3 class="timeline-header"><a href="#">{{ $item->service_type }}</a> </h3>

                                            <div class="timeline-body">
                                                <b>Keluhan:</b> {{ $item->keluhan }} <br>
                                                {!! Str::limit($item->service_description, 300) !!} <br>

                                            </div>
                                            <div class="timeline-footer">
                                                <a href="{{ route('services.show', encrypt($data->id)) }}" class="btn btn-primary btn-sm">Read more</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- END timeline item -->
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>

                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

    <div class="modal fade" id="detail-uji-fungsi" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetModalContent()">
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#alat_id').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Alat",
                allowClear: true
            });
        });

        function ShowUjiFUngsi(id) {
            // console.log(id)
            $.ajax({
                url: "{{ url('get-uji-fungsi') }}" + '/' + id,
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
                    $('.nama-alat').text(data.alat.merk + ' ' + data.alat.tipe);
                    $('.text-muted.text-center').text(data.alat.nama);
                    $('.no_seri').text(data.no_seri);
                    $('.no-order').text(data.no_order);
                    $('.no-faktur').text(data.no_faktur);
                    $('.tgl-faktur').text(data.tgl_faktur);
                    $('.tgl-terima').text(data.tgl_terima);
                    $('.tgl-selesai').text(data.tgl_selesai);
                    $('.status').html(data.status == 1 ? '<span class="badge badge-success">Qualified</span>' :
                        '<span class="badge badge-danger">Not Qualified</span>');
                    $('.teknisi').text(data.teknisi.nama);
                    $('.keterangan').text(data.keterangan);


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




                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function resetModalContent() {
            $('#detail-data-uji-fungsi tbody').empty();
            $('#detail-data-uji-fungsi').DataTable().destroy();
            $('.img-alat').attr('src', '');
            $('.nama-alat').text('');
            $('.text-muted.text-center').text('');
            $('.no_seri').text('');
            $('.no-order').text('');
            $('.no-faktur').text('');
            $('.tgl-faktur').text('');
            $('.tgl-terima').text('');
            $('.tgl-selesai').text('');
            $('.status').html('');
            $('.teknisi').text('');
            $('.keterangan').text('');
        }
    </script>
@endsection
