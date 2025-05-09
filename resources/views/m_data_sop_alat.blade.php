@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data SOP Alat
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Sop Alat</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box">
        {{-- Header start --}}
        <div class="box-header with-border">
            <h3 class="box-title"></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        {{-- Header end --}}

        <!-- /.Body start -->
        <div class="box-body">


            <div class="text-center">
                <div class="input-group" style="width: 50%; margin: 0 auto;">
                    {{-- make select option --}}
                    <select id="filter" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                        <option value="">Pilih Alat</option>
                        @foreach ($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->nama }} {{ $alat->type }}</option>
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
                <table id="tabelSOP" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Item Check</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.Body end -->

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambah-data-sop-alat">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form-tambah-sop-alat" name="form-tambah-sop-alat">
                                @csrf
                                <div class="form-group">
                                    <div id="input-container">
                                        <select class="form-control me-2" name="alat_id" id="alat_id" style="margin-bottom: 5px">
                                            <option value="">Pilih Alat</option>
                                            @foreach ($alats as $alat)
                                                <option value="{{ $alat->id }}">{{ $alat->nama }} {{ $alat->type }}</option>
                                            @endforeach
                                        </select>
                                        <hr>
                                        <div class="form-group ">
                                            <label for="item">Item Check</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="item[]" placeholder="Enter item check">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" id="add-input">Add Item</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="btn-simpan-sop-alat" onclick="save_data()">Simpan</button>
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

            $(document).ready(function() {
                $('#add-input').click(function() {
                    $('#input-container').append(`
                    <div class="form-group">
                        <label for="item">Item Check</label>
                        <div class="input-group" margin: 0 auto;">
                            <input type="text" class="form-control" name="item[]" placeholder="Enter item check">
                        <div class="input-group-btn">
                        <button type="button" class="btn btn-danger remove-input" style="color: white;"><i class="fa fa-minus"></i></button>
                    </div>
                    `);
                });

                $('#input-container').on('click', '.remove-input', function() {
                    $(this).parent().parent().remove();
                });
            });

            function save_data() {
                var form = $('#form-tambah-sop-alat')[0];
                var formData = new FormData(form);

                console.log(form);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('sop-alat.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#tambah-data-sop-alat').modal('hide');
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


            table = $('#tabelSOP').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                    text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                    className: 'btn btn-primary btn-sm',
                    action: function(e, dt, node, config) {
                        // $('#form-tambah-alat')[0].reset();
                        $('#tambah-data-sop-alat').modal('show');
                    }
                }],
                ajax: {
                    url: "{{ route('sop-alat.index') }}",
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        </script>
    @endsection
