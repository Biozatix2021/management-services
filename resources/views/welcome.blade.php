@extends('layouts.layout-main-v2')

@section('title', 'Dashboard')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    @if (session('role') == 'admin' || session('role') == 'developer' || session('title') == 'manager')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Selamat Datang {{ session('name') }}</h5>
                    Anda login sebagai {{ session('role') }}.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_instalasi_alat }}</h3>

                        <p>Alat Terinstal</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $average_maintenance_duration }}<sup style="font-size: 20px">Hari</sup></h3>

                        <p>Rata-rata Durasi Perbaikan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $teknisi }}</h3>

                        <p>Tim Teknisi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $rumah_sakit }}</h3>

                        <p>Rumah Sakit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hospital-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">

            <div class="card card-primary">
                <div class="card-body p-3">
                    <div class="mb-3 text-center">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                            @if (session('role') == 'user')
                                <div style="display: flex; align-items: center;">
                                    <b>Jadwal Anda</b>
                                </div>
                            @elseif (session('role') == 'admin' || session('role') == 'developer' || session('title') == 'manager')
                                @foreach ($teknisis as $item)
                                    <div style="display: flex; align-items: center;">
                                        <span style="display: inline-block; width: 20px; height: 10px; background-color: {{ $item->color }}; margin-right: 10px;"></span>
                                        <b>{{ $item->nama }}</b>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Maps</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 350px;"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Alert</h3>
                    <div class="card-tools">
                        <a href="{{ url('stock-alat') }}">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($lowStockItems as $item)
                            <li class="item">
                                <div class="product-img">
                                    <img src="/storage/alat/{{ $item->alat->gambar }}" alt="{{ $item->alat->gambar }}" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{ $item->alat->nama }}
                                        <span class="float-right">
                                            In Stock <br> {{ $item->stock }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        #{{ $item->alat->catalog_number }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'title',
                    right: 'today,prev,next'
                },
                aspectRatio: 1,
                height: '400px',
                contentHeight: '100',
                buttonText: {
                    today: 'Today'
                },
                customButtons: {},
                // Change button background color to #2c3e50 after render
                viewDidMount: function() {
                    setTimeout(function() {
                        $('.fc-next-button, .fc-prev-button, .fc-today-button').css({
                            'background-color': '#2c3e50',
                            'border-color': '#2c3e50',
                            'color': '#fff'
                        });
                        $('.fc-header-title').css({
                            'color': '#2c3e50',
                            'font-weight': 'bold'
                        });
                        $('.fc-header-toolbar, .fc-toolbar, .fc-toolbar-ltr').css({
                            'margin-bottom': '0px',

                        });
                    }, 5);
                },
                themeSystem: 'bootstrap',
                events: {!! json_encode($data_event) !!},
                editable: true,
                eventClick: function(info) {
                    var eventObj = info.event;

                    if (eventObj) {
                        Swal.fire({
                            title: eventObj.title,
                            html: `
                    <p><strong>Teknisi:</strong> ${eventObj.extendedProps.teknisi}</p>
                    <p><strong>Fullday:</strong> ${eventObj.extendedProps.fullday ? 'Ya' : 'Tidak'}</p>
                    <p><strong>Start:</strong> ${eventObj.start.toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                    <p><strong>End:</strong> ${eventObj.end ? eventObj.end.toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'N/A'}</p>
                    <p><strong>Keterangan:</strong> ${eventObj.extendedProps.keterangan || 'Tidak ada keterangan'}</p>
                `,
                            icon: 'info',
                            confirmButtonText: 'Tutup'
                        });
                        console.log(eventObj);
                    }
                }
            });
            calendar.render();
        });

        var terinstal = {!! json_encode($location) !!};
        console.log(terinstal);

        $(document).ready(function() {
            $('#map').css('width', '100%');
            $('#map').css('border-radius', '10px');
            $('#map').css('overflow', 'hidden');
        });


        var map = L.map('map').setView([-1.7893, 113.9213], 5); // Set view to Indonesia's geographical center
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        var markers = [];
        var markerGroup = L.layerGroup().addTo(map);
        terinstal.forEach(function(item) {
            var marker = L.marker([item.latitude, item.longitude]).addTo(markerGroup);
            marker.bindPopup(item.name).openPopup();
            markers.push(marker);
        });
    </script>
@endsection
