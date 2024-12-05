@extends('layouts.admin')
@section('title')
    Add Translations
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .copy-container {
            display: flex;
            align-items: center;
        }

        .copy-icon {
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">

        <!--begin::Header-->
        <div class="card-body flex-column p-5">
            <!--begin::Hero content-->

            <!--end::Hero content-->
            <!--begin::Hero nav-->
            <div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
                <!--begin::Nav-->
                <ul class="nav flex-wrap border-transparent fw-bolder">
                    <!--begin::Nav item-->
                    {{-- @foreach ($groups as $subGroup)
                        <li class="nav-item my-1 ">
                            <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active"
                                href="{{ route('admin.group.show', $subGroup) }}">{{ $subGroup->name }}</a>
                        </li>
                    @endforeach --}}

                    @foreach ($groups as $subGroup)
                        <li class="nav-item my-1">
                            <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase {{ request()->route('admin/group/' . $subGroup->id) ? 'active' : '' }}"
                                href="{{ route('admin.group.show', $subGroup) }}">
                                {{ $subGroup->name }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <form class="navbar-search form-inline mb-4 w-50 d-flex" action="{{ route('admin.translation.search') }}" method="GET">
                            @csrf
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                              rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                              fill="currentColor"/>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->

                                <input type="text" data-kt-ecommerce-order-filter="search"
                                       class="form-control form-control-solid w-250px ps-14" name="search"
                                       placeholder="Search Order" value="{{ request('search') }}" />
                            </div>
                        </form>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Flatpickr-->

                        {{--
                        <a href="{{ route('admin.translation.create', $group->id) }}" class="btn btn-primary">Add
                            Translation</a> --}}
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">#</th>
                                <th class="min-w-100px">Key</th>
                                @foreach ($languages as $language)
                                    <th class="min-w-175px">{{ $language->lang }}</th>
                                @endforeach
                                <th scope="min-w-120p">ACTIONS</th>

                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">

                            @foreach ($result as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td> --}}
                                    <td>
                                        <div id="copy-container" class="copy-container">
                                            <i class="fas fa-copy copy-icon" onclick="copyText('{{ $item->key }}')"></i>
                                            {{ $item->key }}

                                        </div>
                                    </td>

                                    </td>
                                    {{-- @foreach ($languages as $language)
                                        <td>{{ $item->val[$language->small] }}</td>

                                    @endforeach --}}

                                    @foreach ($languages as $lang)
                                        <td>
                                            @if (isset($item->val[$lang->small]))
                                                {{ $item->val[$lang->small] }}
                                                @if ($loop->last)
                                                    @continue
                                                @endif
                                                <br><br>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td>
                                        <form class=""
                                            action="{{ route('admin.translation.destroy', ['id' => $item->id]) }}"
                                            method="post">
                                            @csrf
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_{{ $item->id }}_app"
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
                                                <!--end::Svg Icon-->
                                            </a>
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
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="kt_modal_{{ $item->id }}_app" tabindex="-1"
                                    aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog modal-dialog-centered mw-900px">
                                        <!--begin::Modal content-->
                                        <div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header">
                                                <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                    data-bs-dismiss="modal">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                height="2" rx="1"
                                                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                            <rect x="7.41422" y="6" width="16" height="2"
                                                                rx="1" transform="rotate(45 7.41422 6)"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <!--end::Modal header-->
                                            <!--begin::Modal body-->
                                            <form class="form" id="kt_modal_new_address_form" method="POST"
                                                action="{{ route('admin.translation.tr_update', ['id' => $item->id]) }}">
                                                @csrf

                                                <div class="modal-body py-10 px-lg-17">
                                                    <!--begin::Scroll-->
                                                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll"
                                                        data-kt-scroll="true"
                                                        data-kt-scroll-activate="{default: false, lg: true}"
                                                        data-kt-scroll-max-height="auto"
                                                        data-kt-scroll-dependencies="#kt_modal_new_address_header"
                                                        data-kt-scroll-wrappers="#kt_modal_new_address_scroll"
                                                        data-kt-scroll-offset="300px">

                                                        <div class="row mb-5">
                                                            <!--begin::Col-->

                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fs-5 fw-bold mb-2">Key</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" id="inputField"
                                                                    class="form-control form-control-solid" placeholder=""
                                                                    name="key" placeholder="title..."
                                                                    data-bs-original-title="" title="" required
                                                                    value="{{ $item->key }}">

                                                            </div>

                                                            @foreach ($languages as $language)
                                                                <div class="col-md-6 fv-row">
                                                                    <!--end::Label-->
                                                                    <label
                                                                        class="required fs-5 fw-bold mb-2">{{ $language->lang }}
                                                                    </label>

                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="input-text-1"
                                                                        name="val[{{ $language->small }}]"
                                                                        type="text"placeholder="{{ $language->small }}..."
                                                                        data-bs-original-title="" title=""
                                                                        value=" @if (isset($item->val[$lang->small])) {{ $item->val[$lang->small] }}
                                                                        @if ($loop->last) @continue @endif

                                                                  @endif"
                                                                        @if (isset($item->val[$lang->small])) {{ $item->val[$lang->small] }}
                                                                        @if ($loop->last) @continue @endif
                                                                        @endif

                                                                    required>
                                                                    @error('subtext')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer flex-center">
                                                        <!--begin::Button-->
                                                        <button type="reset" id="kt_modal_new_address_cancel"
                                                            class="btn btn-light me-3">Discard</button>
                                                        <!--end::Button-->
                                                        <!--begin::Button-->
                                                        <button type="submit" id="kt_modal_new_address_submit"
                                                            class="btn btn-primary">
                                                            <span class="indicator-label">Submit</span>
                                                            <span class="indicator-progress">Please wait...
                                                                <span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                        <!--end::Button-->
                                                    </div>

                                                </div>
                                            </form>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex flex-stack flex-wrap pt-10">
                        {{-- <div class="fs-6 fw-bold text-gray-700">Showing 1 to 10 of 50 entries</div> --}}
                        <!--begin::Pages-->
                        {{-- <ul class="pagination">
                            {{ $translations->links() }}
                        </ul> --}}
                        <!--end::Pages-->
                    </div>
                </div>
            </div>
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
                    <a href="" class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Translation</a>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
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
                    <a href="{{ route('admin.translations.index') }}" class="btn btn-sm btn-primary">Back</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Container-->
        </div>

    </div>
@endsection
@section('js')
    <script>
        var url = window.location.href;

        var link = document.querySelectorAll("[href='" + url + "']")[0];
        link.parentElement.classList.add('active')
    </script>
    <script>
        function copyText(text) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

        }
    </script>

    <script src="{{ asset('/assets/js/custom/apps/ecommerce/sales/listing.js') }}"></script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src=/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
@endsection
