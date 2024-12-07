@extends('layouts.admin')
@section('title')
    About
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .input-row {
            display: flex;
            gap: 20px;
            /* Adjust the gap as needed */
            margin-bottom: 20px;
            /* Space between rows */
        }

        .form-group {
            flex: 1;
            /* Make sure each form group takes up equal space */
        }
        .custom-alert {
            position: fixed;
            background-color: #0BB783;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 200px;
            max-width: 300px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .custom-alert.fade-out {
            opacity: 0;
        }
    </style>

@endsection

@section('content')
    {{-- <h1 class="text-uppercase mb-4">Add category</h1> --}}

    {{-- <a href="{{ route('admin.categories.index') }}" class="btn btn-success mb-3 text-white">Back Page</a> --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade custom-alert">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>✅</span>
                </button>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <form id="" action="{{ route('admin.information.store', $information->id) }}" method="post" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <!--begin:::Tab item-->
                        @foreach ($languages as $language)
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 @if ($language->small != 'uz') @else
                            active @endif "
                                   data-bs-toggle="tab" href="#{{ $language->small }}">{{ $language->lang }}</a>
                            </li>
                        @endforeach

                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        @foreach ($languages as $language)
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show @if ($language->small != 'en') @else
                            active @endif"
                                 id="{{ $language->small }}" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ $language->lang }}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                          <!--begin::Input group-->

                                        <div class="card-body pt-0">
                                            <div>
                                                <label class="form-label">title-{{ $language->lang }}</label>
                                                <input id="title-{{ $language->small }}" name="title[{{ $language->small }}]"
                                                    class="form-control ckeditor" value="{{ is_array($information->title) ? $information->title[$language->small] : '' }}"
                                                    />
                                            </div>
                                            <div>
                                                <label class="form-label">sub title-{{ $language->lang }}</label>
                                                <input id="subtitle-{{ $language->small }}" name="subtitle[{{ $language->small }}]"
                                                    class="form-control ckeditor" value="{{ is_array($information->subtitle) ? $information->subtitle[$language->small] : '' }}"/>
                                            </div>
                                            <!--begin::Input group-->
                                            <div>
                                                <label class="form-label">Description-{{ $language->lang }}</label>
                                                <textarea id="descriptions-{{ $language->small }}"
                                                          name="description[{{ $language->small }}]" class="form-control ckeditor"
                                                          required>
                                                    @php
                                                        $descriptions = json_decode($information->description, true);

                                                        $descriptionText = $descriptions[$language->small] ?? 'No description available';
                                                    @endphp

                                                    {!! $descriptionText !!}
                                          </textarea>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div>
                                                <label class="form-label">Double Description-{{ $language->lang }}</label>
                                                <textarea id="descriptions-{{ $language->small }}"
                                                          name="double_description[{{ $language->small }}]" class="form-control ckeditor"
                                                          required>
                                                    @php
                                                        $descriptions = json_decode($information->double_description, true);

                                                        $descriptionText = $descriptions[$language->small] ?? 'No description available';
                                                    @endphp

                                                    {!! $descriptionText !!}
                                          </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10"
                     style="margin-left: 2rem; margin-top:5.5rem">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">

                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Apple link</label>
                            <input type="url" class="form-control mb-2" name="apple_link" value="{{ $information->apple_link}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">And link</label>
                            <input type="url" class="form-control mb-2" name="and_link" value="{{ $information->and_link}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">App link</label>
                            <input type="url" class="form-control mb-2" name="app_link" value="{{ $information->app_link}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Phone</label>
                            <input type="number" class="form-control mb-2" name="phone" value="{{ $information->phone}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Telegram link</label>
                            <input type="url" class="form-control mb-2" name="tg_link" value="{{ $information->tg_link}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Instagram link</label>
                            <input type="url" class="form-control mb-2" name="insta_link" value="{{ $information->insta_link}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Youtobe link</label>
                            <input type="url" class="form-control mb-2" name="you_link" value="{{ $information->you_link}}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.information.ajax') }}", // Upload yo'lini kiritish
                paramName: "file", // serverga fayl nomi
                maxFilesize: 4, // maksimal fayl hajmi (MB)
                acceptedFiles: ".jpeg,.jpg,.png,.gif", // qo'llaniladigan fayl turlari
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                maxFiles: 1, // faqat bitta rasm yuklash imkoniyati
                addRemoveLinks: true, // x tugmasi qo'shish
                init: function() {
                    this.on("success", function(file, response) {
                        if (response.success) {
                            // Dropzone orqali yuklangan rasm yo'lini formaga qo'shamiz
                            $('#image_name').val(response.success);
                        } else {
                            console.log(response);
                        }
                    });

                    this.on("error", function(file, response) {
                        if (typeof response === 'object') {
                            alert(JSON.stringify(response));
                        } else {
                            alert(response);
                        }
                    });

                    this.on("removedfile", function(file) {
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
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>

    {{-- <script type="text/javascript">
        @foreach ($languages as $language)
        CKEDITOR.replace('descriptions-{{ $language->small }}', {
            filebrowserUploadUrl: "{{ route('admin.faq.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        @endforeach
    </script> --}}
@endsection
