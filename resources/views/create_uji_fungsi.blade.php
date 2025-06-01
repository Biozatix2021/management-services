@extends('layouts.layout-main-v2')

@section('title', 'Uji Fungsi')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Uji Fungsi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Uji Fungsi</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <form id="form-tambah-uji-fungsi" name="form-tambah-uji-fungsi">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="input-group" style="width: 50%;margin: 0 auto; margin-bottom: 10px;">
                                {{-- make select option --}}
                                <select id="alat_id" name="alat_id" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                                    <option value="" selected>Pilih Alat</option>
                                    @foreach ($alats as $alat)
                                        <option value="{{ $alat->id }}">{{ $alat->merk }} {{ $alat->nama }} {{ $alat->tipe }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-secondary" style="background-color: #3c8dbc; color:white" onclick="filter()">Terapkan</button>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Instalasi Alat</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body" style="min-height: 300px">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th width="20px">Qty</th>
                                    <th width="15px">Check</th>
                                    <th width="35%">Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td colspan="4" class="text-center">Pilih alat terlebih dahulu</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="loader" style="display: none; text-align: center;">
                            <img src="{{ asset('img/spinner.gif') }}" style="width: 90px" alt="Loading..." />
                        </div>
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-block btn-primary" id="btn-lanjut" style="display: none; margin-top: 10px;"
                                onclick="document.getElementById('data-uji-fungsi').scrollIntoView();">Lanjut</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Data Instalasi Alat</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body" id="data-uji-fungsi">
                        <div class="form-group">
                            <label for="nama">Nomor Seri</label>
                            <input type="text" class="form-control" id="inputNoSeri" name="no_seri" placeholder="Masukkan No Seri Alat">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="nama">No Order</label>
                            <input type="text" class="form-control" id="inputLokasi" name="no_order" placeholder="Masukkan Lokasi Alat">
                        </div>
                        <div class="form-group">
                            <label for="nama">No Faktur</label>
                            <input type="text" class="form-control" id="inputKondisi" name="no_faktur" placeholder="Masukkan Kondisi Alat">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Faktur</label>
                            <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur">

                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Terima</label>

                            <input type="date" class="form-control" id="tgl_terima" name="tgl_terima">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Selesai</label>
                            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control"
                                style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                        </div>
                        <div class="form-group">
                            <label for="nama">Teknisi</label>
                            <input type="text" name="teknisi" id="teknisi" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;"
                                value="{{ session('name') }}" readonly>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100" style="width: 75%; height:3px"></div>
                        </div>
                        <div class="form-group text-center">
                            <button type="button" onclick="save_data()" id="btn-simpan" class="btn btn-block btn-primary" style="margin-top: 10px;">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var uploadFile = 0;
        var itemIndex = 0;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // Show button id btn-lanjut if open in ratio mobile
        if ($(window).width() <= 768) {
            $('#btn-lanjut').css('display', 'block');
        }




        function filter() {
            var alatId = $('#alat_id').val();
            console.log(alatId);
            $('#loader').show();
            $('#tbody').empty();
            $.ajax({
                url: "{{ route('form-qc') }}",
                type: 'GET',
                data: {
                    alat_id: alatId
                },
                success: function(response) {
                    $('#loader').hide();
                    $.each(response.templates, function(index, item) {
                        $('#tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    <input type="hidden" class="form-control" name="item_check[]" value="${item.item}">
                                    <label for="item" class="col-form-label">${item.item}</label>
                                </td>
                                <td>
                                    <label for="qty" class="col-form-label">${item.qty + item.satuan}</label>
                                    <input type="hidden" class="form-control" name="qty_item[]" value="${item.qty}">
                                    <input type="hidden" class="form-control" name="satuan_item[]" value="${item.satuan}">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" value="" name="checkbox" id="defaultCheck1">
                                </td>
                                <td id="foto[${item.id}]">
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#loader').hide();
                }
            });
        }

        $(document).on('change', '.form-check-input', function() {
            var row = $(this).closest('tr');
            var isChecked = $(this).is(':checked');
            var itemId = itemIndex++;

            if (isChecked) {
                console.log('itemId', itemId);
                row.find('td:last').append(`
                <input type="file" name="foto[${itemId}]" accept="image/*" onchange="previewImage(event, '${itemId}')">
                <input type="hidden" name="foto_item[]" id="foto_item[${itemId}]">
                <img id="preview-${itemId}" src="#" alt="Preview" style="display:none; width: 100px; height: auto; margin-top: 10px;">
                <div class="progress" style="display:none; margin-top: 10px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            `);
            } else {
                row.find('td:last').empty();
            }
        });

        function previewImage(event, itemId) {
            var element = 'preview-' + itemId;
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById(element);
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);

            var formData = new FormData();
            formData.append('foto', event.target.files[0]);
            formData.append('item_id', itemId);

            // alert('Uploading image...');

            $.ajax({
                url: "{{ route('upload-foto-qc') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                processData: false,
                success: function(response) {
                    // set id foto_item value
                    $('#foto_item\\[' + itemId + '\\]').val(response.foto);
                    console.log(response);
                    uploadFile++;
                },
                error: function(xhr) {
                    console.log('Eror', xhr.responseJSON);
                    alert('Error uploading image. Please contact administrator.');
                }
            });
        }

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


        function save_data() {
            var isValid = true;
            var tbodyContent = $('#tbody').html().trim();

            if (tbodyContent === '') {
                alert('Anda belum memilih item uji fungsi.');
                return false; // Prevent form submission
            }

            $('.form-check-input').each(function() {
                if (!$(this).is(':checked')) {
                    isValid = false;
                    return false; // Exit the loop
                }
            });

            if (!isValid) {
                alert('Please check all items before saving.');
                return false; // Prevent form submission
            }

            // count $('#foto_item') length
            var fotoItemLength = $('input[name^="foto_item"]').length;
            if (fotoItemLength !== uploadFile) {
                alert('Please wait until all images are uploaded.');
                return false; // Prevent form submission
            }

            // define form serialize
            var formData = $('#form-tambah-uji-fungsi').serialize();

            $.ajax({
                url: "{{ route('data-uji-fungsi.store') }}",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        alert('Data berhasil disimpan.');
                        window.location.href = "{{ route('data-uji-fungsi.index') }}";
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.text);
                    toastr.error(xhr.responseJSON.text);

                }
            });
        }
    </script>
@endsection
