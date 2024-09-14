@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'work farmer')

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault(); // ป้องกันการทำงานของลิงก์

                    // รวบรวมข้อมูลจาก attributes
                    const userId = this.getAttribute('data-id');
                    const farmerName = this.getAttribute('data-farmer_name');
                    const quantity = this.getAttribute('data-quantity');
                    const orderId = this.getAttribute('data-order_id');
                    const status = this.getAttribute('data-status');
                    const orderDeadline = this.getAttribute('data-order_deadline');
                    const orderlistId = this.getAttribute('data-orderlist');
                    const productId = this.getAttribute('data-product_id');
                    const productName = this.getAttribute('data-product_name');
                    const productImage = this.getAttribute('data-product_image');
                    const idWork = this.getAttribute('data-id_work');

                    // สร้าง object ข้อมูลเพื่อส่ง
                    const formData = {
                        user_id: userId,
                        farmer_name: farmerName,
                        quantity: quantity,
                        order_id: orderId,
                        status: status,
                        order_deadline: orderDeadline,
                        orderlist_id: orderlistId,
                        product_id: productId,
                        product_name: productName,
                        product_image: productImage,
                        id_work: idWork
                    };
                    console.log(formData)
                    // ส่งข้อมูลไปยังเซิร์ฟเวอร์ด้วย AJAX
                    fetch('/update_work_farmer', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // ต้องมี CSRF token สำหรับการส่ง POST ใน Laravel
                            },
                            body: JSON.stringify(formData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                            if (data.message === 'Work updated successfully!') {
                                // Reload the current page
                                window.location.reload();

                                // OR you can redirect to another page, for example:
                                // window.location.href = '/some-other-page';
                            } else {
                                // Optionally handle other outcomes or show an error message
                                console.error('An error occurred:', data);
                                alert(
                                    'Failed to update the work details.'
                                    ); // Display a simple alert if the update fails
                            }
                            // Here you can also update the UI as needed if you're not redirecting/reloading
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(
                                'There was a problem with the request.'
                                ); // Provide feedback on any errors encountered during the fetch
                        });
                });
            });
        });
    </script>

@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            @foreach ($data1 as $data)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow">
                        <img src="{{ asset('storage/' . $data->product_image) }}" class="card-img-top"
                            alt="{{ $data->product_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->product_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Farmer: {{ $data->farmer_name }}</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @switch($data->status)
                                    @case('assigned')
                                        <span class="badge bg-warning text-dark">กำลังส่งงาน</span>
                                    @break

                                    @case('in_progress')
                                        <span class="badge bg-success">รับงานที่มอบหมายแล้ว</span>
                                    @break

                                    @case('cancel')
                                        <span class="badge bg-danger">ไม่รับงานที่มอบหมาย</span>
                                    @break

                                    @default
                                        <span class="badge bg-info">เสร็จงานที่หมอบหมาย</span>
                                @endswitch
                            </div>
                            @if ($data->status == 'cancel')
                                <strong>จำนวน:</strong>
                                <span class="text-warning">{{ $data->quantity }}</span>
                                <div class="mt-1">

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle d-flex justify-content-center"
                                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            เลือกเกษตรกรใหม่
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            @foreach ($data2 as $data2)
                                                <li>
                                                    <a class="dropdown-item" href="#" data-id="{{ $data2->id }}"
                                                        data-farmer_name='{{ $data2->name }}'
                                                        data-quantity="{{ $data->quantity }}"
                                                        data-order_id="{{ $data->order_id }}" data-status='assigned'
                                                        data-order_deadline='{{ $data->order_deadline }}'
                                                        data-orderlist='{{ $data->orderlist_id }}'
                                                        data-product_id='{{ $data->product_id }}'
                                                        data-product_name='{{ $data->product_name }}'
                                                        data-product_image='{{ $data->product_image }}'
                                                        data-id_work='{{ $data->id }}'>

                                                        {{ $data2->name }} จำนวน: {{ $data2->flower_quantity }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            @else
                                <div>
                                    <strong>จำนวน:</strong>
                                    <span class="text-warning">{{ $data->quantity }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer text-muted">
                            Deadline: {{ $data->order_deadline }}

                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
