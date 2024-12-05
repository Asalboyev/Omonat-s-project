@extends('layouts.admin')
@section('title')
    Add Translations
@endsection
@section('css')
@endsection
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
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
    <form action="{{ route('admin.translation.update', $group->id) }}" method="POST">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                Translations
                            </div>
                        </div>

                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                            <button type="submit" class="btn btn-success">Save</button>

                        </div>
                    </div>

                    <div class="card-body pt-0">
                        @csrf
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Key</th>
                                    @foreach ($languages as $language)
                                        <th class="min-w-175px">{{ $language->lang }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600" id="table-body">
                                @foreach ($translation as $index => $translation)
                                    <tr>
                                        <td>
                                            <input type="text" required value="{{ $translation->key }}"
                                                oninput="updateValue({{ $index }})" class="form-control"
                                                name="key[]" id="group_name_{{ $index }}" required>
                                            <input type="hidden" name="group_id[]" value="{{ $translation->id }}">
                                        </td>
                                        @foreach ($languages as $language)
                                            <td>
                                                <input type="text" class="form-control"
                                                    name="val[{{ $index }}][{{ $language->small }}]"
                                                    value="{{ $translation->val[$language->small] ?? '' }}"
                                                    placeholder="{{ $language->small }}...">
                                            </td>
                                        @endforeach
                                        <td>
                                            <form class=""
                                                action="{{ route('admin.translation.destroy', ['id' => $translation->id]) }}"
                                                method="post">
                                                @csrf

                                                <button type="submit" onclick="return confirm('Ochirishni xohlisizmi?')"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
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
                    <a href="" class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Translation</a>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="" class="text-muted text-hover-primary">{{ $group->name }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="" class="text-muted text-hover-primary">Add Translations</a>
                        </li>



                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.group.show', $group->id) }}" class="btn btn-sm btn-primary">Back</a>
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
        var newRowCounter = {{ $translation->count() }}; // Initialize with existing row count

        function addRow() {
            var tableBody = document.getElementById("table-body");
            var rowCount = tableBody.rows.length;
            var newRow = document.createElement("tr");
            newRow.innerHTML = `
            <td>
                <input type="text" name="key[]" id="group_name_${rowCount}" value="{{ $group->name }}." class="form-control" required oninput="updateValue(${rowCount})">
                <input type="hidden" name="group_id[]" value="">
            </td>
            @foreach ($languages as $language)
                <td>
                    <input type="text" class="form-control" name="val[${rowCount}][{{ $language->small }}]" placeholder="{{ $language->small }}...">
                </td>
            @endforeach
            <td>
                <button type="button" onclick="deleteRow(this) " class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm "> <span class="svg-icon svg-icon-3">
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
            </td>
        `;
            tableBody.appendChild(newRow);
            newRowCounter++;
        }

        const initialGroupName = "{{ $group->name }}.";

        function updateValue(index) {
            const inputField = document.getElementById('group_name_' + index);
            const currentValue = inputField.value;

            if (currentValue.startsWith(initialGroupName)) {
                userAddedInfo = currentValue.slice(initialGroupName.length);
            } else {
                userAddedInfo = '';
            }

            inputField.value = initialGroupName + userAddedInfo;
        }

        function deleteRow(row) {
            var tableBody = document.getElementById("table-body");
            tableBody.removeChild(row.parentNode.parentNode);
            newRowCounter--; // Adjust the counter if needed
        }
    </script>
@endsection
