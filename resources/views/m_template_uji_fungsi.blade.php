@extends('layouts.layout-main-v2')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Template QC</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Template QC</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Template QC</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <div class="input-group" style="width: 50%; margin: 0 auto;">
                                    {{-- make select option --}}
                                    <select id="filter" class="form-control select2" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                        <option value="">Pilih Alat</option>
                                        @foreach ($alats as $alat)
                                            <option value="{{ $alat->id }}">{{ $alat->brand }}- {{ $alat->nama }} - {{ $alat->tipe }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-secondary" style="background-color: #3c8dbc; color:white" onclick="filter()">Terapkan</button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                            </div>
                            <br>
                            <div class="data-tables">
                                <table id="tabel-uji-fungsi" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="10px">No</th>
                                            <th>Item Check</th>
                                            <th>Qty</th>
                                            <th width="20px">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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
    <div class="modal fade" id="tambah-data-uji-fungsi-alat" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-data-uji-fungsi-alat" name="form-data-uji-fungsi-alat">
                        @csrf
                        <div class="form-group">
                            <div id="input-container">
                                <select class="form-control me-2 select2" name="alat_id" id="alat_id" style="margin-bottom: 5px">
                                    <option value="">Pilih Alat</option>
                                    @foreach ($alats as $alat)
                                        <option value="{{ $alat->id }}">{{ $alat->brand }} {{ $alat->tipe }}</option>
                                    @endforeach
                                </select>
                                <hr>
                                <div class="form-group">
                                    <label for="item">Item Check</label>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="item[]" placeholder="Enter item check">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" name="qty[]" placeholder="Enter qty">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="satuan[]" placeholder="Enter satuan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" id="add-input">Add Item</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-sop-alat" onclick="save_data()">
                        <div id="loader" style="display: none;">
                            <img src="{{ asset('img/spinner.gif') }}" style="width: 50px" alt="Loading..." />
                        </div> Simpan
                    </button>
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

            $('#alat_id').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Alat",
                allowClear: true
            });

            $('#filter').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Alat",
                allowClear: true
            });
        });

        $(document).ready(function() {
            $('#add-input').click(function() {
                $('#input-container').append(`
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="item[]" placeholder="Enter item check" style="margin-right: 5px;">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="qty[]" placeholder="qty" style="margin-right: 5px;">
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                    <input type="text" class="form-control" name="satuan[]" placeholder="Enter Satuan">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove-input" type="button"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            });


            $('#input-container').on('input', 'input[name="qty[]"]', function() {
                if ($(this).val() < 0) {
                    $(this).val(0);
                }
            });


            $('#input-container').on('click', '.remove-input', function() {
                // $(this).parent().parent().remove();
                // all appended input will be removed
                $(this).closest('.form-group').remove();
            });
        });

        function save_data() {
            var form = $('#form-data-uji-fungsi-alat')[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('template-uji-fungsi.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-simpan-sop-alat').attr('disabled', true);
                    $('#loader').show();
                },
                complete: function() {
                    $('#btn-simpan-sop-alat').attr('disabled', false);
                    $('#loader').hide();
                },
                success: function(data) {
                    $('#tambah-data-uji-fungsi-alat').modal('hide');
                    table.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        function filter() {
            var filter = $('#filter').val();
            console.log(filter);
            table.draw();
        }


        table = $('#tabel-uji-fungsi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: '100',
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-data-uji-fungsi-alat')[0].reset();
                    $('#tambah-data-uji-fungsi-alat').modal('show');
                }
            }],
            ajax: {
                url: "{{ route('template-uji-fungsi.index') }}",
                type: 'GET',
                data: function(data) {
                    data.filter = $('#filter').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'item',
                    name: 'item'
                },
                {
                    data: 'qty',
                    render: function(data, type, row) {
                        return data + ' ' + row.satuan;
                    },
                    name: 'qty'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        function delete_data(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: "{{ url('template-uji-fungsi/delete') }}" + '/' + id,
                    type: 'DELETE',
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
