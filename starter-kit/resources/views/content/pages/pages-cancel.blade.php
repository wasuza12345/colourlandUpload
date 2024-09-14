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


@section('content')
    <div class="row mb-12 g-6">
        @foreach ($cancel_order as $data_cancelOrder)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">
                                <a type="button" href="#" data-bs-toggle="modal" data-bs-target="#alertModal">
                                    ORDER #{{ 10000 + $data_cancelOrder->id }}
                                </a>
                            </h5>
                            <span class="badge bg-danger">Cancel</span>
                        </div>
                        <h6 class="card-subtitle text-muted mb-3">ราคารวม:
                            <span class="text-success">{{ number_format($data_cancelOrder->total_price, 2) }} บาท</span>
                        </h6>
                        <h6 class="card-subtitle text-muted mb-3">จำนวน:
                            <span class="text-warning">{{ $data_cancelOrder->count }}</span>
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
