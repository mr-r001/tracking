@extends('admin.layouts.master') @section('title', 'Data Customer')
@section('css')
<link
    rel="stylesheet"
    href="{{ asset('backend/modules/select2/dist/css/select2.min.css') }}"
/>
<link
    href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css"
    rel="stylesheet"
/>
@endsection @section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Customer</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.customer.index') }}">
                        <i class="fa fa-users"></i>
                        Data Customer
                    </a>
                </div>
                <div class="breadcrumb-item">
                    <i class="fa fa-plus-circle"></i>
                    Tambah Data
                </div>
            </div>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('admin.customer.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Data</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-danger" id="valid-type">
                                    {{ $errors->first('type') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="nama"
                                                >Nama<sup class="text-danger"
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                                name="nama"
                                                id="nama"
                                                value="{{ old('nama') }}"
                                                placeholder="Masukkan Nama"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                id="valid-nama"
                                            >
                                                {{ $errors->first('nama') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat"
                                                >Alamat<sup class="text-danger"
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                                                name="alamat"
                                                id="alamat"
                                                value="{{ old('alamat') }}"
                                                placeholder="Masukkan Alamat"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                id="valid-alamat"
                                            >
                                                {{ $errors->first('alamat') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="handphone"
                                                >No. Handphone<sup class="text-danger"
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control form-control-sm @error('handphone') is-invalid @enderror"
                                                name="handphone"
                                                id="handphone"
                                                value="{{ old('handphone') }}"
                                                placeholder="Masukkan No.Handphone"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                id="valid-handphone"
                                            >
                                                {{ $errors->first('alamhandphoneat') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="tgl_beli"
                                                >Tanggal Beli<sup
                                                    class="text-danger"
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                type="date"
                                                class="form-control form-control-sm @error('tgl_beli') is-invalid @enderror"
                                                name="tgl_beli"
                                                id="tgl_beli"
                                                value="{{
                                                    old('tgl_beli')
                                                }}"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                id="valid-tgl_beli"
                                            >
                                                {{ $errors->first('tgl_beli') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-round float-right"
                                            id="btn-submit"
                                        >
                                            <i class="fas fa-check"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection @section('js')
<script src="{{
        asset('backend/modules/select2/dist/js/select2.full.min.js')
    }}"></script>
<script src="{{
        asset('backend/modules/summernote/summernote-bs4.js')
    }}"></script>
<script src="{{ asset('backend/js/jquery.mask.min.js') }}"></script>
<script src="{{
        asset('backend/modules/sweetalert/sweetalert.min.js')
    }}"></script>
<script>
    $(document).ready(function () {
        // Setup AJAX CSRF
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    });
</script>
@endsection
