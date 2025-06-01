@extends('layouts.layout-main-v2')

@section('title', 'Stock Transfer')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Riwayat Stock Transfer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Stock Transfer</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Stock Transfer</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createTransferModal">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="stockTransferTable" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Asal Gudang</th>
                                    <th>Tujuan Gudang</th>
                                    <th>Produk</th>
                                    <th>QTY Transfer</th>
                                    <th>SN Transfer</th>
                                    <th>Tanggal Transfer</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.modal create transfer -->
    <div class="modal fade" id="createTransferModal" tabindex="-1" role="dialog" aria-labelledby="createTransferModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTransferModalLabel"><i class="fas fa-exchange-alt"></i> Tambah Stock Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createTransferForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="from_warehouse">Asal Gudang</label>
                                    <select class="form-control" id="from_warehouse" name="from_warehouse" required>
                                        <option value=""></option>
                                        @foreach ($warehouses as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="to_warehouse">Tujuan Gudang</label>
                                    <select class="form-control" id="to_warehouse" name="to_warehouse" required>
                                        <option value=""></option>
                                        @foreach ($warehouses as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product">Produk</label>
                            <select class="form-control" id="product" name="product" required>
                                <option value="">Pilih Produk</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->alat->catalog_number }} - {{ $item->alat->nama }} {{ $item->alat->tipe }}</option>
                                @endforeach
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="Masukkan Qty" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="searchProduk" onclick="apply_qty()">Apply</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Jumlah stok yang akan ditambahkan.</small>
                        </div>
                        <div class="form-group">
                            <label for="sn">SN</label>
                            <div id="sn-dynamic-inputs">
                                <input type="text" class="form-control sn-static-inputs" id="sn" placeholder="Masukkan SN" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="transfer_date">Keterangan</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="save_data()">Simpan</button>
                    </div>
                </form>
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

            $('#from_warehouse').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Gudang Asal",
                allowClear: true
            });
            $('#to_warehouse').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Gudang Tujuan",
                allowClear: true
            });

            $('#product').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Produk",
                allowClear: true
            });
        });

        table = $('#stockTransferTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                [50, 100, 200, -1],
                [50, 100, 200, "All"]
            ],
            ajax: {
                url: "{{ url('stock-transfer') }}",
                type: 'GET'
            },
            columns: [{
                    "data": null,
                    "bDestroy": true,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    },
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'from_warehouse.name',
                    name: 'from_warehouse.name',
                    searchable: false,
                },
                {
                    data: 'to_warehouse.name',
                    name: 'to_warehouse.name',
                    searchable: false,
                },
                {
                    data: 'product',
                    name: 'product',
                    // searchable: false,
                },
                {
                    data: 'qty_transfer',
                    name: 'qty_transfer',
                    // searchable: false,
                },
                {
                    data: 'SN',
                    name: 'SN',
                },
                {
                    data: 'transfer_date',
                    name: 'transfer_date',
                    searchable: false,
                },
                {
                    data: 'description',
                    name: 'description',
                    // searchable: false,
                }
            ],
            ordering: [
                [0, 'asc']
            ],
        });

        function apply_qty() {
            let qty = $('#qty').val();

            if (qty && qty > 0) {
                let snInputs = '';
                for (let i = 1; i <= qty; i++) {
                    snInputs += `<input type="text" class="form-control mt-2" name="sn_list[]" placeholder="SN ke-${i}" required>`;
                }
                $('#sn').closest('.form-group').find('.sn-static-inputs').remove();
                $('#sn-dynamic-inputs').closest('.form-group').append(snInputs);
            } else {
                alert('Masukkan Qty yang valid.');
            }
        }

        function save_data() {
            let formData = new FormData($('#createTransferForm')[0]);

            $.ajax({
                url: "{{ url('stock-transfer/store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#createTransferModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Stock transfer berhasil ditambahkan.',
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                    });
                }
            });
        }
    </script>
@endsection
