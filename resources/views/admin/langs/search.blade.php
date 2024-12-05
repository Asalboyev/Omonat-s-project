@extends('layouts.admin')
@section('title')
    Breands
@endsection
@section('css')
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    @include('admin.success-file')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <form class="navbar-search form-inline mb-4 w-50 d-flex"
                          action="{{ route('admin.breands.search') }}" method="get" id="searchForm">
                        @csrf
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                      rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
            </svg>
        </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-ecommerce-order-filter="search"
                                   class="form-control form-control-solid w-250px ps-14" name="search"
                                   value="{{ request('search') }}" id="searchInput"/>
                        </div>
                    </form>                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="menu-content px-3 py-3">
                        <a href="#1" class="btn btn-primary er fs-6 px-4 py-4" data-bs-toggle="modal"
                           data-bs-target="#kt_modal">Add breand</a>
                    </div>                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_ecommerce_products_table .form-check-input"
                                       value="1"/>
                            </div>
                        </th>
                        <th class="min-w-200px">breands</th>
                        <th class="text-end min-w-70px">Popular</th>
                        <th class="text-end min-w-70px">Logo</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                    <!--begin::Table row-->
                    @foreach ($breands as $breand)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <div class="d-flex align-items-center">

                                    <!--end::Thumbnail-->
                                    <div class="ms-5">
                                        <!--begin::Title-->
                                        <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bolder"
                                           data-kt-ecommerce-product-filter="product_name">{{ $breand->title}}</a>
                                        <!--end::Title-->
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pe-0" data-order="25">
                                <span class="fw-bolder ms-3">{{ $breand->popular ??  'Null' }}</span>
                            </td>
                            <td class="text-end pe-0" data-order="25">
                                <img alt="image" src="{{ asset('storage/' . $breand->photo) }}" width="35">
                            </td>
                            <td class="text-end pe-0" data-order="25">
                                <span class="fw-bolder ms-3">{{ $breand->created_at }}</span>
                            </td>
                            <td class="text-end">
                                <form class="" action="{{ route('admin.breands.destroy', $breand->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('admin.breands.edit',$breand->id)}}"
                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                          d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                          fill="currentColor"></path>
                                                    <path
                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                    </a>
                                    <button type="submit"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                        fill="currentColor"/>
                                                    <path opacity="0.5"
                                                          d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                          fill="currentColor"/>
                                                    <path opacity="0.5"
                                                          d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                          fill="currentColor"/>
                                                </svg>
                                            </span>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>

                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <div class="modal fade" id="kt_modal" tabindex="-3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->

                <form class="form" id="kt_modal_new" method="POST"
                      action="{{ route('admin.breands.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scrol" data-kt-scroll="true"
                             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                             data-kt-scroll-dependencies="#kt_modal_new_address_heade"
                             data-kt-scroll-wrappers="#kt_modal_new_address_scrol" data-kt-scroll-offset="300px">

                            <div class="card-body pt-0">
                                <!--begin::Select store template-->
                                <label for="kt_ecommerce_add_category_store_template" class="form-label">Title</label>
                                <input type="text" name="title" id="checkbox" placeholder="add breand title "
                                       class="form-control mb-2">
                            </div>
                            <div class="card-body  pt-0">
                                <div class="card-body  pt-0">
                                    <div class="row mb-5">
                                        <!--begin::Col-->
                                        <div id="my-dropzone" class="dropzone">
                                            <div class="fallback">
                                                <input required name="photo" type="file"/>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="active" id="status" name="popular" >
                                    <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                </div>
                            </div>
                            <div class="modal-footer flex-center">
                                <!--begin::Button-->
                                <button type="reset" id="kt_modal_new_address_cancel"
                                        class="btn btn-light me-3">Discard
                                </button>
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Button-->
                            </div>
                </form>
                <input type="hidden" required name="photo" id="image_name">
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            document.getElementById('searchForm').submit();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.breands.ajax') }}", // Upload yo'lini kiritish
                paramName: "file", // serverga fayl nomi
                maxFilesize: 2, // maksimal fayl hajmi (MB)
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp", // qo'llaniladigan fayl turlari
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                maxFiles: 1, // faqat bitta rasm yuklash imkoniyati
                addRemoveLinks: true, // x tugmasi qo'shish
                init: function () {
                    this.on("success", function (file, response) {
                        if (response.success) {
                            // Dropzone orqali yuklangan rasm yo'lini formaga qo'shamiz
                            $('#image_name').val(response.success);
                        } else {
                            console.log(response);
                        }
                    });

                    this.on("error", function (file, response) {
                        if (typeof response === 'object') {
                            alert(JSON.stringify(response));
                        } else {
                            alert(response);
                        }
                    });

                    this.on("removedfile", function (file) {
                        // Rasm o'chirilganda yashirin inputni tozalaymiz
                        $('#image_name').val('');
                    });

                    // Eski rasmni ko'rsatish uchun
                    var existingPhotoUrl = $('#image_name').val();
                    if (existingPhotoUrl) {
                        var mockFile = {
                            name: existingPhotoUrl,
                            size: 12345
                        };
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, '{{ asset('storage') }}/' + existingPhotoUrl);
                        this.emit("complete", mockFile);
                    }
                }
            });
        });
    </script>
@endsection
