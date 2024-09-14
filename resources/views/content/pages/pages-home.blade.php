@extends('layouts/layoutMaster')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection


@section('content')

    <div class="container-fluid px-0"> <!-- เพิ่ม px-0 เพื่อใช้พื้นที่เต็มที่ -->
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">UI elements /</span> Order
        </h4>

        <div class="row">
            <div class="col-12"> <!-- เปลี่ยนเป็น col-12 เพื่อใช้ความกว้างเต็มที่ -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Order Management</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-4" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-home">
                                    <i class="ti ti-sm me-1"></i> คำสั่งซื้อ
                                    @if (count($key_orders) > 0)
                                        <span class="badge bg-danger ms-2">{{ count($key_orders) }}</span>
                                    @else
                                        <span class="badge bg-success ms-2">0</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-profile">
                                    <i class="ti ti-sm me-1"></i> จ่ายเงิน
                                    @if (count($key_payment) > 0)
                                        <span class="badge bg-danger ms-2">{{ count($key_payment) }}</span>
                                    @else
                                        <span class="badge bg-success ms-2">0</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-messages">
                                    <i class="ti  ti-sm me-1"></i> จ่ายงาน
                                    @if (count($key_work) > 0)
                                        <span class="badge bg-danger ms-2">{{ count($key_work) }}</span>
                                    @else
                                        <span class="badge bg-success ms-2">0</span>
                                    @endif
                                </button>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-home" role="tabpanel">
                                <div class="row g-4">
                                    @foreach ($key_orders as $data_orders)
                                        <div class="col-md-4 col-lg-3 col-xl-2">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="card-title mb-0">
                                                            <a type="button" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#alertModal"> ORDER
                                                                #{{ 10000 + $data_orders->id }}</a>
                                                        </h5>
                                                        <span class="badge bg-success">New</span>
                                                    </div>
                                                    <h6 class="card-subtitle text-muted mb-3">ราคารวม:
                                                        <span class="text-success">{{ $data_orders->total_price }}</span>
                                                    </h6>

                                                    <h6 class="card-subtitle text-muted mb-3">จำนวน:
                                                        <span class="text-warning">{{ $data_orders->count }}</span>
                                                    </h6>
                                                    <div style="font-size: 12px;">
                                                        กำหนดการ</br>{{ $data_orders->created_at }}</br> ถึง
                                                        {{ $data_orders->deadline }}
                                                    </div>
                                                    <br>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-outline-danger btn-sm"
                                                            onclick="updateOrderStatus({{ $data_orders->id }}, 'cancel')">
                                                            Decline
                                                        </button>
                                                        {{-- <button class="btn btn-outline-success btn-sm"
                                                            onclick="updateOrderStatus({{ $data_orders->id }}, 'complete')">
                                                            Accept
                                                        </button> --}}

                                                        <button class="btn btn-outline-success btn-sm accept-order"
                                                            data-bs-toggle="modal" data-bs-target="#alertModal"
                                                            data-order-id-model1="{{ $data_orders->id }}">
                                                            Accept
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-profile" role="tabpanel">
                                <div class="row g-4">
                                    @foreach ($key_payment as $data_payment)
                                        <div class="col-md-4 col-lg-3 col-xl-2">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="card-title mb-0">
                                                            <a type="button" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#alertModal"> ORDER
                                                                #{{ 10000 + $data_payment->id }}</a>
                                                        </h5>
                                                        @if ($data_payment->payment_status == 'pending')
                                                            <span class="badge bg-warning">รอจ่ายเงิน</span>
                                                        @elseif ($data_payment->payment_status == 'paid')
                                                            <span class="badge bg-success">จ่ายเเล้ว</span>
                                                        @elseif ($data_payment->payment_status == 'rejected')
                                                            <span class="badge bg-danger">ปฎิเสธ</span>
                                                        @else
                                                            <span class="badge bg-info">ยอมรับเเล้ว</span>
                                                        @endif
                                                    </div>
                                                    <h6 class="card-subtitle text-muted mb-3">ราคารวม:
                                                        <span class="text-success">{{ $data_payment->total_price }}</span>
                                                    </h6>

                                                    <h6 class="card-subtitle text-muted mb-3">จำนวน:
                                                        <span class="text-warning">{{ $data_payment->count }}</span>
                                                    </h6>
                                                    <div style="font-size: 12px;">
                                                        กำหนดการ</br>{{ $data_payment->created_at }}</br> ถึง
                                                        {{ $data_payment->deadline }}
                                                    </div>
                                                    <br>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        {{-- <button class="btn btn-outline-danger btn-sm"
                                                            onclick="updateOrderStatus({{ $data_payment->id }}, 'cancel')">
                                                            Decline
                                                        </button> --}}
                                                        @switch($data_payment->payment_status)
                                                            @case('pending')
                                                                <span class="text-warning">รอชำระเงิน</span>
                                                            @break

                                                            @case('paid')
                                                                <button class="btn btn-outline-success btn-sm accept-payment"
                                                                    data-bs-toggle="modal" data-bs-target="#paymentModal"
                                                                    data-order-id="{{ $data_payment->id }}"
                                                                    data-slip-url="{{ $data_payment->payment_slip_url }}">
                                                                    ตรวจสอบการชำระเงิน
                                                                </button>
                                                            @break

                                                            @case('rejected')
                                                                <span class="text-danger">ปฏิเสธการชำระเงิน</span>
                                                            @break

                                                            @default
                                                                <span class="text-info">ยอมรับแล้ว</span>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-messages" role="tabpanel">
                                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
                                    @foreach ($key_work as $data_work)
                                        <div class="col">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="card-title mb-0">
                                                            <a type="button" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#alertModal">
                                                                ORDER #{{ 10000 + $data_work->id }}
                                                            </a>
                                                        </h5>
                                                        @if ($data_work->payment_status == 'pending')
                                                            <span class="badge bg-warning">รอจ่ายเงิน</span>
                                                        @elseif ($data_work->payment_status == 'paid')
                                                            <span class="badge bg-success">จ่ายเเล้ว</span>
                                                        @elseif ($data_work->payment_status == 'rejected')
                                                            <span class="badge bg-danger">ปฎิเสธ</span>
                                                        @else
                                                            <span class="badge bg-success">จ่ายงาน</span>
                                                        @endif
                                                    </div>
                                                    <h6 class="card-subtitle text-muted mb-3">ราคารวม:
                                                        <span class="text-success">{{ $data_work->total_price }}</span>
                                                    </h6>
                                                    <h6 class="card-subtitle text-muted mb-3">จำนวน:
                                                        <span class="text-warning">{{ $data_work->count }}</span>
                                                    </h6>
                                                    <div style="font-size: 12px;">
                                                        กำหนดการ</br>{{ $data_work->created_at }}</br> ถึง
                                                        {{ $data_work->deadline }}
                                                    </div>
                                                    <br>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        @switch($data_work->payment_status)
                                                            @case('pending')
                                                                <span class="text-warning">รอชำระเงิน</span>
                                                            @break

                                                            @case('paid')
                                                                <button class="btn btn-outline-success btn-sm"
                                                                    data-bs-toggle="modal">
                                                                    ตรวจสอบการชำระเงิน
                                                                </button>
                                                            @break

                                                            @case('rejected')
                                                                <span class="text-danger">ปฏิเสธการชำระเงิน</span>
                                                            @break

                                                            @default
                                                                <button class="btn btn-outline-success btn-sm workButton"
                                                                    data-bs-toggle="modal" data-bs-target="#work"
                                                                    data-order-id="{{ $data_work->id }}">
                                                                    จ่ายงาน
                                                                </button>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model1 --}}
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="alertModalLabel">
                        <i class="fas fa-exclamation-circle me-2"></i>Confirm Action
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center justify-content-center" id="orderlist_model1">
                        innerHTML
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmAccept">
                        <i class="fas fa-check me-2"></i>Accept
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- model 2 --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="paymentModalLabel">ตรวจสอบการชำระเงิน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">ตรวจสอบสลิปการชำระเงิน:</p>
                    <div class="text-center">
                        {{-- <img id="paymentSlipImage" src="" alt="Payment Slip" class="img-fluid payment-slip"
                            style="max-height: 400px;"> --}}
                        <img src="https://shop.prachataistore.net/wp-content/uploads/2023/05/IMG_2872-1.jpeg"
                            alt="Payment Slip" class="img-fluid payment-slip" style="max-height: 400px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="cencelPayment">ปฎิเสธ</button>
                    <button type="button" class="btn btn-success" id="confirmPayment">
                        <i class="fas fa-check me-2"></i>ยืนยันการชำระเงิน
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- model 3 --}}
    <div class="modal fade" id="work" tabindex="-1" aria-labelledby="workLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="fas fa-money-bill-wave me-2"></i>จ่ายงาน
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>ดอกไม้ที่ต้องจ่ายทั้งหมด
                    </div>
                    <div class="text-center" id="productInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>ปิด
                    </button>
                    <button type="button" class="btn btn-success" id="testWork">
                        <i class="fas fa-check me-2"></i>ยืนยันการจ่ายงาน
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const workButtons = document.querySelectorAll('.workButton');
            const productInfoDiv = document.getElementById('productInfo');
            const WorksButton = document.getElementById('testWork');
            let currentProducts = [];
            let currentOrderId = null;

            // เมื่อกดปุ่มสำหรับแสดง modal จะดึงข้อมูลที่เกี่ยวข้องกับคำสั่งซื้อนั้นมาแสดง
            workButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const orderIdWork = event.target.getAttribute('data-order-id');
                    currentOrderId = orderIdWork;

                    // Fetch ข้อมูลคำสั่งซื้อ
                    fetch(`/show_orderlist/${orderIdWork}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            currentProducts = data;
                            updateProductInfo(data);
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:',
                                error);
                        });
                });
            });

            // ฟังก์ชันสำหรับอัปเดตข้อมูลสินค้าใน modal
            function updateProductInfo(data) {
                productInfoDiv.innerHTML = '';
                data.forEach((item, index) => {
                    console.log(item)
                    let test1 = ''
                    if (item.product_type === "flower") {
                        test1 = "ดอก"
                    } else {
                        test1 = "ถาด"
                    }
                    const productHtml = `
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <!-- Product Image Section -->
                                <div class="col-md-5 p-3 bg-light d-flex align-items-center justify-content-center border-end">
                                    <img src="/storage/${item.product_image}" alt="${item.product_name}" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                                </div>
                                
                                <!-- Product Details Section -->
                                <div class="col-md-7 p-0">
                                    <div class="card border-0">
                                        <div class="card-header bg-white border-bottom">
                                            <h3 class="card-title mb-0">${item.product_name}</h3>
                                        </div>
                                        
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Product Details</h5>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span><i class="fas fa-barcode me-2"></i>Product ID:</span>
                                                    <span class="badge bg-secondary">${item.product_id}</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-box me-2"></i>Quantity:</span>
                                                    <span class="badge bg-info">${item.quantity}  ${test1}
                                                        </span>
                                                </div>
                                            </li>
                                            
                                            <li class="list-group-item">
                                                <h5 class="mb-3"><i class="fas fa-tag me-2"></i>Pricing</h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>Price:</span>
                                                    <span class="fw-bold text-success">${item.price}</span>
                                                </div>
                                            </li>
                                            
                                            <li class="list-group-item">
                                                <select id="farmerDropdown${index}" class="form-select mb-4">
                                                    <option value="">เลือกเกษตรกร</option>
                                                    ${item.data_farmer.map(farmer => `
                                                                            <option value="${farmer.farmer_id}" data-line-id="${farmer.line_id}" data-quantity="${item.farmer_product_quantity}">${farmer.farmer_name} (ปริมาณ: ${item.farmer_product_quantity})</option>
                                                                        `).join('')}
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    `;
                    productInfoDiv.innerHTML += productHtml;
                });

                // เพิ่ม event listener ให้ dropdown ของเกษตรกร
                data.forEach((item, index) => {
                    const dropdown = document.getElementById(`farmerDropdown${index}`);
                    dropdown.addEventListener('change', function() {
                        const selectedFarmer = this.value;
                        if (selectedFarmer) {
                            console.log(
                                `เลือกเกษตรกร ${this.options[this.selectedIndex].text} สำหรับสินค้า ${item.product_name}`
                            );
                        } else {
                            console.log(`ไม่ได้เลือกเกษตรกรสำหรับสินค้า ${item.product_name}`);
                        }
                    });
                });
            }

            // ฟังก์ชันสำหรับส่งข้อมูลการจ่ายงาน
            WorksButton.addEventListener('click', () => {
                if (!currentOrderId) {
                    console.error('No order selected');
                    return;
                }

                const worksToAssign = currentProducts.map((product, index) => {
                    const dropdown = document.getElementById(`farmerDropdown${index}`);
                    const selectedOption = dropdown.options[dropdown.selectedIndex];
                    const selectedFarmerId = selectedOption.value;

                    if (!selectedFarmerId) {
                        console.error(`No farmer selected for product ${product.product_name}`);
                        return null;
                    }

                    const farmerName = selectedOption.text.split(' (')[0];
                    const farmerProductQuantity = parseInt(selectedOption.getAttribute(
                        'data-quantity'), 10);
                    const lineId = selectedOption.getAttribute('data-line-id');

                    return {
                        id: product.order_list_id, // ใช้ order_list_id ที่ได้รับจากเซิร์ฟเวอร์
                        order_id: currentOrderId,
                        product_id: product.product_id,
                        quantity: product.quantity,
                        price: product.price,
                        created_at: null,
                        delivery_timeframe: product.delivery_timeframe || "2024-08-31",
                        farmer_id: selectedFarmerId,
                        farmer_name: farmerName,
                        farmer_product_quantity: farmerProductQuantity,
                        order_deadline: product.order_deadline,
                        product_image: product.product_image,
                        product_name: product.product_name,
                        status: "assigned",
                        updated_at: null,
                        line_id: lineId // เพิ่ม line_id
                    };
                }).filter(work => work !== null);

                console.log(worksToAssign[0].order_id);

                if (worksToAssign.length === 0) {
                    alert('กรุณาเลือกเกษตรกรสำหรับสินค้าทุกรายการก่อนยืนยัน');
                    return;
                }

                // ส่งข้อมูลการจ่ายงานไปที่เซิร์ฟเวอร์
                fetch('/assign_works', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(worksToAssign)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('งานถูกจ่ายเรียบร้อยแล้ว:', data);
                        alert('งานได้ถูกจ่ายเรียบร้อยแล้ว');
                        $('#work').modal('hide');
                        // อาจจะต้องรีเฟรชหน้าหรืออัพเดต UI ตรงนี้
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการจ่ายงาน:', error);
                        alert('เกิดข้อผิดพลาดในการจ่ายงาน กรุณาลองใหม่อีกครั้ง');
                    });

                const work_order_id = worksToAssign[0].order_id



                fetch('/orders/update-payment-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify({
                            order_id: work_order_id,
                            payment_status: 'paidWork'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'อัพเดตสถานะการชำระเงินเรียบร้อยแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'เกิดข้อผิดพลาดในการอัพเดตสถานะ');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: error.message || 'ไม่สามารถอัพเดตสถานะการชำระเงินได้',
                        });
                    })
                    .finally(() => {
                        confirmPaymentButton.innerHTML =
                            '<i class="fas fa-check me-2"></i>ยืนยันการชำระเงิน';
                        confirmPaymentButton.disabled = false;
                        let modalInstance = bootstrap.Modal.getInstance(paymentModal);
                        modalInstance.hide();
                    });

            });

        });
    </script>


    <script>
        function updateOrderStatus(orderId, action) {
            fetch(`/orders/${orderId}/${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // รีเฟรชหน้าหลังจากอัพเดทสำเร็จ
                    } else {
                        alert('Failed to update order: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the order.');
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertModal = document.getElementById('alertModal');
            const orderlist_item = document.getElementById('orderlist_model1');
            let currentOrderId;

            // เมื่อคลิกปุ่ม Accept
            document.querySelectorAll('.accept-order').forEach(button => {
                button.addEventListener('click', function() {
                    const currentOrderId = this.getAttribute(
                        'data-order-id-model1'
                    ); // Corrected the attribute name if it's truly 'data-order-id-model1'
                    console.log("currentOrderId: ", currentOrderId);
                    // เมื่อคลิกปุ่ม Accept ใน modal
                    document.getElementById('confirmAccept').addEventListener('click', function() {
                        console.log(currentOrderId)
                        if (currentOrderId) {
                            console.log('test_button_accept')
                            updateOrderStatus(currentOrderId, 'complete');
                            let modal = bootstrap.Modal.getInstance(alertModal);
                            modal.hide();
                        }
                    });
                    fetch(
                            `/show_orderlist_model1/${currentOrderId}`
                        ) // Corrected variable name from 'currentOroderId' to 'currentOrderId'
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(
                                    'Network response was not ok'
                                ); // Corrected spelling of "response"
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("orderlist: ", data);
                            // const orderlistItem = document.getElementById('orderlist_item');
                            const content = data.map(item => {
                                const quantityText = item.type === 'flower' ? 'ดอก' :
                                    'ถาด'; // Correctly using the ternary operator for conditional text
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
                            orderlist_item.innerHTML = content;
                        })
                        .catch(error => {
                            console.error('Error fetching orderlist:', error);
                        });

                });
            });



        });

        function updateOrderStatus(orderId, status) {
            // ทำการอัพเดทสถานะ order ด้วย AJAX
            fetch(`/orders/${orderId}/${status}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // อัพเดท UI หรือ reload หน้าตามความเหมาะสม
                        location.reload();
                    } else {
                        alert('Failed to update order status');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentModal = document.getElementById('paymentModal');
            const paymentSlipImage = document.getElementById('paymentSlipImage');
            const confirmPaymentButton = document.getElementById('confirmPayment');
            const cencelPaymentButton = document.getElementById('cencelPayment');

            let currentOrderId;

            document.querySelectorAll('.accept-payment').forEach(button => {
                button.addEventListener('click', function() {
                    currentOrderId = this.getAttribute('data-order-id');
                    const slipUrl = this.getAttribute('data-slip-url');
                    paymentSlipImage.src = slipUrl || 'path/to/default/image.jpg';
                });
            });

            confirmPaymentButton.addEventListener('click', function() {
                if (currentOrderId) {
                    updatePaymentStatus(currentOrderId, 'acceptOrder');
                }
            });
            cencelPaymentButton.addEventListener('click', function() {
                if (currentOrderId) {
                    updatePaymentStatus(currentOrderId, 'rejected');
                }
            });


            function updatePaymentStatus(orderId, status) {
                confirmPaymentButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังดำเนินการ...';
                confirmPaymentButton.disabled = true;

                fetch('/orders/update-payment-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            payment_status: status
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'อัพเดตสถานะการชำระเงินเรียบร้อยแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'เกิดข้อผิดพลาดในการอัพเดตสถานะ');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: error.message || 'ไม่สามารถอัพเดตสถานะการชำระเงินได้',
                        });
                    })
                    .finally(() => {
                        confirmPaymentButton.innerHTML = '<i class="fas fa-check me-2"></i>ยืนยันการชำระเงิน';
                        confirmPaymentButton.disabled = false;
                        let modalInstance = bootstrap.Modal.getInstance(paymentModal);
                        modalInstance.hide();
                    });
            }
        });
    </script>
@endsection
