@extends('layouts.layout-main-v2')

@section('title', 'Detail Services')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detail Services</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Services</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="/services" class="btn btn-primary btn-block mb-3">Kembali</a>
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="/storage/alat/{{ $data->alat->gambar }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $data->alat->merk }} {{ $data->alat->nama }}</h3>

                    <p class="text-muted text-center">{{ $data->alat->tipe }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Kode Instalasi</b> <a class="float-right">{{ $data->service_code }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>S/N</b> <a class="float-right">{{ $data->no_seri }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tipe Perbaikan</b> <a class="float-right"><b>{{ $data->service_type }}</b></a>
                        </li>
                        <li class="list-group-item">
                            <b>Awal Perbaikan</b> <a class="float-right"> {{ date('d M. Y', strtotime($data->service_start_date)) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Selesai Perbaikan</b> <a class="float-right"> {{ date('d M. Y', strtotime($data->service_end_date)) }}</a>
                        </li>
                        {{-- <li class="list-group-item">
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
                    </ul> --}}


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Detail Perbaikan</h3>

                    <div class="card-tools">
                        <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h5><b>{{ $data->service_name }}</b></h5>
                        <h6>Kode Perbaikan: <a href="">{{ $data->service_code }}</a>
                            <span class="mailbox-read-time float-right">{{ date('d M. Y', strtotime($data->service_start_date)) }}</span>
                        </h6>
                        <h6>Keluhan : <b>{{ $data->keluhan }}</b></h6>
                    </div>
                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-controls with-border text-center">
                        <p><b>Deskripsi Perbaikan</b></p>
                    </div>
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                        {!! $data->service_description !!}
                    </div>
                    <!-- /.mailbox-read-message -->
                    <div class="mailbox-controls with-border text-center">
                        <p><b>Pergantian Sparepart</b></p>
                    </div>
                    <div class="mailbox-read-message">
                        <p>Sparepart yang diganti : </p>
                        <ul>
                            @foreach ($data->sparepart as $item)
                                <li>{{ $item->nama_sparepart }} (x{{ $item->qty }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-white">
                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                        @foreach ($foto as $item)
                            <li>
                                <span class="mailbox-attachment-icon has-img">
                                    <a href="{{ $item->path }}" data-toggle="lightbox" data-gallery="gallery" target="_blank">
                                        <img src="{{ $item->path }}" class="img-thumbnail mb-2" alt="{{ $item->judul }}"
                                            style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px;">
                                        {{-- </a> --}}
                                </span>
                                <div class="mailbox-attachment-info">
                                    {{-- <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo1.png</a> --}}
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                        {{-- <span>2.67 MB</span> --}}
                                        <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                        @foreach ($lampiran as $item)
                            <li>
                                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a href="{{ $item->lampiran_path }}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{ $item->lampiran_name }}</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                        <span>{{ number_format(filesize(public_path($item->path)) / 1024, 2) }} KB</span>
                                        <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.card-footer -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@section('scripts')
@endsection
