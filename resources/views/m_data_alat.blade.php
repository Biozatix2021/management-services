@extends('layouts.layout-main-v2')

@section('title', 'Data Alat')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Alat</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Alat</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Alat</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelAlat" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Brand</th>
                                    <th>Type</th>
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
    <!-- Modal Tambah Data Alat -->
    <div class="modal fade" id="tambah-data-alat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-alat" name="form-tambah-alat" class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ route('alat.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="catalog_number" class="col-sm-2 col-form-label">No Catalog</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="catalog_number" name="catalog_number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNamaAlat" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputNamaAlat" name="nama_alat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNamaAlat" class="col-sm-2 col-form-label">brand</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputbrandAlat" name="brand">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTipeAlat" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputTipeAlat" name="tipe">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <img id="preview" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="margin-right: 10px">Cancel</button>
                    <div id="loader" style="display: none;">
                        <img src="{{ asset('img/spinner.gif') }}" style="width: 50px" alt="Loading..." />
                    </div>
                    <button type="button" id="tombol-simpan" class="btn btn-primary btn-sm" onclick="save_data()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var table;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#inputStokAwal').on('input', function() {
            if ($(this).val().trim() !== '') {
                $('#satuan').attr('required', true);
            } else {
                $('#satuan').removeAttr('required');
            }
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        table = $('#tabelAlat').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-alat')[0].reset();
                    $('#tambah-data-alat').modal('show');
                }
            }],
            LengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],

            ajax: {
                url: "{{ route('alat.index') }}",
                type: "GET",
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
                    data: 'gambar',
                    name: 'gambar',
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'brand',
                    name: 'brand'
                },
                {
                    data: 'tipe',
                    name: 'tipe'
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
            var form = $('#form-tambah-alat')[0];
            var formData = new FormData(form);

            $('#loader').show();
            $('#tombol-simpan').prop('disabled', true);
            $.ajax({
                url: "{{ route('alat.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    toastr.success('Data Berhasil Disimpan');
                    $('#tabelAlat').DataTable().ajax.reload();
                    $('#tambah-data-alat').modal('hide');
                    $('#loader').hide();
                    $('#tombol-simpan').prop('disabled', false);
                },
                error: function(data) {
                    toastr.error(data.responseJSON.text);
                    console.log('Error:', data);
                    $('#loader').hide();
                    $('#tombol-simpan').prop('disabled', false);
                }
            });
        }

        function delete_data(id) {
            if (confirm("Are you sure you want to delete this data?")) {
                $.ajax({
                    url: "{{ url('alat') }}" + '/' + id,
                    type: "DELETE",
                    success: function(data) {
                        toastr.error('Data Berhasil Dihapus');
                        $('#tabelAlat').DataTable().ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        }

        function show_data(id) {
            $.ajax({
                url: "{{ url('alat') }}" + '/' + id,
                type: "GET",
                success: function(data) {
                    console.log(data[0].item);
                    $('#show-item-sop').html(items);
                    $('#show-sop-alat').modal('show');

                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    </script>
@endsection
