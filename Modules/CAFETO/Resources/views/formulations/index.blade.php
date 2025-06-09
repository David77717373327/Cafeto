@extends('cafeto::layouts.master')

@push('head')
    <link rel="stylesheet" href="{{ asset('modules/cafeto/css/formulations/index.css') }}">
@endpush

@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.index') }}"
           class="text-decoration-none">{{ trans('cafeto::formulations.Breadcrumb_Formulations_1') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ trans('cafeto::formulations.Breadcrumb_Active_Formulations_1') }}</li>
@endpush

@section('content')
    <div class="card custom-card" data-aos="fade-up">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5 class="text-center text-light">{{ trans('cafeto::formulations.Title_Formulations') }}</h5>
                <div class="d-flex gap-2">
                    @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.create'))
                        <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.create') }}"
                           class="btn btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                           title="{{ trans('cafeto::formulations.Tooltip_Create') }}">
                            <i class="fa-solid fa-file-circle-plus fa-fade me-1"></i> {{ trans('cafeto::formulations.Create New Formulation') }}
                        </a>
                    @endif
                    <button class="btn btn-export btn-sm" onclick="exportTable('csv')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Tooltip_Export_CSV') }}">
                        <i class="fas fa-file-csv"></i> CSV
                    </button>
                    <button class="btn btn-export btn-sm" onclick="exportTable('pdf')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Tooltip_Export_PDF') }}">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>

            <hr class="border-secondary">

            <div class="filter-bar" data-aos="fade-down" data-aos-delay="100">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="filter-element" class="form-control"
                                   placeholder="{{ trans('cafeto::formulations.Filter_Element') }}" oninput="debouncedFilterTable()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            <select id="filter-status" class="form-select" onchange="debouncedFilterTable()">
                                <option value="">{{ trans('cafeto::formulations.All_Statuses') }}</option>
                                <option value="approved">{{ trans('cafeto::formulations.Approved') }}</option>
                                <option value="pending">{{ trans('cafeto::formulations.Pending') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" id="filter-date" class="form-control" oninput="debouncedFilterTable()">
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" data-aos="fade-in">
                    {{ session('success') }}
                </div>
            @endif

            @if ($formulations->isEmpty())
                <p class="text-center text-light" data-aos="fade-in">{{ trans('cafeto::formulations.No formulations found') }}</p>
            @else
                <div class="table-responsive" data-aos="zoom-in">
                    <table class="table table-dark table-hover" id="tableFormulations">
                        <thead class="sticky-header">
                            <tr>
                                <th>{{ trans('cafeto::formulations.Element') }}</th>
                                <th class="text-center">{{ trans('cafeto::formulations.Amount') }}</th>
                                <th>{{ trans('cafeto::formulations.Date') }}</th>
                                <th>{{ trans('cafeto::formulations.Status') }}</th>
                                <th class="text-center">{{ trans('cafeto::formulations.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formulations as $formulation)
                                <tr class="table-row" onclick="toggleDetails(this, {{ $formulation->id }})">
                                    <td>{{ $formulation->element ? $formulation->element->name : trans('cafeto::formulations.None') }}</td>
                                    <td class="text-center">{{ $formulation->amount }}</td>
                                    <td>{{ $formulation->date }}</td>
                                    <td>
                                        <span class="status-badge badge {{ $formulation->proccess === 'approved' ? 'bg-approved' : 'bg-pending' }}">
                                            {{ $formulation->proccess }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.show', $formulation->id) }}"
                                               class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="{{ trans('cafeto::formulations.View') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.edit'))
                                                <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.edit', $formulation->id) }}"
                                                   class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="{{ trans('cafeto::formulations.Edit') }}">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.destroy'))
                                                <form action="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.destroy', $formulation->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-light btn-sm"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ trans('cafeto::formulations.Delete') }}"
                                                            onclick="return handleDelete(event, '{{ trans('cafeto::formulations.Are you sure?') }}')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($formulation->proccess !== 'approved' && Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.approve'))
                                                <form action="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.approve', $formulation->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-light btn-sm"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ trans('cafeto::formulations.Approve') }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="details-row" id="details-{{ $formulation->id }}">
                                    <td colspan="5">
                                        <div class="p-3">
                                            <h6 class="text-light">{{ trans('cafeto::formulations.Ingredients') }}</h6>
                                            <ul class="text-light">
                                                @foreach ($formulation->ingredients ?? [] as $ingredient)
                                                    <li>{{ $ingredient->element->name }}: {{ $ingredient->amount }} {{ $ingredient->unit }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                @foreach ($formulations as $formulation)
                    <div class="mobile-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <h6 class="text-light">{{ $formulation->element ? $formulation->element->name : trans('cafeto::formulations.None') }}</h6>
                        <p class="text-light"><strong>{{ trans('cafeto::formulations.Amount') }}:</strong> {{ $formulation->amount }}</p>
                        <p class="text-light"><strong>{{ trans('cafeto::formulations.Date') }}:</strong> {{ $formulation->date }}</p>
                        <p class="text-light"><strong>{{ trans('cafeto::formulations.Status') }}:</strong>
                            <span class="status-badge badge {{ $formulation->proccess === 'approved' ? 'bg-approved' : 'bg-pending' }}">
                                {{ $formulation->proccess }}
                            </span>
                        </p>
                        <div class="d-flex justify-content-start gap-1">
                            <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.show', $formulation->id) }}"
                               class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                               title="{{ trans('cafeto::formulations.View') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.edit'))
                                <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.edit', $formulation->id) }}"
                                   class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                   title="{{ trans('cafeto::formulations.Edit') }}">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            @endif
                            @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.destroy'))
                                <form action="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.destroy', $formulation->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-light btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ trans('cafeto::formulations.Delete') }}"
                                            onclick="return handleDelete(event, '{{ trans('cafeto::formulations.Are you sure?') }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                            @if ($formulation->proccess !== 'approved' && Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.approve'))
                                <form action="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.approve', $formulation->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ trans('cafeto::formulations.Approve') }}">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="mobile-details mt-2" id="mobile-details-{{ $formulation->id }}">
                            <h6 class="text-light">{{ trans('cafeto::formulations.Ingredients') }}</h6>
                            <ul class="text-light">
                                @foreach ($formulation->ingredients ?? [] as $ingredient)
                                    <li>{{ $ingredient->element->name }}: {{ $ingredient->amount }} {{ $ingredient->unit }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button class="btn btn-link text-light" onclick="toggleMobileDetails({{ $formulation->id }})">
                            {{ trans('cafeto::formulations.Show_Details') }}
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@include('cafeto::layouts.partials.plugins.sweetalert2')
@include('cafeto::layouts.partials.plugins.datatables')

@push('scripts')
    <script src="{{ asset('libs/AOS-2.3.1/dist/aos.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('modules/cafeto/js/formulations/index.js') }}"></script>
@endpush