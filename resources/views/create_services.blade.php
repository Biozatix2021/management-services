@extends('layouts.layout-main-v2')

@section('title', 'Serives')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Services</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Services</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" id="btn-simpan" onclick="save_data()">Simpan</button>
                    </div>
                </div>
                <form id="form-service" name="form-service" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="nama_servis">Title</label>
                                <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="nama_alat">Nama Alat</label>
                                <select name="alat_Id" id="alat_Id" class="form-control select2" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;"
                                    onchange="getAlat(this.value)">
                                    <option value="">Pilih Alat</option>
                                    @foreach ($alats as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="sn">SN</label>
                                <select name="no_seri" id="no_seri" class="form-control">
                                    <option value="">Anda Belum Memilih Alat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="status_instalasi">Tipe Perbaikan</label>
                                <select name="service_type" id="service_type" class="form-control">
                                    <option value="">Pilih Tipe Perbaikan</option>
                                    <option value="Kumulatif Maintenance">Kumulatif Maintenance</option>
                                    <option value="Preventif Maintenance">Corrective Maintenance</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="service_start_date">Awal Perbaikan</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="service_start_date" name="service_start_date" placeholder="Tanggal Perbaikan" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="service_end_date">Akhir Perbaikan</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="service_end_date" name="service_end_date" placeholder="Tanggal Perbaikan" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="teknisi_id">Teknisi</label>
                                <input type="text" class="form-control" id="teknisi_id" name="teknisi_id" value="{{ session('name') }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="perusahaan_id">Instansi</label>
                                <select name="perusahaan_id" id="perusahaan_id" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                    <option value="">Pilih Instansi</option>
                                    @foreach ($perusahaans as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="keluhan">Keluhan</label>
                                <input type="text" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="deskripsi">Deskripsi Tindakan</label>
                                <textarea class="textarea" placeholder="Catatan Tambahan" id="service_description" name="service_description"
                                    style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                        <hr style="border: 1px solid; margin: 20px 0;">
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-12">
                                <table id="sparepart" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="10px">#</th>
                                            <th>Nama Sparepart</th>
                                            <th>Jumlah</th>
                                            <th class="w-10">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sparepartBody">
                                        @php
                                            $itemId = 0; // Initialize itemId here
                                        @endphp
                                        <tr id="sparepartRow0">
                                            <td>1</td>
                                            <td><input type="text" class="form-control" name="nama_sparepart[]" placeholder="Nama Sparepart"></td>
                                            <td><input type="number" class="form-control" name="jumlah_sparepart[]" placeholder="Jumlah"></td>
                                            <td><button type="button" class="btn btn-success" id="addSparepartRow"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr style="border: 1px solid; margin: 20px 0;">
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-12">
                                <table id="FotoTable" class="table table-bordered">
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
                                                        <input type="file" class="custom-file-input" id="foto_services"
                                                            onchange="previewImage(event, '{{ $itemId }}')" name="foto_services" accept="image/*" required>
                                                        <label class="custom-file-label" for="file">Choose file</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="filename_foto_instalasi[{{ $itemId }}]"
                                                    id="filename_foto_instalasi[{{ $itemId }}]">
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-primary progress-bar-striped" id="progress-bar[{{ $itemId }}]" role="progressbar"
                                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        <span class="sr-only">Complete Upload</span>
                                                    </div>
                                                </div>
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
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-12">
                                <table id="LampiranTable" class="table table-bordered">
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
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="file_lampiran" name="file_lampiran[]" accept=".pdf" multiple
                                                            onchange="PreviewLampiran(event)" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success" id="addLampiranRow"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
@endsection

@section('scripts')
    <script>
        var uploadFile = 0;
        var ItemIndex = 0;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $('#alat_Id').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Alat",
            allowClear: true
        });



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

        $(document).on('click', '#addFotoRow', function() {
            var itemId = $('#FotoTable tbody tr').length + 1; // Define itemId here
            $('#FotoTable tbody').append(
                '<tr><td>' + ($('#FotoTable tbody tr').length + 1) + '</td> ' +
                '<td>' +
                `<div class="input-group">` +
                `<div class="custom-file">` +
                `<input type="file" class="custom-file-input" id="foto_services[${itemId}]" onchange="previewImage(event, '${itemId}')" name="foto_services[]" accept="image/*" required>` +
                `<label class="custom-file-label" for="file">Choose file</label>` +
                `</div>` +
                `</div>` +
                `<div class="progress progress-xs">` +
                `<div class="progress-bar bg-primary progress-bar-striped" id="progress-bar[${itemId}]" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">` +
                `<span class="sr-only">Complete Upload</span>` +
                `</div>` +
                `</div>` +
                `<img id="preview-${itemId}" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;"></td>` +
                '<td><button type="button" class="btn btn-danger removeFotoRow"><i class="fa fa-trash"></i></button></td></tr>'
            );
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
                beforeSend: function() {
                    $('#progress-bar\\[' + itemId + '\\]').css('width', '0%').attr('aria-valuenow', 0).text('0%');
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress-bar\\[' + itemId + '\\]').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(
                                percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
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

        function PreviewLampiran(event, FileId) {
            var fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerHTML = fileName;

            var formData = new FormData();
            formData.append('file_lampiran', event.target.files[0]);
            formData.append('FileId', FileId);
        }

        $(document).on('click', '.removeFotoRow', function() {
            $(this).closest('tr').remove();
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
                `<td><div class="custom-file">
                        <input type="file" class="custom-file-input" id="lampiran[${FileId}]" name="file_lampiran[]" accept=".pdf" multiple onchange="PreviewLampiran(event)" required>
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                </td>` +
                '<td><button type="button" class="btn btn-danger removeLampiranRow" id="removeLampiranRow"><i class="fa fa-trash"></i></button></td></tr>'
            );
        });

        $(document).on('click', '.removeLampiranRow', function() {
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#addSparepartRow', function() {
            ItemIndex++;
            $('#sparepartBody').append(
                '<tr id="sparepartRow' + ItemIndex + '">' +
                '<td>' + (ItemIndex + 1) + '</td>' +
                '<td><input type="text" class="form-control" name="nama_sparepart[]" placeholder="Nama Sparepart"></td>' +
                '<td><input type="number" class="form-control" name="jumlah_sparepart[]" placeholder="Jumlah"></td>' +
                '<td><button type="button" class="btn btn-danger removeSparepartRow"><i class="fa fa-trash"></i></button></td>' +
                '</tr>'
            );
        });

        $(document).on('click', '.removeSparepartRow', function() {
            $(this).closest('tr').remove();
            ItemIndex--;
            $('#sparepartBody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        });

        function save_data() {
            var form = $('#form-service')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('services.store') }}",
                type: "POST",
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
                    // console.log(response);
                    window.location.href = "{{ route('services.index') }}";
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
