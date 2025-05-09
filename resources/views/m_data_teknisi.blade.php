@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Teknisi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Teknisi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Teknisi</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelTeknisi" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Warna</th>
                                    <th width="50px">Aksi</th>
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

    <!-- Modal Tambah Data Teknisi -->
    <div class="modal fade" id="tambah-data-teknisi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-alat" name="form-tambah-alat" class="form-horizontal">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" class="form-control" id="id">
                            <label for="inputNamaTeknisi" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNamaTeknisi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNoTelp" class="col-sm-4 col-form-label">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNoTelp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-sm-4 col-form-label">Pilih Warna:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control my-colorpicker1" name="color" id="color" data-color-format="hex" data-color-picker>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" id="tombol-tambah-form" class="btn btn-primary btn-sm" onclick="save_data()">Simpan</button>
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

        //Colorpicker
        $('.my-colorpicker1').colorpicker()

        table = $('#tabelTeknisi').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-alat')[0].reset();
                    $('#tambah-data-teknisi').modal('show');
                }
            }],
            LengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            ajax: {
                url: "{{ route('teknisi.index') }}",
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
                }, {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'color',
                    name: 'color',
                    render: function(data, type, row) {
                        return '<div style="width: 50px; height: 20px; background-color:' + data + ';"></div>';
                    }
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
            var id = $('#id').val();
            var nama = $('#inputNamaTeknisi').val();
            var no_hp = $('#inputNoTelp').val();
            var color = $('#color').val();
            $.ajax({
                url: "{{ route('teknisi.store') }}",
                type: "POST",
                data: {
                    id: id,
                    nama: nama,
                    no_hp: no_hp,
                    color: color
                },
                success: function(data) {
                    $('#tabelTeknisi').DataTable().ajax.reload();
                    $('#tambah-data-teknisi').modal('hide');
                    toastr.success('Data berhasil disimpan');
                },
                error: function(data) {
                    toastr.error(data.responseJSON.text);
                }
            });
        }

        function edit_data(id) {
            $.ajax({
                url: "{{ url('teknisi') }}" + '/' + id + '/edit',
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#tambah-data-teknisi').modal('show');
                    $('#id').val(data.id);
                    $('#inputNamaTeknisi').val(data.nama);
                    $('#inputNoTelp').val(data.no_hp);
                    $('#color').val(data.color);
                    $('.my-colorpicker1').colorpicker('setValue', data.color);
                    toastr.success('Data berhasil diperbaharui');
                },
                error: function(data) {
                    toastr.error('Data gagal diperbaharui');
                }
            });
        }

        function delete_data(id) {
            if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
                $.ajax({
                    url: "{{ url('teknisi') }}" + '/' + id,
                    type: "DELETE",
                    success: function(data) {
                        $('#tabelTeknisi').DataTable().ajax.reload();
                        toastr.success('Data berhasil dihapus');
                    },
                    error: function(data) {
                        toastr.error('Anda tidak dapat menghapus data ini karena data ini digunakan di tempat lain');
                    }
                });
            }
        }
    </script>
@endsection
