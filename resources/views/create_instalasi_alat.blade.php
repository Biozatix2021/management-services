@extends('layouts.layout-main-v2')

@section('title', 'Instalasi Alat')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Instalasi Alat</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Instalasi Alat</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Instalasi Alat</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan" onclick="save_data()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="instalasiAlat" name="instalasiAlat" enctype="multipart/form-data" method="POST" action="{{ route('instalasi-alat.store') }}">
                        {{-- CSRF Token --}}
                        @csrf
                        {{-- Header start --}}
                        <div class="box-header with-border">
                            <h3 class="box-title"></h3>
                        </div>

                        {{-- Header end --}}

                        <!-- /.Body start -->
                        <div class="box-body" style="overflow-y: auto; overflow-x:hidden; max-height: 920px;">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="nama_alat">Nama Alat</label>
                                    <select name="alat_Id" id="alat_Id" class="form-control select2bs4"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                        <option value="">Pilih Alat</option>
                                        @foreach ($alats as $item)
                                            <option value="{{ $item->id }}">{{ $item->catalog_number }} - {{ $item->nama }} - {{ $item->tipe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="nama">Nomor Seri</label>
                                    <input type="text" class="form-control" id="inputNoSeri" name="no_seri" placeholder="Masukkan No Seri Alat">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="status_instalasi">Status Instalasi</label>
                                    <select name="statusInstalasi" id="statusInstalasi" class="form-control">
                                        <option value="">Pilih Status Instalasi</option>
                                        <option value="KSO">KSO</option>
                                        <option value="BELI">BELI</option>
                                        <option value="TRIAL">TRIAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="lokasi">Lokasi Instalasi</label>
                                    <select name="rumah_sakit_id" id="rumah_sakit_id" class="form-control"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                        <option value="">Pilih Lokasi Instalasi</option>
                                        @foreach ($rumah_sakits as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="perusahaan">Instansi</label>
                                    <select name="perusahaan_id" id="perusahaan" class="form-control">
                                        <option value="">Pilih Instansi</option>
                                        @foreach ($perusahaans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tgl_instalasi">Tanggal Instalasi</label>
                                    <input type="date" name="tgl_instalasi" id="tgl_instalasi" class="form-control"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="garansi">Tipe Garansi</label>
                                    <select name="garansi" id="garansi" class="form-control select2bs4"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                        <option value="">Pilih Tipe Garansi</option>
                                        @foreach ($garansis as $item)
                                            <option value="{{ $item->ID_garansi }}">{{ $item->nama_garansi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="no_garansi">Aktif Garansi</label>
                                    <input type="date" name="aktif_garansi" id="aktif_garansi" class="form-control"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                </div>
                                <div class="col-md-4">
                                    <label for="no_garansi">Habis Garansi</label>
                                    <input type="date" name="habis_garansi" id="habis_garansi" class="form-control"
                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                </div>
                            </div>
                            <hr style="border: 1px solid; margin: 20px 0;">
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-12">
                                    <table id="teknisiTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="w-10">#</th>
                                                <th>Tambahkan Teknisi</th>
                                                <th class="w-10">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <select name="teknisi[]" id="teknisi" class="form-control"
                                                        style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                                        <option value="">Pilih Teknisi</option>
                                                        @foreach ($teknisis as $item)
                                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" id="addTeknisiRow"><i class="fa fa-plus"
                                                            aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr style="border: 1px solid; margin: 20px 0;">
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-12">
                                    <table id="FotoTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="w-10">#</th>
                                                <th>Tambahkan Dokumentasi <br>
                                                    <p style="color: red">*Maksimal 3 Foto</p>
                                                </th>
                                                <th class="w-10">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    @php
                                                        $itemId = 1; // Initialize itemId here
                                                    @endphp
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="foto_instalasi"
                                                                onchange="previewImage(event, '{{ $itemId }}')" name="foto_instalasi[]" accept="image/*" required>
                                                            <label class="custom-file-label" for="file">Choose file</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="filename_foto_instalasi[{{ $itemId }}]"
                                                        id="filename_foto_instalasi[{{ $itemId }}]">
                                                    {{-- <input type="text" name="foto_item[]" id="foto_item[1]" value=""> --}}
                                                    <img id="preview-1" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" id="addFotoRow"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr style="border: 1px solid; margin: 20px 0;">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12">
                                    <table id="LampiranTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10px">#</th>
                                                <th>Nama Lampiran</th>
                                                <th>Dokumen Pendukung</th>
                                                <th class="w-10">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <select name="nama_lampiran[]" id="nama_lampiran" class="form-control select2bs4" style="border-radius: 7px;">
                                                        <option value="">Pilih Lampiran</option>
                                                        <option value="Berita Acara Instalasi">BA Instalasi</option>
                                                        <option value="Berita Acara Serah Terima">BA Serah Terima</option>
                                                        <option value="Berita Acara Uji Fungsi">BA Uji Fungsi</option>
                                                        <option value="Berita Acara Training">BA Training</option>
                                                        <option value="Delivery Order">Delivery Order</option>
                                                        <option value="Invoice">Invoice</option>
                                                        <option value="SPK">SPK</option>
                                                        <option value="PO/PKS">PO/PKS</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="file_lampiran" onchange="previewImage(event)"
                                                            name="file_lampiran[]" accept=".pdf" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                    {{-- <input type="file" name="file_lampiran[]" id="file_lampiran" class="form-control" accept=".pdf" multiple
                                                        onchange="UploadLampiran(event, 1)"> --}}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" id="addLampiranRow"><i class="fa fa-plus"
                                                            aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var uploadFile = 0;
        var ItemIndex = 0;
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#alat_Id').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Alat",
                allowClear: true
            });
        });

        $('#inputNoSeri').on('input', function() {
            clearTimeout($(this).data('timer'));
            var wait = setTimeout(validateNoSeri, 500); // 500ms delay
            $(this).data('timer', wait);
        });

        function validateNoSeri() {
            var noSeri = $('#inputNoSeri').val();
            if (noSeri.length > 0) {
                $.ajax({
                    url: "{{ route('validate-no-seri') }}",
                    type: 'GET',
                    data: {
                        no_seri: noSeri
                    },
                    success: function(response) {
                        console.log(response);
                        if (response === true) {
                            $('#inputNoSeri').removeClass('is-invalid').addClass('is-valid');
                            $('#inputNoSeri').next('.help-block').removeClass('text-danger').addClass('text-success').text('Nomor seri valid.');
                        } else if (response === false) {
                            $('#inputNoSeri').removeClass('is-valid').addClass('is-invalid');
                            $('#inputNoSeri').next('.help-block').addClass('text-danger').text('Nomor seri tidak valid.');
                            Swal.fire({
                                title: 'Nomor Seri Harus Sesuai Dengan Barang Dari Gudang',
                                text: 'Silakan masukkan nomor seri yang benar.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            $('#inputNoSeri').removeClass('is-valid is-invalid');
                            $('#inputNoSeri').next('.help-block').addClass('text-danger').text('Harap tunggu... Hubungi administrator jika masalah berlanjut.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#inputNoSeri').removeClass('is-valid is-invalid');
                $('#inputNoSeri').next('.help-block').text('');
            }
        }

        // function previewImage(event) {
        //     var reader = new FileReader();
        //     reader.onload = function() {
        //         var output = document.getElementById('preview');
        //         output.src = reader.result;
        //         output.style.display = 'block';
        //     }
        //     reader.readAsDataURL(event.target.files[0]);
        // }


        $(document).on('click', '.teknisi-item', function() {
            var id = $(this).data('id');
            var name = $(this).text();
            $('#teknisi_id').val(id);
            $('#teknisi_search').val(name);
            $('#teknisi_results').hide();
        });

        $(document).on('click', '#addTeknisiRow', function() {
            $('#teknisiTable tbody').append(
                '<tr><td>' + ($('#teknisiTable tbody tr').length + 1) + '</td>' +
                '<td><select name="teknisi[]" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">' +
                '<option value="">Pilih Teknisi</option>' +
                '@foreach ($teknisis as $item)' +
                '<option value="{{ $item->nama }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select></td>' +
                '<td><button type="button" class="btn btn-danger removeTeknisiRow"><i class="fa fa-trash"></i></button></td></tr>');
        });

        $(document).on('click', '#addFotoRow', function() {
            var itemId = $('#FotoTable tbody tr').length + 1; // Define itemId here

            $('#FotoTable tbody').append(
                '<tr><td>' + ($('#FotoTable tbody tr').length + 1) + '</td> ' +
                '<td>' +
                `<div class="input-group">` +
                `<div class="custom-file">` +
                `<input type="file" class="custom-file-input" id="foto_instalasi[${itemId}]" onchange="previewImage(event, '${itemId}')" name="foto_instalasi[]" accept="image/*" required>` +
                `<label class="custom-file-label" for="file">Choose file</label>` +
                `</div>` +
                `</div>` +
                `<input type="hidden" name="filename_foto_instalasi[${itemId}]" id="filename_foto_instalasi[${itemId}]">` +
                // `<td><input type="file" name="foto_instalasi[]" id="foto_instalasi[${itemId}]" class="form-control" accept="image/*" multiple onchange="previewImage(event, '${itemId}')" >` +
                // `<input type="hidden" class="form-control" name="filename_foto_instalasi[]" id="filename_foto_instalasi[${itemId}]" value="">` +
                `<img id="preview-${itemId}" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;"></td>` +
                '<td><button type="button" class="btn btn-danger removeFotoRow"><i class="fa fa-trash"></i></button></td></tr>');
        });

        $(document).on('click', '#addLampiranRow', function() {
            var FileId = $('#LampiranTable tbody tr').length + 1; // Define FileId here
            $('#LampiranTable tbody').append(
                `<tr> <td> ${FileId}</td>` +
                '<td><select name="nama_lampiran[]" id="nama_lampiran" class="form-control" style="border-radius: 7px;">' +
                '<option value = "" > Pilih Lampiran </option>' +
                '<option value="Berita Acara Instalasi">BA Instalasi</option>' +
                '<option value="Berita Acara Serah Terima">BA Serah Terima</option>' +
                '<option value="Berita Acara Uji Fungsi">BA Uji Fungsi</option>' +
                '<option value="Berita Acara Training">BA Training</option>' +
                '<option value="Delivery Order">Delivery Order</option>' +
                '<option value="Invoice">Invoice</option>' +
                '<option value="SPK">SPK</option>' +
                '<option value="PO/PKS">PO/PKS</option>' +
                '<option value="Lainnya">Lainnya</option>' +
                '</select></td>' +
                `<td><input type="file" name="file_lampiran[]" id="lampiran[${FileId}]" class="form-control" accept=".pdf" multiple onchange="UploadLampiran(event, '${FileId}')"></td>` +
                '<td><button type="button" class="btn btn-danger removeLampiranRow" id="removeLampiranRow"><i class="fa fa-trash"></i></button></td></tr>'
            );
        });

        $(document).on('click', '.removeLampiranRow', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.removeTeknisiRow', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.removeFotoRow', function() {
            $(this).closest('tr').remove();
        });

        function previewImage(event, itemId) {
            var element = 'preview-' + itemId;
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById(element);
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);

            console.log(event);
            var fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerHTML = fileName;

            var formData = new FormData();
            formData.append('foto_instalasi', event.target.files[0]);
            formData.append('item_id', itemId);

            $.ajax({
                url: "{{ route('upload-foto') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // set id foto_item value
                    $('#filename_foto_instalasi\\[' + itemId + '\\]').val(response.foto);
                    console.log(response);
                    uploadFile++;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function getAlat(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('get-alat') }}/" + id,
                dataType: "json",
                success: function(response) {
                    $('#no_seri').empty();
                    $('#no_seri').append('<option value="">Pilih No Seri Alat</option>');
                    $.each(response, function(key, value) {
                        $('#no_seri').append('<option value="' + value.no_seri + '">' + value.no_seri + '</option>');
                    });
                }
            });
        }

        function save_data() {
            var form = $('#instalasiAlat')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('instalasi-alat.store') }}",
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('Menyimpan...');
                },
                success: function(response) {
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                    toastr.success('Data berhasil disimpan!');
                    window.location.href = "{{ route('instalasi-alat.index') }}";
                },
                error: function(xhr, status, error) {
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                    toastr.error(xhr.responseJSON.text);
                }
            });
        }
    </script>
@endsection
