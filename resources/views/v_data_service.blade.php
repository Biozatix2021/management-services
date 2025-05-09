@extends('layouts.layout-main-v2')

@section('title', 'Services')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Perbaikan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Perbaikan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Perbaikan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelService" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10">No</th>
                                    <th width="30">S/N</th>
                                    <th>Nama Alat</th>
                                    <th>Keluhan</th>
                                    <th>Tanggal <br> Perbaikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-footer -->
                </div>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#tabelService').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                    className: 'btn btn-primary btn-sm',
                    action: function(e, dt, node, config) {
                        // $('#form-tambah-alat')[0].reset();
                        window.location.href = "{{ route('services.create') }}";
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
            ajax: "{{ route('services.index') }}",
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
                    data: 'keluhan',
                    name: 'keluhan'
                },
                {
                    data: 'service_date',
                    name: 'service_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endsection
