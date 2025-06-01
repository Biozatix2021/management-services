@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Stock Alat</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Stock Alat</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 720px">
                <div class="card-header">
                    <h3 class="card-title">Data Stock Alat</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        <a href="" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i>
                        </a>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahDataStockAlat">
                            <i class="fas fa-plus"></i> Tambah Stock
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelStockAlat" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>No. Katalog</th>
                                    <th>Brand</th>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <!-- Modal Tambah Data Stock Alat -->
    <div class="modal fade" id="modalTambahDataStockAlat" role="dialog" aria-labelledby="modalTambahDataStockAlatLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataStockAlatLabel">Tambah Data Stock Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahDataStockAlat" method="POST" action="{{ route('stock-alat.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stock_id">Pilih Alat</label>
                            <select class="form-control select2" name="alat_id" id="alat_id" required style="width: 100%;">
                                <option value=""></option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->catalog_number }} - {{ $item->nama }} {{ $item->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="warehouse_id">Pilih Gudang</label>
                                    <select class="form-control select2" name="warehouse_id" id="warehouse_id" required>
                                        <option value=""></option>
                                        @foreach ($warehouses as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="qty" id="qty" placeholder="Masukkan Qty" required
                                            aria-describedby="button-addon4">
                                        <div class="input-group-append" id="button-addon4">
                                            <select name="unit" id="unit" class="form-control" required>
                                                <option value="">Pilih Satuan</option>
                                                <option value="pcs">pcs</option>
                                                <option value="unit">unit</option>
                                                <option value="set">set</option>
                                                <option value="box">box</option>
                                                <option value="roll">roll</option>
                                                <option value="paket">paket</option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" id="searchProduk" onclick="apply_qty()">Apply</button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Jumlah stok yang akan ditambahkan.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit">Low Stock Alert</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="low_stock_alert" id="low_stock_alert" placeholder="Masukkan Low Stock Alert"
                                            aria-describedby="button-addon5">
                                        <div class="input-group-append" id="button-addon5">
                                            <span class="input-group-text">Unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sn">SN</label>
                            <div id="sn-dynamic-inputs">
                                <input type="text" class="form-control sn-static-inputs" id="sn" placeholder="Masukkan SN" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pemilik">Pemilik</label>
                                    <select name="perusahaan_id" id="perusahaan_id" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach ($perusahaan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tgl_masuk" id="tgl_masuk" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" required onchange="otherStatus(this)">
                                        <option value="">Pilih Status Alat</option>
                                        <option value="Ready">Ready</option>
                                        <option value="Dalam Pengerjaan">Dalam Pengerjaan</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Cacat">Cacat</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <select name="condition" id="condition" class="form-control" required onchange="otherKondisi(this)">
                                        <option value="">Pilih Kondisi Alat</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Butuh Perbaikan</option>
                                        <option value="Rusak Sedang">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tambah Data Stock Alat -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#alat_id').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Alat",
                allowClear: true
            });

            $('#warehouse_id').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Gudang",
                allowClear: true
            });

            $('#perusahaan_id').select2({
                theme: 'bootstrap4',
                placeholder: "Status Pemilik",
                allowClear: true
            });

            $('#tabelStockAlat').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('stock-alat.index') }}",
                columns: [{
                        "data": null,
                        "bDestroy": true,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'alat.catalog_number',
                        name: 'alat.catalog_number'
                    },
                    {
                        data: 'alat.brand',
                        name: 'alat.brand'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: null,
                        name: 'stock',
                        render: function(data, type, row) {
                            return row.stock + ' ' + (row.unit ?? '');
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
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

        function otherStatus(select) {
            if (select.value === 'other') {
                if (!document.getElementById('other-status-input')) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'status';
                    input.id = 'other-status-input';
                    input.className = 'form-control mt-2';
                    input.placeholder = 'Masukkan status lain';
                    select.parentNode.appendChild(input);
                }
            } else {
                const otherInput = document.getElementById('other-status-input');
                if (otherInput) {
                    otherInput.remove();
                }
            }
        }

        function otherKondisi(select) {
            if (select.value === 'Other') {
                if (!document.getElementById('other-kondisi-input')) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'kondisi';
                    input.id = 'other-kondisi-input';
                    input.className = 'form-control mt-2';
                    input.placeholder = 'Masukkan kondisi lain';
                    select.parentNode.appendChild(input);
                }
            } else {
                const otherInput = document.getElementById('other-kondisi-input');
                if (otherInput) {
                    otherInput.remove();
                }
            }
        }

        function save_data() {
            let form = $('#formTambahDataStockAlat')[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('stock-alat.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#modalTambahDataStockAlat').modal('hide');
                    $('#tabelStockAlat').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data Stock Alat berhasil disimpan.',
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
