@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Instalasi Alat</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Instalasi Alat</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Instalasi Alat</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelInstalasi" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>SN</th>
                                    <th>Nama Alat</th>
                                    <th>Status Instalasi</th>
                                    <th>Teknisi</th>
                                    <th>Lokasi</th>
                                    <th>Instansi</th>
                                    <th width="20px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    {{-- Modal Filter --}}

    <div class="modal modal-filter" id="modal-filter" tabindex="-1">
        <div class="modal-dialog ">
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
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_filter()">Terapkan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Filter --}}

    {{-- Start Modal Detail --}}
    <div class="modal fade modal-detail" id="modal-overlay modal-detail">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- End Modal Detail --}}
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

        function add_filter() {
            var status_instalasi = $('#status_instalasi').val();
            var perusahaan = $('#perusahaan').val();
            table.draw();
        }

        table = $('#tabelInstalasi').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                    className: 'btn btn-primary btn-sm',
                    action: function(e, dt, node, config) {
                        // $('#form-tambah-alat')[0].reset();
                        window.location.href = "{{ route('instalasi-alat.create') }}";
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
                url: "{{ route('instalasi-alat.index') }}",
                type: "GET",
                data: function(d) {
                    d.status_instalasi = $('#status_instalasi').val();
                    d.perusahaan = $('#perusahaan').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_seri',
                    name: 'no_seri'
                },
                {
                    data: function(row) {
                        return row.alat.merk + ' ' + row.alat.nama;
                    },
                },
                {
                    data: 'status_instalasi',
                    name: 'status_instalasi'
                },
                {
                    data: 'teknisi',
                    name: 'teknisi',
                },
                {
                    data: 'rumah_sakit.nama',
                    name: 'rumah_sakit.nama',
                },
                {
                    data: 'perusahaan.nama',
                    name: 'perusahaan.nama',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function ShowDetail(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('instalasi-alat') }}" + '/' + id,
                success: function(data) {
                    $('.modal-detail').modal('show');
                    $('.overlay').remove(); // Remove overlay after data is fully loaded
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        function delete_data(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('instalasi-alat') }}" + '/' + id,
                    success: function(data) {
                        table.ajax.reload();
                        toastr.success('Data berhasil dihapus');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        toastr.error('Data gagal dihapus');
                    }
                });
            }
        }
    </script>
@endsection
