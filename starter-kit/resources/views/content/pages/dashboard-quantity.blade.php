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
        <div class="col-xl-12">
            <div class="card-body">
                <!-- Basic Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Quantity All</li>
                    </ol>
                </nav>
            </div>
            <div class="nav-align-top nav-tabs-shadow mb-6">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">ดอก</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-profile" aria-controls="navs-top-profile"
                            aria-selected="false">ถาด</button>
                    </li>
                </ul>
                <div class="tab-content">
                    {{-- ดอก --}}
                    <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                        @foreach ($key_farmer as $dataflowerfarmer)
                            @if ($dataflowerfarmer->typefolwer == 'flower')
                                <div class="container-sm mb-3">
                                    <!-- Avatar and Details Column -->
                                    <div class="d-flex flex-column align-items-center ">
                                        <!-- Avatar -->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-column align-items-center p-1">
                                                <div class="avatar me-2 avatar-online p-1">
                                                    <span class="avatar-initial rounded-circle bg-label-success">
                                                        {{ substr($dataflowerfarmer->name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Farmer Name -->
                                            <div class="badge bg-label-success text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 8rem;">
                                                <span>ชื่อเกษตร: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $dataflowerfarmer->name }}</strong>
                                                </div>
                                            </div>

                                            <!-- Flower Name -->
                                            <div class="badge bg-label-warning text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 9rem;">
                                                <div class="text-center w-100 h-100">
                                                    <img src="/storage/{{ $dataflowerfarmer->imageProduct }}"
                                                        class="rounded" alt="{{ $dataflowerfarmer->product_name }}"
                                                        style="max-width: 100px; max-height: 100px;">
                                                </div>
                                                <span>ชื่อดอกไม้: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $dataflowerfarmer->product_name }} ดอก</strong>
                                                </div>
                                            </div>


                                            <!-- Flower Quantity -->
                                            <div class="badge bg-label-primary text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 12rem;">
                                                <span>รับดอกนี้ได้ทั้งหมด: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $dataflowerfarmer->flower_quantity }} ดอก</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>



                    {{-- ถาด --}}
                    <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                        @foreach ($key_farmer as $datatrayfarmer)
                            @if ($datatrayfarmer->typefolwer == 'tray')
                                <div class="container-sm mb-3">
                                    <!-- Avatar and Details Column -->
                                    <div class="d-flex flex-column align-items-center ">
                                        <!-- Avatar -->
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-column align-items-center p-1">
                                                <div class="avatar me-2 avatar-online p-1">
                                                    <span class="avatar-initial rounded-circle bg-label-success">
                                                        {{ substr($datatrayfarmer->name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Farmer Name -->
                                            <div class="badge bg-label-success text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 8rem;">
                                                <span>ชื่อเกษตร: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $datatrayfarmer->name }}</strong>
                                                </div>
                                            </div>

                                            <!-- Flower Name -->
                                            <div class="badge bg-label-warning text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 9rem;">
                                                <div class="text-center w-100 h-100">
                                                    <img src="/storage/{{ $datatrayfarmer->imageProduct }}" class="rounded"
                                                        alt="{{ $datatrayfarmer->product_name }}"
                                                        style="max-width: 100px; max-height: 100px;">
                                                </div>
                                                <span>ชื่อดอกไม้: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $datatrayfarmer->product_name }} ดอก</strong>
                                                </div>
                                            </div>


                                            <!-- Flower Quantity -->
                                            <div class="badge bg-label-primary text-wrap d-flex flex-row justify-content-between align-items-center me-2 mb-2"
                                                style="min-width: 12rem;">
                                                <span>รับดอกนี้ได้ทั้งหมด: </span>
                                                <div class="text-dark">
                                                    <strong>{{ $datatrayfarmer->flower_quantity }} ดอก</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
