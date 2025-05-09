@extends('layouts.layout-main-v2')

@section('title', 'Pengaturan')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Pengaturan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="save_data()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="pengaturan" name="pengaturan" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" placeholder="Masukkan Nama Perusahaan"
                                        value="{{ $data->nama_perusahaan }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" id="logo_perusahaan " onchange="previewImage(event)"
                                                name="logo_perusahaan" accept="image/*" required>
                                            <label class="custom-file-label" for="logo_perusahaan">Choose file</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="product-image-thumb">
                                    <img id="image-logo" src="{{ asset('img/app-icon.' . ($data->logo_extension ?? 'png')) }}" alt="Image" />
                                    <img id="preview" src="#" alt="Preview Image" style="display: none" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon">
                                        Prefix URL
                                        <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="top"
                                            title="Prefix URL digunakan untuk menentukan awalan URL pada aplikasi"></i>
                                    </label>
                                    <input type="text" class="form-control" id="prefix_url" name="prefix_url" placeholder="Masukkan Prefix URL"
                                        value="{{ $data->prefix_url }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div> <!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('scripts')
    <script>
        function previewImage(event) {
            document.getElementById('image-logo').style.display = 'none';
            var element = 'preview';
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById(element);
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);

            var fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerHTML = fileName;


        }

        function save_data() {
            var form = $('#pengaturan')[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('pengaturan.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.success('Data berhasil disimpan');
                    window.location.reload();
                },
                error: function(data) {
                    toastr.error(data.responseJSON.text);
                    console.log('Error:', data);
                }
            });
        }
    </script>
@endsection
