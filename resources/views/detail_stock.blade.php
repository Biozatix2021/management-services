@extends('layouts.layout-main-v2')

@section('title', 'Detail Stock')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detail Stock</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Stock</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Stock</h3>
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
                        <table id="tabelDetailStockAlat" class="table table-bordered table-hover" width="1920px">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Produk</th>
                                    <th>Brand</th>
                                    <th>SN</th>
                                    <th>Pemilik</th>
                                    <th>Status</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Filter -->
    <div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="modalFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilterLabel"><i class="fas fa-filter"></i> Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter">
                        <div class="form-group">
                            <label for="filterProduct">Produk</label>
                            <select class="form-control" id="filterProduct" name="filterProduct">
                                <option value="">Semua Produk</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->alat->catalog_number }} - {{ $item->alat->nama }} {{ $item->alat->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filterBrand">Brand</label>
                            <select class="form-control" id="filterBrand" name="filterBrand">
                                <option value="">Semua Brand</option>
                                @foreach ($brands as $item)
                                    <option value="{{ $item->brand }}">{{ $item->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filterStatus">Status</label>
                            <select class="form-control" id="filterStatus" name="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="Ready">Ready</option>
                                <option value="Dalam Pengerjaan">Dalam Pengerjaan</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Cacat">Cacat</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filterCondition">Kondisi</label>
                            <select class="form-control" id="filterCondition" name="filterCondition">
                                <option value="">Semua Kondisi</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Butuh Perbaikan</option>
                                <option value="Rusak Sedang">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filterWarehouse">Lokasi Gudang</label>
                            <select class="form-control" id="filterWarehouse" name="filterWarehouse">
                                <option value="">Semua Lokasi</option>
                                @foreach ($warehouses as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnApplyFilter" onclick="addFilter()">Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        var table;
        var stock_ref;
        $('#filterProduct').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Alat",
            allowClear: true
        });
        $('#filterBrand').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Brand",
            allowClear: true
        });
        $('#filterWarehouse').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Gudang",
            allowClear: true
        });
        $(document).ready(function() {
            stock_ref = '{{ $request_stock_ref }}';
            table = $('#tabelDetailStockAlat').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [{
                    text: '<i class="fas fa-filter"></i> Filter',
                    className: 'btn btn-warning',
                    action: function(e, dt, node, config) {
                        $('#modalFilter').modal('show');
                    }
                }],
                ajax: {
                    url: "{{ route('detail-stock') }}",
                    type: "GET",
                    dataType: "json",
                    data: function(d) {
                        d.filterProduct = $('#filterProduct').val();
                        d.filterBrand = $('#filterBrand').val();
                        d.filterStatus = $('#filterStatus').val();
                        d.filterCondition = $('#filterCondition').val();
                        d.filterWarehouse = $('#filterWarehouse').val();
                        d.stock_ref = stock_ref;
                        console.log($('#filterProduct').val());
                    }
                },
                columns: [{
                        "data": null,
                        "bDestroy": true,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        },
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'alat.brand',
                        name: 'alat.brand'
                    },
                    {
                        data: 'no_seri',
                        name: 'no_seri'
                    },
                    {
                        data: 'perusahaan.nama',
                        name: 'perusahaan.nama'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'condition',
                        name: 'condition'
                    },
                    {
                        data: 'warehouse.name',
                        name: 'warehouse.name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                ]
            });
        });

        function addFilter() {
            table.draw();
            $('#modalFilter').modal('hide');
        }
    </script>
@endsection
