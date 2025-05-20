@extends('layouts.layout-main-v2')

@section('title', 'Produk')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Produk</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk</h3>
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
                    <form id="form-tambah-data" name="form-tambah-data" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_produk" id="id_produk">
                        <div class="form-group">
                            <label for="kode_produk">No Katalog</label>
                            <input type="text" class="form-control" id="catalog_number" name="catalog_number" placeholder="Masukkan Kode Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Masukkan Harga" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($perusahaans as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary mr-2" id="btn-simpan" onclick="save_data()">Simpan</button>
                        <button type="button" class="btn btn-default" id="btn-reset">Reset</button>
                    </div>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Produk</h3>
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
                        <table id="tabelProduk" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10">No</th>
                                    <th>No Katalog</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Distributor</th>
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
    <!-- /.row -->

    <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modal-produk-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-produk-label">Filter Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="input-group" style="width: 100%; margin: 0 auto; margin-bottom: 10px;">
                            {{-- make select option --}}
                            <select id="filter" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                <option value="">Pilih Alat</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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


        table = $('#tabelProduk').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<i class="fa fa-filter" aria-hidden="true"></i> Filter',
                className: 'btn btn-default btn-sm',
                action: function(e, dt, node, config) {
                    $('#modal-filter').modal('show');
                }
            }],
            pageLength: 25,
            ajax: {
                url: "{{ route('product.index') }}",
                type: "GET",
                data: function(data) {}
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
                    data: 'catalog_number',
                    name: 'catalog_number'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price',
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(data);
                        }
                        return data;
                    }
                },
                {
                    data: 'supplier.nama',
                    name: 'supplier.nama'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        function save_data() {
            var formData = new FormData($('#form-tambah-data')[0]);
            $.ajax({
                url: "{{ route('product.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.overlay').show();
                },
                complete: function() {
                    $('.overlay').hide();
                },
                success: function(data) {
                    toastr.success('Data berhasil disimpan', 'Sukses');
                    table.ajax.reload();
                    $('#form-tambah-data')[0].reset();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON.message,
                    });
                }
            });
        }
    </script>

@endsection
