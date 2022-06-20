@extends('admin.layouts.master')
@section('title', 'Kecamatan')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/modules/datatables/datatables.min.css') }}">
@endsection

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="company-form">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                            <select class="select2 form-control form-control-sm @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten">
                                <option value="" selected disabled>-- Pilih Kabupaten --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('kabupaten') == $city->city_name ? 'selected' : '' }}>{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="valid-kabupaten">{{ $errors->first('kabupaten') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Kecamatan <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Masukkan nama kecamatan..." autocomplete="off">
                            <div class="invalid-feedback" id="valid-name"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Close
                    </button>
                    <button type="button" id="btn-save" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kecamatan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home"></i>
                            Dashboard
                        </a>
                    </div>
                    <div class="breadcrumb-item">
                        <i class="fas fa-map"></i>
                        Kecamatan
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <button class="btn btn-primary ml-auto" id="btn-add">
                            <i class="fas fa-plus-circle"></i>
                            Tambah Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="company-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kabupaten</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('backend/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/modules/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Setup AJAX CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initializing DataTable
            $('#company-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.kecamatan.index') }}',
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'dis_name',
                        name: 'dis_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                buttons: [],
                order: []
            });

            $('#company-table').DataTable().on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Validation on form
            $('body').on('keyup', '#name', function() {
                var test = $(this).val();
                if (test == '') {
                    $(this).removeClass('is-valid is-invalid');
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                }
            });

            // Open Modal to Add new Category
            $('#btn-add').click(function() {
                $('#formModal').modal('show');
                $('.modal-title').html('Tambah Data');
                $('#company-form').trigger('reset');
                $('#btn-save').html('<i class="fas fa-check"></i> Simpan');
                $('#company-form').find('.form-control').removeClass('is-invalid is-valid');
                $('#btn-save').val('save').removeAttr('disabled');
            });

            // Store new company or update company
            $('#btn-save').click(function() {
                var formData = {
                    kabupaten: $('#kabupaten').val(),
                    name: $('#name').val(),
                };

                var state = $('#btn-save').val();
                var type = "POST";
                var ajaxurl = '{{ route('admin.kecamatan.store') }}';
                $('#btn-save').html('<i class="fas fa-cog fa-spin"></i> Saving...').attr("disabled", true);

                if (state == "update") {
                    $('#btn-save').html('<i class="fas fa-cog fa-spin"></i> Updating...').attr("disabled", true);
                    var id = $('#id').val();
                    type = "PUT";
                    ajaxurl = '{{ route('admin.kecamatan.store') }}' + '/' + id;
                }

                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (state == "save") {
                            swal({
                                title: "Berhasil!",
                                text: "Data berhasil ditambahkan",
                                icon: "success",
                                timer: 3000
                            });

                            $('#company-table').DataTable().draw(false);
                            $('#company-table').DataTable().on('draw', function() {
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        } else {
                            swal({
                                title: "Berhasil!",
                                text: "Data berhasil di ubah",
                                icon: "success",
                                timer: 3000
                            });

                            $('#company-table').DataTable().draw(false);
                            $('#company-table').DataTable().on('draw', function() {
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        }

                        $('#formModal').modal('hide');
                    },
                    error: function(data) {
                        try {
                            if (state == "save") {
                                if (data.responseJSON.errors.name) {
                                    $('#name').removeClass('is-valid').addClass('is-invalid');
                                    $('#valid-name').removeClass('valid-feedback').addClass('invalid-feedback');
                                    $('#valid-name').html(data.responseJSON.errors.name);
                                }

                                $('#btn-save').html('<i class="fas fa-check"></i> Save Changes');
                                $('#btn-save').removeAttr('disabled');
                            } else {
                                if (data.responseJSON.errors.name) {
                                    $('#name').removeClass('is-valid').addClass('is-invalid');
                                    $('#valid-name').removeClass('valid-feedback').addClass('invalid-feedback');
                                    $('#valid-name').html(data.responseJSON.errors.name);
                                }

                                $('#btn-save').html('<i class="fas fa-check"></i> Update');
                                $('#btn-save').removeAttr('disabled');
                            }
                        } catch {
                            if (state == "save") {
                                swal({
                                    title: "Maaf!",
                                    text: "Terjadi kesalahan, Silahkan coba lagi",
                                    icon: "error",
                                    timer: 3000
                                });
                            } else {
                                swal({
                                    title: "Maaf!",
                                    text: "Terjadi kesalahan, Silahkan coba lagi",
                                    icon: "error",
                                    timer: 3000
                                });
                            }

                            $('#formModal').modal('hide');
                        }
                    }
                });
            });

            // Edit Category
            $('body').on('click', '#btn-edit', function() {
                var id = $(this).val();
                var name = $(this).data('name');
                $.get('{{ route('admin.kecamatan.index') }}' + '/' + id + '/edit', function(data) {
                    $('#company-form').find('.form-control').removeClass('is-invalid is-valid');
                    $('#id').val(data.id);
                    $('#name').val(data.dis_name);
                    $('#kabupaten').val(data.city_id);
                    $('#btn-save').val('update').removeAttr('disabled');
                    $('#formModal').modal('show');
                    $('.modal-title').html('Edit Data');
                    $('#btn-save').html('<i class="fas fa-check"></i> Edit');
                }).fail(function() {
                    swal({
                        title: "Maaf!",
                        text: "Gagal mengambil Data",
                        icon: "error",
                        timer: 3000
                    });
                });
            });

            // Delete company
            $('body').on('click', '#btn-delete', function(){
                var id = $(this).val();
                var name = $(this).data('name');
                swal("Peringatan!", "Apakah anda yakin?", "warning", {
                    buttons: {
                        cancel: "Tidak!",
                        ok: {
                            text: "Ya!",
                            value: "ok"
                        }
                    },
                }).then((value) => {
                    switch (value) {
                        case "ok" :
                            $.ajax({
                                type: "DELETE",
                                url: '{{ route('admin.kecamatan.store') }}' + '/' + id,
                                success: function(data) {
                                    $('#company-table').DataTable().draw(false);
                                    $('#company-table').DataTable().on('draw', function() {
                                        $('[data-toggle="tooltip"]').tooltip();
                                    });

                                    swal({
                                        title: "Berhasil!",
                                        text: "Data berhasil dihapus",
                                        icon: "success",
                                        timer: 3000
                                    });
                                },
                                error: function(data) {
                                    swal({
                                        title: "Maaf!",
                                        text: "Terjadi kesalahan, Silahkan coba lagi",
                                        icon: "error",
                                        timer: 3000
                                    });
                                }
                            });
                        break;

                        default :
                            swal({
                                title: "Oh Ya!",
                                text: "Data aman, jangan khawatir",
                                icon: "info",
                                timer: 3000
                            });
                        break;
                    }
                });
            });
        });
    </script>
@endsection
