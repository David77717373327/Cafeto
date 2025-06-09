@extends('cafeto::layouts.master')

@push('head')
    <style>
        .sticky-header th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #1a1a1a; /* Dark black-gray */
            color: #fff;
        }
        .table-row {
            transition: background-color 0.3s ease;
        }
        .table-row:hover {
            background-color: #333333; /* Dark gray on hover */
        }
        .filter-bar {
            background:rgba(0, 0, 0, 0.71); /* Pure black */
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #fff;
        }
        .details-row {
            display: none;
            background-color: #2a2a2a; /* Slightly lighter black-gray */
            color: #fff;
        }
        .btn-export {
            background:rgba(0, 0, 0, 0.71); /* Pure black */
            color: #fff;
            border: 1px solid #333333;
        }
        .btn-export:hover {
            color: #fff;
            background: #333333;
        }
        .status-badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }
        .mobile-card {
            border: 1px solid #333333;
            background:rgba(26, 26, 26, 0.71);
            color: #fff;
        }
        @media (max-width: 768px) {
            .table-responsive {
                display: none;
            }
            .mobile-card {
                display: block;
                border: 1px solid #333333;
                border-radius: 5px;
                margin-bottom: 15px;
                padding: 15px;
                background: #1a1a1a;
            }
        }
        @media (min-width: 769px) {
            .mobile-card {
                display: none;
            }
        }
    </style>
@endpush

@push('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.index') }}"
           class="text-decoration-none">{{ trans('cafeto::formulations.Breadcrumb_Formulations_1') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ trans('cafeto::formulations.Breadcrumb_Active_Formulations_1') }}</li>
@endpush

