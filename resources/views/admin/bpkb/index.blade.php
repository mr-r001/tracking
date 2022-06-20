@extends('admin.layouts.master')
@section('title', 'Tracking BPKB')

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
                            <label for="customer">Customer</label>
                            <select class="form-control form-control-sm @error('customer') is-invalid @enderror" name="customer" id="customer">
                                <option value="" selected disabled>-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer') == $customer->id ? 'selected' : '' }}>{{ $customer->nama }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="valid-customer">{{ $errors->first('customer') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="" selected disabled>-- Pilih Status --</option>
                                <option value="Data diterima" {{ old('status') == 'Data diterima' ? 'selected' : '' }}>Data diterima</option>
                                <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <div class="invalid-feedback" id="valid-status">{{ $errors->first('status') }}</div>
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
                <h1>Tracking BPKB</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home"></i>
                            Dashboard
                        </a>
                    </div>
                    <div class="breadcrumb-item">
                        <i class="fas fa-truck"></i>
                        Tracking BPKB
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
                            <table class="table table-sm table-hover" id="bpkb-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. Handphone</th>
                                        <th>Tanggal Beli</th>
                                        <th>Status</th>
                                        <th>Ubah Status</th>
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
            $('#bpkb-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.BPKB.index') }}',
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'cust_address',
                        name: 'cust_address'
                    },
                    {
                        data: 'cust_phone',
                        name: 'cust_phone'
                    },
                    {
                        data: 'cust_buy',
                        name: 'cust_buy'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'change',
                        name: 'change'
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

            $('#bpkb-table').DataTable().on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Open Modal to Add new Tracking
            $('#btn-add').click(function() {
                $('#formModal').modal('show');
                $('.modal-title').html('Tambah Data');
                $('#company-form').trigger('reset');
                $('#btn-save').html('<i class="fas fa-check"></i> Simpan');
                $('#company-form').find('.form-control').removeClass('is-invalid is-valid');
                $('#btn-save').val('save').removeAttr('disabled');
            });

            // Store new tracking or update tracking
            $('#btn-save').click(function() {
                var formData = {
                    cust_id: $('#customer').val(),
                    status: $('#status').val(),
                };

                var state = $('#btn-save').val();
                var type = "POST";
                var ajaxurl = '{{ route('admin.BPKB.store') }}';
                $('#btn-save').html('<i class="fas fa-cog fa-spin"></i> Saving...').attr("disabled", true);

                if (state == "update") {
                    $('#btn-save').html('<i class="fas fa-cog fa-spin"></i> Updating...').attr("disabled", true);
                    var id = $('#id').val();
                    type = "PUT";
                    ajaxurl = '{{ route('admin.BPKB.store') }}' + '/' + id;
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

                            $('#bpkb-table').DataTable().draw(false);
                            $('#bpkb-table').DataTable().on('draw', function() {
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        } else {
                            swal({
                                title: "Berhasil!",
                                text: "Data berhasil di ubah",
                                icon: "success",
                                timer: 3000
                            });

                            $('#bpkb-table').DataTable().draw(false);
                            $('#bpkb-table').DataTable().on('draw', function() {
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

            // Edit Tracking
            $('body').on('click', '#btn-edit', function() {
                var id = $(this).val();
                $.get('{{ route('admin.BPKB.index') }}' + '/' + id + '/edit', function(data) {
                    $('#company-form').find('.form-control').removeClass('is-invalid is-valid');
                    $('#id').val(data.id);
                    $('#customer').val(data.cust_id);
                    $('#status').val(data.status);
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

            // Delete Tracking
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
                                url: '{{ route('admin.BPKB.store') }}' + '/' + id,
                                success: function(data) {
                                    $('#bpkb-table').DataTable().draw(false);
                                    $('#bpkb-table').DataTable().on('draw', function() {
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
