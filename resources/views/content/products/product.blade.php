@extends('layouts/layoutMaster')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
    <!-- Examples -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Products
    </button>

    <div class="row mb-12 g-6">
        @foreach ($show_product as $data_product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $data_product->name }}</h5>
                    </div>
                    <img class="img-fluid" src="/storage/{{ $data_product->image }}" alt="Card image cap" />
                    <div class="card-body">
                        <p class="card-text">{{ $data_product->description }}</p>
                        <p class="card-text">ราคา {{ $data_product->price }} บาท</p>
                        <p class="card-text">
                            @if ($data_product->type == 'flower')
                                <div>หน่วย: ดอก</div>
                            @else
                                <div>หน่วย: ถาด</div>
                            @endif
                        </p>
                        <a href="/product/delete/{{ $data_product->id }}" class="card-link">ลบ</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Examples -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="browser-default-validation" method="POST" action="{{ route('flowers.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-name">ชื่อดอกไม้</label>
                            <input type="text" class="form-control" id="basic-default-name" name="name"
                                placeholder="ดาวเรือง(เหลือง)" required />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="price">ราคา</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="1"
                                required />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-country">หน่วย</label>
                            <select class="form-select" id="basic-default-country" name="unit" required>
                                <option value="">เลือกหน่อยของดอกไม้</option>
                                <option value="flower">ดอก</option>
                                <option value="tray">ถาด</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-upload-file">Profile pic</label>
                            <input type="file" class="form-control" id="basic-default-upload-file" name="profile_pic"
                                required />
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="basic-default-bio">รายละเอียด</label>
                            <textarea class="form-control" id="basic-default-bio" name="detail" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
