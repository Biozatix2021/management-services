@extends('layouts.layout-main-v2')

@section('title', 'Data Garansi')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Garansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Garansi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Garansi</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelGaransi" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>ID Garansi</th>
                                    <th>Nama <br> Garansi</th>
                                    <th>Durasi <br> Aktif</th>
                                    <th>Penyedia</th>
                                    <th width="20px">Aksi</th>
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
    <!-- /.row -->

    <!-- Modal Tambah Data Perusahaan -->
    <div class="modal fade" id="modal-tambah-data" tabindex="-1" role="dialog" aria-labelledby="tambah-data-perusahaan" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-data" name="form-tambah-data" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="IDGaransi">ID garansi</label>
                                <input type="text" class="form-control" id="IDGaransi" name="IDGaransi" required readonly>
                            </div>
                            <div class="col-md-8">
                                <label for="nama_garansi">Nama Garansi</label>
                                <input type="text" class="form-control" id="nama_garansi" name="nama_garansi" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="durasi">Masa Aktif</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control text-center" id="durasi" name="durasi" required value="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="durasi">Penyedia</label>
                                <div class="input-group" style="width: 100%">
                                    <select class="form-control" id="penyedia" name="penyedia" required>
                                        <option value="">-- Pilih Penyedia --</option>
                                        <option value="PT Biozatix Indonesia">PT Biozatix Indonesia</option>
                                        <option value="PT Vantagebio Scientific Solution">PT Vantagebio Scientific Solution</option>
                                        <option value="PT Flexylabs Instrument Indonesia">PT Flexylabs Instrument Indonesia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan_tambahan">Catatan Tambahan</label>
                            <textarea class="textarea" placeholder="Catatan Tambahan" id="catatan_tambahan" name="catatan_tambahan"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btn-simpan" onclick="save_data()">Simpan</button>
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

        $('#nama_garansi').on('input', function() {
            var namaGaransi = $(this).val();
            var idGaransi = namaGaransi.toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-').substring(0, 20);
            $('#IDGaransi').val(idGaransi);
        });

        // $(function() {
        //     //bootstrap WYSIHTML5 - text editor
        //     $('.textarea2').wysihtml5()
        // })

        $('#biaya').on('input', function() {
            var value = $(this).val().replace(/,/g, '');
            if (!isNaN(value) && value !== '') {
                $(this).val(parseFloat(value).toLocaleString('en'));
            } else {
                $(this).val(0);
            }
        });

        $('#durasi').on('input', function() {
            var value = $(this).val();
            if (value < 0) {
                $(this).val(0);
            }
        });

        function save_data() {
            var data = new FormData($('#form-tambah-data')[0]);
            data.append('catatan_tambahan', $('.textarea').val());
            $.ajax({
                type: 'POST',
                url: "{{ route('data-garansi.store') }}",
                data: data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('Menyimpan...');
                },
                success: function(data) {
                    $('#form-tambah-data')[0].reset();
                    $('#modal-tambah-data').modal('hide');
                    $('#tabelGaransi').DataTable().ajax.reload();
                    toastr.success('Data berhasil disimpan');
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                },
                error: function(data) {
                    console.log(data);
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                    toastr.error('Data gagal disimpan');
                }
            });
        }

        function edit_data(id) {
            $.ajax({
                url: "{{ url('data-garansi') }}" + '/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#modal-tambah-data').modal('show');
                    $('#IDGaransi').val(data.ID_garansi);
                    $('#nama_garansi').val(data.nama_garansi);
                    $('#durasi').val(data.durasi);
                    $('#penyedia').val(data.penyedia);
                    // $('#catatan_tambahan').val(data.catatan_tambahan);
                    $('#catatan_tambahan').summernote('code', data.catatan_tambahan);
                },
                error: function(data) {
                    console.log(data);
                    toastr.error('Data gagal diambil');
                }
            });
        }

        $('#tabelGaransi').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-data')[0].reset();
                    $('#modal-tambah-data').modal('show');
                }
            }],
            LengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            ajax: {
                url: "{{ route('data-garansi.index') }}",
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
                    data: 'ID_garansi',
                    name: 'ID_garansi',
                },
                {
                    data: 'nama_garansi',
                    name: 'nama_garansi'
                },
                {
                    data: 'durasi',
                    render: function(data, type, row) {
                        return data + ' Tahun';
                    },
                    name: 'durasi'
                },
                {
                    data: 'penyedia',
                    name: 'penyedia'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function delete_data(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('data-garansi') }}" + '/' + id,
                        dataType: 'JSON',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },

                        success: function(data) {
                            $('#tabelGaransi').DataTable().ajax.reload();
                            toastr.success('Data berhasil dihapus');
                        },
                        error: function(data) {
                            console.log(data);
                            toastr.error('Data gagal dihapus');
                        }
                    });
                }
            })
        }
    </script>
@endsection
