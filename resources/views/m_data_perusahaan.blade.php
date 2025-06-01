@extends('layouts.layout-main-v2')

@section('title', 'Data Perusahaan')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Perusahaan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Perusahaan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Perusahaan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabel-data-perusahaan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Nama</th>
                                    <th>Logo</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th width="20px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Modal Tambah Data Perusahaan -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <!-- Modal Tambah Data Perusahaan -->
    <div class="modal fade" id="tambah-data-perusahaan" tabindex="-1" role="dialog" aria-labelledby="tambah-data-perusahaan" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tambah-data-perusahaan">Tambah Data Perusahaan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-data-perusahaan" name="form-tambah-data-perusahaan" enctype="multipart/form-data" accept="image/*" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo Perusahaan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" onchange="previewImage(event)" id="logo" name="logo"
                                        accept="image/*" required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                            <img id="preview" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">Telepon</label>
                            <input type="text" class="form-control" id="telp" name="telp" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control" id="website" name="website" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times"></i> Cancel</button>
                        <button type="button" onclick="save_data()" class="btn btn-primary" id="btn-simpan"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.Modal Tambah Data Perusahaan end -->
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

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');

                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);

            var fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerHTML = fileName;
        }

        table = $('#tabel-data-perusahaan').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-data-perusahaan')[0].reset();
                    $('#preview').attr('src', '#');
                    $('#preview').css('display', 'none');
                    $('.custom-file-label').html('Choose file');
                    $('#tambah-data-perusahaan').modal('show');
                }
            }],
            ajax: "{{ route('perusahaan.index') }}",
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
                }, {
                    data: 'logo',
                    name: 'logo'
                }, {
                    data: 'alamat',
                    name: 'alamat'
                }, {
                    data: 'telp',
                    name: 'telp'
                }, {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'website',
                    name: 'website'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        function save_data() {
            var form = $('#form-tambah-data-perusahaan')[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('perusahaan.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-simpan').html('Saving ...');
                    $('#btn-simpan').attr('disabled', true);
                },
                complete: function() {
                    $('#btn-simpan').html('<i class="fas fa-save"></i> Save');
                    $('#btn-simpan').attr('disabled', false);
                    $('#form-tambah-data-perusahaan')[0].reset();
                    $('#preview').attr('src', '#');
                    $('#preview').css('display', 'none');
                    $('.custom-file-label').html('Choose file');
                    $('#tambah-data-perusahaan').modal('hide');
                },
                success: function(data) {
                    toastr.success('Data berhasil disimpan');
                    table.ajax.reload();
                    $('#form-tambah-data-perusahaan')[0].reset();
                },
                error: function(data) {
                    toastr.error(data.responseJSON.text);
                    console.log('Error:', data);
                }
            });
        }

        function delete_data(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('perusahaan/delete') }}" + '/' + id,
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