@section('content')
    <div class="card card-dark shadow-sm" style="border: 1px solid #333333;" data-aos="fade-up">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="text-center" style="color: #fff;"><em>{{ trans('cafeto::formulations.Title_Formulations') }}</em></h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex justify-content-end">
                        @if (Auth::user()->havePermission('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.create'))
                            <a href="{{ route('cafeto.' . getRoleRouteName(Route::currentRouteName()) . '.formulations.create') }}"
                               class="btn btn-dark btn-sm me-1" style="background:rgba(0, 0, 0, 0.71); color: #fff; border: 1px solid #333333;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Tooltip_Create') }}">
                                <i class="fa-solid fa-file-circle-plus fa-fade mr-2"></i>{{ trans('cafeto::formulations.Create New Formulation') }}
                            </a>
                        @endif
                        <button class="btn btn-export btn-sm me-1" onclick="exportTable('csv')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Tooltip_Export_CSV') }}">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                        <button class="btn btn-export btn-sm" onclick="exportTable('pdf')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Tooltip_Export_PDF') }}">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <hr style="border-color: #333333;">

            <div class="filter-bar" data-aos="fade-down" data-aos-delay="100">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #333333; color: #fff;"><i class="fas fa-search"></i></span>
                            <input type="text" id="filter-element" class="form-control" style="background: #2a2a2a; color: #fff; border-color: #333333;" placeholder="{{ trans('cafeto::formulations.Filter_Element') }}" oninput="filterTable()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #333333; color: #fff;"><i class="fas fa-filter"></i></span>
                            <select id="filter-status" class="form-select" style="background: #2a2a2a; color: #fff; border-color: #333333;" onchange="filterTable()">
                                <option value="">{{ trans('cafeto::formulations.All_Statuses') }}</option>
                                <option value="approved">{{ trans('cafeto::formulations.Approved') }}</option>
                                <option value="pending">{{ trans('cafeto::formulations.Pending') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #333333; color: #fff;"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" id="filter-date" class="form-control" style="background: #2a2a2a; color: #fff; border-color: #333333;" oninput="filterTable()">
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" data-aos="fade-in" style="background: #2a2a2a; color: #fff; border-color: #333333;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($formulations->isEmpty())
                <p class="text-center" data-aos="fade-in" style="color: #fff;">{{ trans('cafeto::formulations.No formulations found') }}</p>
            @else
                <div class="table-responsive px-1" data-aos="zoom-in">
                    <table class="table table-bordered table-dark" id="tableFormulations" style="border-color: #333333;">
                        <thead class="sticky-header">
                            <tr>
                                <th>{{ trans('cafeto::formulations.Element') }}</th>
                                <th class="text-center">{{ trans('cafeto::formulations.Amount') }}</th>
                                <th><i class="fa-solid fa-calendar-days"></i> {{ trans('cafeto::formulations.Date') }}</th>
                                <th>{{ trans('cafeto::formulations.Status') }}</th>
                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Actions') }}">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formulations as $formulation)
                                <tr class="table-row" onclick="toggleDetails(this, {{ $formulation->id }})" style="background: #1a1a1a; color: #fff;">
                                    <td>{{ $formulation->element ? $formulation->element->name : trans('cafeto::formulations.None') }}</td>
                                    <td class="text-center">{{ $formulation->amount }}</td>
                                    <td>{{ $formulation->date }}</td>
                                    <td>
                                        <span class="status-badge badge {{ $formulation->proccess === 'approved' ? 'bg-dark' : 'bg-secondary' }}" style="background: {{ $formulation->proccess === 'approved' ? '#000000' : '#4a4a4a' }};">
                                            {{ $formulation->proccess }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : (Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') ? 'instructor' : 'cashier')) . '.formulations.show', $formulation->id) }}"
                                           class="btn btn-outline-light btn-sm py-0" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ trans('cafeto::formulations.View') }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') || Auth::user()->roles->pluck('slug')->contains('cafeto.instructor'))
                                            <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.edit', $formulation->id) }}"
                                               class="btn btn-outline-light btn-sm py-0" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ trans('cafeto::formulations.Edit') }}">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.destroy', $formulation->id) }}"
                                                  method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-light btn-sm py-0" onclick="return confirm('{{ trans('cafeto::formulations.Are you sure?') }}')"
                                                        data-bs-toggle="tooltip" data-bs-placement="right" title="{{ trans('cafeto::formulations.Delete') }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @if ($formulation->proccess !== 'approved')
                                                <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.approve', $formulation->id) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-light btn-sm py-0" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ trans('cafeto::formulations.Approve') }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr class="details-row" id="details-{{ $formulation->id }}">
                                    <td colspan="5">
                                        <div class="p-3">
                                            <h6 style="color: #fff;">{{ trans('cafeto::formulations.Ingredients') }}</h6>
                                            <ul style="color: #fff;">
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
                        <h6 style="color: #fff;">{{ $formulation->element ? $formulation->element->name : trans('cafeto::formulations.None') }}</h6>
                        <p style="color: #fff;"><strong>{{ trans('cafeto::formulations.Amount') }}:</strong> {{ $formulation->amount }}</p>
                        <p style="color: #fff;"><strong>{{ trans('cafeto::formulations.Date') }}:</strong> {{ $formulation->date }}</p>
                        <p style="color: #fff;"><strong>{{ trans('cafeto::formulations.Status') }}:</strong>
                            <span class="status-badge badge {{ $formulation->proccess === 'approved' ? 'bg-dark' : 'bg-secondary' }}" style="background: {{ $formulation->proccess === 'approved' ? '#000000' : '#4a4a4a' }};">
                                {{ $formulation->proccess }}
                            </span>
                        </p>
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : (Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') ? 'instructor' : 'cashier')) . '.formulations.show', $formulation->id) }}"
                               class="btn btn-outline-light btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.View') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') || Auth::user()->roles->pluck('slug')->contains('cafeto.instructor'))
                                <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.edit', $formulation->id) }}"
                                   class="btn btn-outline-light btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Edit') }}">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.destroy', $formulation->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-light btn-sm me-1" onclick="return confirm('{{ trans('cafeto::formulations.Are you sure?') }}')"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Delete') }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @if ($formulation->proccess !== 'approved')
                                    <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.approve', $formulation->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('cafeto::formulations.Approve') }}">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="mobile-details mt-2" id="mobile-details-{{ $formulation->id }}" style="display: none; color: #fff;">
                            <h6>{{ trans('cafeto::formulations.Ingredients') }}</h6>
                            <ul>
                                @foreach ($formulation->ingredients ?? [] as $ingredient)
                                    <li>{{ $ingredient->element->name }}: {{ $ingredient->amount }} {{ $ingredient->unit }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button class="btn btn-link" style="color: #fff;" onclick="toggleMobileDetails({{ $formulation->id }})">{{ trans('cafeto::formulations.Show_Details') }}</button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@include('cafeto::layouts.partials.plugins.datatables')

@push('scripts')
    <script src="{{ asset('libs/AOS-2.3.1/dist/aos.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init();
            var dataTableOptions = {
                pageLength: 10,
                order: [[2, 'desc']],
            };
            if ('{{ session('lang') }}' === 'es') {
                dataTableOptions.language = language_datatables;
            }
            $('#tableFormulations').DataTable(dataTableOptions);
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });

        function toggleDetails(row, id) {
            const detailsRow = document.getElementById(`details-${id}`);
            detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
        }

        function toggleMobileDetails(id) {
            const details = document.getElementById(`mobile-details-${id}`);
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        }

        function filterTable() {
            const elementFilter = document.getElementById('filter-element').value.toLowerCase();
            const statusFilter = document.getElementById('filter-status').value.toLowerCase();
            const dateFilter = document.getElementById('filter-date').value;
            const rows = document.querySelectorAll('#tableFormulations tbody tr.table-row');
            const mobileCards = document.querySelectorAll('.mobile-card');

            rows.forEach(row => {
                const element = row.cells[0].textContent.toLowerCase();
                const status = row.cells[3].textContent.toLowerCase();
                const date = row.cells[2].textContent;
                const show = (!elementFilter || element.includes(elementFilter)) &&
                            (!statusFilter || status.includes(statusFilter)) &&
                            (!dateFilter || date.includes(dateFilter));
                row.style.display = show ? '' : 'none';
                document.getElementById(`details-${row.cells[4].querySelector('a').href.split('/').pop()}`).style.display = 'none';
            });

            mobileCards.forEach(card => {
                const element = card.querySelector('h6').textContent.toLowerCase();
                const status = card.querySelector('.status-badge').textContent.toLowerCase();
                const date = card.querySelector('p:nth-child(2)').textContent.split(': ')[1];
                const show = (!elementFilter || element.includes(elementFilter)) &&
                            (!statusFilter || status.includes(statusFilter)) &&
                            (!dateFilter || date.includes(dateFilter));
                card.style.display = show ? 'block' : 'none';
            });
        }

        function exportTable(format) {
            const table = document.getElementById('tableFormulations');
            const rows = table.querySelectorAll('tr.table-row');
            if (format === 'csv') {
                let csv = 'Element,Amount,Date,Status\n';
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    csv += `"${cells[0].textContent}",${cells[1].textContent},${cells[2].textContent},${cells[3].textContent}\n`;
                });
                const blob = new Blob([csv], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'formulations.csv';
                a.click();
                window.URL.revokeObjectURL(url);
            } else if (format === 'pdf') {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                doc.setFontSize(16);
                doc.text('Formulations List', 10, 10);
                doc.setFontSize(12);
                let y = 20;
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    doc.text(`Element: ${cells[0].textContent}`, 10, y);
                    doc.text(`Amount: ${cells[1].textContent}`, 60, y);
                    doc.text(`Date: ${cells[2].textContent}`, 90, y);
                    doc.text(`Status: ${cells[3].textContent}`, 130, y);
                    y += 10;
                });
                doc.save('formulations.pdf');
            }
        }
    </script>
@endpush