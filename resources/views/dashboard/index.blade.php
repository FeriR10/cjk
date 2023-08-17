@extends('layouts/main')

@section('title', 'Dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            @if (auth()->user()->role_id == 3 || auth()->user()->role_id == 1)
            <div class="col-md-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp. {{ $total_keuntungan_dealer }} </h3>

                        <p>Total Keuntungan Penjualan Dealer</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book-outline"></i>
                    </div>
                    <a href="/penjualan-dealer-pulsa" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
            @if (auth()->user()->role_id == 4 || auth()->user()->role_id == 1)
            <!-- ./col -->
            <div class="col-md-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp. {{ $total_keuntungan_biller }} </h3>

                        <p>Total Keuntungan Penjualan Biller</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book-outline"></i>
                    </div>
                    <a href="/penjualan-biller-pulsa" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
