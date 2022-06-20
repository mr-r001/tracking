@extends('admin.layouts.master') @section('title', 'Dashboard') @section('css')
<link
    rel="stylesheet"
    href="{{ asset('backend/modules/datatables/datatables.min.css') }}"
/>
@endsection @section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Customer</h4>
                        </div>
                        <div class="card-body">{{ count($customers) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tracking (Data diterima)</h4>
                        </div>
                        <div class="card-body">{{ $diterima }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tracking (Diproses)</h4>
                        </div>
                        <div class="card-body">{{ $diproses }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tracking (Selesai)</h4>
                        </div>
                        <div class="card-body">{{ $selesai }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection @section('js')
<script src="{{
        asset('backend/modules/datatables/datatables.min.js')
    }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".myTable").DataTable();
    });
</script>
@endsection
