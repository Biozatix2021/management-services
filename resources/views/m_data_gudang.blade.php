@extends('layouts.layout-main-v2')

@section('title', 'Warehouse Data')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Gudang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Gudang</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Gudang</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="data-tables">
                        <table id="tabelGudang" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Nama Gudang</th>
                                    <th>Nama Kontak</th>
                                    <th>Telepon</th>
                                    <th>Total Product</th>
                                    <th width="20px">Status</th>
                                    <th width="10px">Action</th>
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

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="modalTambahData">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Gudang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form id="formTambahDataGudang">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Gudang</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Gudang" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_person">Nama Kontak</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Nama Kontak" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan" onclick="save_data()">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- Modal Edit Data -->
    <div class="modal fade" id="modalEditData">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Gudang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="formEditDataGudang" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Nama Gudang</label>
                            <input type="text" class="form-control" id="editName" name="editName" placeholder="Nama Gudang" required value="">
                        </div>
                        <div class="form-group">
                            <label for="contact_person">Nama Kontak</label>
                            <input type="text" class="form-control" id="editContact_person" name="editContact_person" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="text" class="form-control" id="editPhone" name="editPhone" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="editStatus" name="editStatus" value="">
                                <option value="">Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan" onclick="update_data()">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $('#tabelGudang').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            orderable: false,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#formTambahDataGudang')[0].reset();
                    $('#modalTambahData').modal('show');
                }
            }],
            ajax: "{{ route('gudang.index') }}",
            columns: [{
                    "data": null,
                    "bDestroy": true,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_person',
                    name: 'contact_person'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'total_produk',
                    name: 'total_produk'
                },
                {
                    data: 'status',
                    name: 'status',

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
            var form = $('#formTambahDataGudang')[0];
            var formData = new FormData(form);

            console.log('Ok');

            $.ajax({
                type: 'POST',
                url: "{{ route('gudang.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('Menyimpan...');
                },
                success: function(data) {
                    $('#formTambahDataGudang')[0].reset();
                    $('#modalTambahData').modal('hide');
                    $('#tabelGudang').DataTable().ajax.reload();
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
                type: 'GET',
                url: "{{ url('gudang') }}" + '/' + id + "/edit",
                success: function(data) {
                    $('#modalEditData').modal('show');
                    $('#id').val(data.id);
                    $('#editName').val(data.name);
                    $('#editContact_person').val(data.contact_person);
                    $('#editPhone').val(data.phone);
                    $('#editStatus').val(data.status == 1 ? 'active' : 'inactive').trigger('change');
                    console.log(data.status);
                }
            });
        }

        function update_data() {
            let id = $('#id').val();
            let name = $('#editName').val();
            let contact_person = $('#editContact_person').val();
            let phone = $('#editPhone').val();
            let status = $('#editStatus').val();

            $.ajax({
                type: 'PUT',
                url: "gudang/" + id,
                data: {
                    id: id,
                    name: name,
                    contact_person: contact_person,
                    phone: phone,
                    status: status
                },
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('Menyimpan...');
                },
                success: function(data) {
                    // $('#modalEditData').modal('hide');
                    $('#tabelGudang').DataTable().ajax.reload();
                    // toastr.success('Data berhasil diupdate');
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                },
                error: function(data) {
                    console.log(data);
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                    toastr.error('Data gagal diupdate');
                }
            });
        }

        function delete_data(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('gudang') }}" + '/' + id,
                        success: function(data) {
                            $('#tabelGudang').DataTable().ajax.reload();
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
