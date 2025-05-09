@extends('layouts.layout-main-v2')

@section('title', 'Kalender Teknisi')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-4">
            <h1 class="m-0">Penjadwalan</h1>
        </div><!-- /.col -->
        <div class="col-sm-4">

        </div><!-- /.col -->
        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Penjadwalan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top mb-3">
                {{-- <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Filter Data</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" aria-expanded="false">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-filter-data">
                            @csrf
                            <div class="form-group">
                                <label for="teknisi">Teknisi</label>
                                <select name="teknisi" id="teknisi" class="form-control" style="width: 100%; border-radius: 7px;">
                                    <option value="">Pilih Teknisi</option>
                                    @foreach ($teknisis as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fullday">Fullday</label>
                                <select name="fullday" id="fullday" class="form-control" style="width: 100%; border-radius: 7px;">
                                    <option value="">Pilih Fullday</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 " style="padding-right: 10px;">
                                    <label for="start">Start</label>
                                    <input type="datetime-local" class="form-control" id="start" name="start" placeholder="Masukkan Tanggal Mulai Acara">
                                </div>
                                <div class="col-md-6" style="padding-right: 0px; padding-left: 10px;">
                                    <label for="start">End</label>
                                    <input type="datetime-local" class="form-control" id="end" name="end" placeholder="Masukkan Tanggal Mulai Acara">
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Event</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-tambah-data">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan Nama Acara">
                            </div>
                            <div class="form-group">
                                <label for="teknisi">Teknisi</label>
                                <select name="teknisi" id="teknisi" class="form-control" style="width: 100%; border-radius: 7px;">
                                    <option value="">Pilih Teknisi</option>
                                    @foreach ($teknisis as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fullday">Fullday</label>
                                <select name="fullday" id="fullday" class="form-control" style="width: 100%; border-radius: 7px;">
                                    <option value="">Pilih Fullday</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 " style="padding-right: 10px;">
                                    <label for="start">Start</label>
                                    <input type="datetime-local" class="form-control" id="start" name="start" placeholder="Masukkan Tanggal Mulai Acara">
                                </div>
                                <div class="col-md-6" style="padding-right: 0px; padding-left: 10px;">
                                    <label for="start">End</label>
                                    <input type="datetime-local" class="form-control" id="end" name="end" placeholder="Masukkan Tanggal Mulai Acara">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan Keterangan"></textarea>
                            </div>

                        </form>
                        <button type="button" class="btn btn-primary btn-block" id="btn-simpan" onclick="save_data()"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body p-3">
                    <div class="mb-3 text-center">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                            @foreach ($teknisis as $item)
                                <div style="display: flex; align-items: center;">
                                    <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $item->color }}; margin-right: 10px;"></span>
                                    <b>{{ $item->nama }}</b>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('scripts')
    <script>
        $(function() {

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
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

        function save_data() {
            var formData = new FormData(document.getElementById('form-tambah-data'));
            $.ajax({
                url: "{{ route('penjadwalan.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('Menyimpan...');
                },
                success: function(response) {
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('<i class="fas fa-save"></i> Simpan');
                    $('#form-tambah-data')[0].reset();
                    toastr.success('Data berhasil disimpan!');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('<i class="fas fa-save"></i> Simpan');
                    toastr.error(xhr.responseJSON.text);
                }
            });
        }
    </script>
@endsection
