@extends('layouts/layoutMaster')

@section('title', 'Logistics Dashboard - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-logistics-dashboard.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-logistics-dashboard.js')
@endsection

@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
        <a href="/dashboard/order" class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class='ti ti-shopping-cart-up ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{ $orderCount }}</h4>
                    </div>
                    <p class="m-1">คำสั่งซื้อทั้งหมด</p>
                </div>
            </div>
        </a>

        <a href="/dashboard/quantity" class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class='ti ti-flower ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{ $totalFlowerQuantity }}</h4>
                    </div>
                    <p class="mb-1">จำนวนดอกไม้ที่สามารถรับได้ทั้งหมด</p>

                </div>
            </div>
        </a>
        <a href="/show_order_cencel" class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-danger"><i class='ti ti-x ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{ $cancelOrderCount }}</h4>
                    </div>
                    <p class="mb-1">คำสั่งซื้อที่ปฎิเสธทั้งหมด</p>

                </div>
            </div>
        </a>
        <a href="/dashboard/sendWork" class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-info"><i
                                    class='ti ti-rosette-discount-check ti-28px'></i></span>
                        </div>
                        <h4 class="mb-0">{{ $orderSuccess }}</h4>
                    </div>
                    <p class="mb-1">จำนวนคำสั่งซื้อที่พร้อมส่ง</p>

                </div>
            </div>
        </a>
        <div class="col-xxl-12">
            <div class="card-body co" style="background-color: white;"> <!-- กำหนดพื้นหลังเป็นสีขาว -->
                <div class="table-responsive">
                    <table class="table" style="background-color: white;"> <!-- กำหนดพื้นหลังสีขาวให้กับ table -->
                        <caption>List of users</caption>
                        <thead>
                            <tr>
                                <th scope="col">Number</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">สร้างบัญชีเมื่อ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userlist as $data_user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <!-- ใช้ $loop->iteration เพื่อสร้างลำดับ -->
                                    <td>{{ $data_user->name }}</td>

                                    <td>
                                        @if ($data_user->status == 'admin')
                                            <span class="badge bg-label-primary">Admin</span>
                                        @elseif($data_user->status == 'farmer')
                                            <span class="badge bg-label-success">Farmer</span>
                                        @else
                                            <span class="badge bg-label-warning">Customer</span>
                                        @endif
                                    </td>
                                    <td>{{ $data_user->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    @endsection
