@extends('layouts.admin')
@section('title')
    Update breand
@endsection
@section('css')
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="kt_content_container" class="container-xxl">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <form class="form" id="kt_modal_new" method="POST"
                      action="{{ route('admin.breands.update', $breand->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scrol" data-kt-scroll="true"
                             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                             data-kt-scroll-dependencies="#kt_modal_new_address_heade"
                             data-kt-scroll-wrappers="#kt_modal_new_address_scrol" data-kt-scroll-offset="300px">

                            <div class="card-body pt-0">
                                <!--begin::Select store template-->
                                <label for="kt_ecommerce_add_category_store_template" class="form-label">Title</label>
                                <input type="text" name="title" id="checkbox" value="{{$breand->title}}"
                                       class="form-control mb-2">
                            </div>
                            <div class="card-body  pt-0">
                                <div class="card-body  pt-0">
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="hidden" name="photo" id="image_name"
                                               value="{{ $breand->photo }}">
                                        <div id="my-dropzone" class="dropzone"></div>
                                    </div>

                                </div>
                                <div class="card-body pt-0">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input type="hidden" name="popular" >
                                        <input class="form-check-input" type="checkbox" value="active" id="status"
                                               name="popular"
                                            <?php echo $breand->popular === 'active' ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                               for="status">Active</label>
                                    </div>
                                </div>

                                <div class="modal-footer flex-center">
                                    <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                </form>
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Toolbar-->
            <div class="toolbar" id="kt_toolbar">
                <!--begin::Container-->
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                         data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                         class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <!--begin::Title-->
                        <a href="{{route('admin.breands.index')}}"
                           class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Back</a>
                        <!--end::Title-->
                        <!--begin::Separator-->
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--end::Separator-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <button type="submit" class="btn btn-sm btn-primary">Add</button>
                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Container-->
            </div>

        </div>
        </form>
    </div>
    </div>
    </div>
@endsection
@section('js')
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
