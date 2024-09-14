@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Error - Pages')

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection
@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection


@section('content')

    <div class="card-body">
        <!-- Basic Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Order All</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-12 g-6">
        @foreach ($orderAll as $data_orderall)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">
                                <a type="button" class="order-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-idorder="{{ $data_orderall->id }}">
                                    ORDER #{{ 10000 + $data_orderall->id }}
                                </a>
                            </h5>

                        </div>
                        <h6 class="card-subtitle text-muted mb-3">ราคารวม:
                            <span class="text-success">{{ number_format($data_orderall->total_price, 2) }} บาท</span>
                        </h6>
                        <h6 class="card-subtitle text-muted mb-3">จำนวน:
                            <span class="text-warning">{{ $data_orderall->count }}</span>
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    Loading...
                </div>

            </div>
        </div>
    </div>

    <script>
        // ใช้ querySelectorAll เพื่อเลือกทุกปุ่มที่มี class "order-btn"
        const buttons = document.querySelectorAll('.order-btn');

        // เพิ่ม event listener ให้กับทุกปุ่ม
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // ดึงข้อมูลจาก attributes ของปุ่ม
                const orderId = this.getAttribute('data-idorder');

                // เรียกใช้ fetch เพื่อดึงข้อมูลออร์เดอร์
                fetch(`/show_orderlist_model1/${orderId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("orderlist: ", data);
                        const content = data.map(item => {
                            const quantityText = item.type === 'flower' ? 'ดอก' : 'ถาด';
                            return `
                                <div class="container mt-4 d-flex justify-content-center">
                                    <div class="card shadow-sm" style="max-width: 18rem;">
                                        <img src="/storage/${item.image}" class="card-img-top product-image" alt="${item.name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${item.name}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-success fw-bold">฿${item.price}</span>
                                                <span class="text-muted">จำนวน: ${item.quantity} ${quantityText}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }).join('');

                        // แสดงเนื้อหาใน modal
                        document.getElementById('modalContent').innerHTML = content;
                    })
                    .catch(error => {
                        console.error('Error fetching orderlist:', error);
                        document.getElementById('modalContent').innerHTML =
                            '<p>Error loading order details.</p>';
                    });

                // แสดงข้อมูลที่ได้รับใน console
                console.log('Order ID:', orderId);
            });
        });
    </script>
@endsection
