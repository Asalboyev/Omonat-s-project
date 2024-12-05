@extends('layouts.admin')
@section('title')
    Language
@endsection

@section('content')
    <div class="menu-item px-3">

        <div class="menu-content px-3 py-3">
            <a href="#" class="btn btn-primary er fs-6 px-4 py-4" data-bs-toggle="modal"
                data-bs-target="#kt_modal_new_address">Add Language</a>
        </div>


    </div>
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Langs</span>
                <span class="text-muted mt-1 fw-bold fs-7">Over 500 orders</span>
            </h3>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                        data-kt-check-target=".widget-13-check" />
                                </div>
                            </th>

                            <th scope="min-w-150px">#</th>
                            <th scope="min-w-140px">Title</th>
                            <th scope="min-w-120px">SMALL TEXT</th>
                            <th scope="min-w-120p">ACTIONS</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($langs as $lang)
                            <tr>
                                <td>
                                    @if ($lang->small != 'uz')
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input widget-13-check" type="checkbox"
                                                value="1" />
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lang->lang }}</td>
                                <td>{{ $lang->small }}</td>
                                <td>
                                    @if ($lang->small != 'uz')
                                        <form class="" action="{{ route('admin.lang.destroy', ['id' => $lang->id]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.5"
                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.5"
                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <div class="modal fade" id="kt_modal_new_address" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->

                <form class="form" id="kt_modal_new_address_form" method="POST" action="{{ route('admin.lang.store') }}">

                    @csrf
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_new_address_header">
                        <!--begin::Modal title-->
                        <h2>Add Language</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_new_address_header"
                            data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">

                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-bold mb-2">Title</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="lang" placeholder="lang..." data-bs-original-title="" title=""/
                                        required @error('lang') is-invalid @enderror">
                                    @error('lang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <!--end::Label-->
                                    <label class="required fs-5 fw-bold mb-2">Small text </label>

                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        id="input-text-1" name="small" type="text"
                                        @error('lang') is-invalid @enderror placeholder="small text..."
                                        data-bs-original-title="" title="" required>
                                    @error('small')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" id="kt_modal_new_address_cancel"
                                class="btn btn-light me-3">Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
@endsection
