@extends('layouts.layout-main-v2')

@section('title', 'Penjadwalan')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Penjadwalan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Penjadwalan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Penjadwalan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelPenjadwalan" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Title</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Teknisi</th>
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

    <div class="modal modal-tambah-data" id="modal-tambah-data" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
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
                        <div class="row">
                            <div class="col-md-6 " style="padding-right: 10px;">
                                <label for="start">Start</label>
                                <input type="datetime-local" class="form-control" id="start" name="start" placeholder="Masukkan Tanggal Mulai Acara">
                            </div>
                            <div class="row" style="padding-right: 0px; padding-left: 10px;">
                                <label for="start">End</label>
                                <input type="datetime-local" class="form-control" id="end" name="end" placeholder="Masukkan Tanggal Mulai Acara">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="save_data()">Terapkan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-filter" id="modal-filter" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <form id="form-filter">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="filter">Status Instalasi</label>
                                    <select name="status_instalasi" id="status_instalasi" class="form-control select2" style="width: 100%; border-radius: 7px;">
                                        <option value="">Semua</option>
                                        <option value="KSO">KSO</option>
                                        <option value="BELI">BELI</option>
                                        <option value="TRIAL">TRIAL</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="filter">Perusahaan</label>
                                    <select name="perusahaan" id="perusahaan" class="form-control select2" style="width: 100%;">
                                        <option value="">Pilih Perusahaan</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_filter()">Terapkan</button>
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

        table = $('#tabelPenjadwalan').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                    className: 'btn btn-primary btn-sm',
                    action: function(e, dt, node, config) {
                        // $('#form-tambah-alat')[0].reset();
                        $('#modal-tambah-data').modal('show');
                    }
                },
                {
                    text: '<i class="fa fa-filter" aria-hidden="true"></i> Filter',
                    className: 'btn btn-default btn-sm',
                    action: function(e, dt, node, config) {
                        $('#modal-filter').modal('show');
                    }
                }
            ],
            ajax: {
                url: "{{ route('penjadwalan.index') }}",
                type: "GET",
                data: function(d) {
                    // d.status_instalasi = $('#status_instalasi').val();
                    // d.perusahaan = $('#perusahaan').val();
                }
            },
            columns: [{
                    "data": null,
                    "bDestroy": true,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'start',
                    name: 'start'
                },
                {
                    data: 'end',
                    name: 'end'
                },
                {
                    data: 'teknisi.nama',
                    name: 'teknisi'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        function save_data() {
            var formData = new FormData($('#form-tambah-data')[0]);
            $.ajax({
                url: "{{ route('penjadwalan.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#form-tambah-data')[0].reset();
                    $('#modal-tambah-data').modal('hide');
                    table.ajax.reload(null, false);
                    toastr.success(data.message, 'Berhasil!');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(reset(responseText.text), 'Gagal!');
                }
            });
        }

        function delete_data(id) {
            if (confirm("Are you sure you want to delete this data?")) {
                $.ajax({
                    url: "{{ url('penjadwalan') }}" + '/' + id,
                    type: "DELETE",
                    success: function(data) {
                        toastr.error('Data Berhasil Dihapus');
                        $('#tabelPenjadwalan').DataTable().ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    </script>


@endsection
