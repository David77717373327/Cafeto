@extends('cafeto::layouts.mainPage.master-mainPage')

@push('head')
    <title>{{ __('cafeto::general.Formulations') }}</title>
    <style>
        .formulations-container {
            padding: 40px 0;
            background: #f8f1e9;
        }
        .formulations-table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            border-collapse: collapse;
        }
        .formulations-table th, .formulations-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e6d5b8;
        }
        .formulations-table th {
            background: #6b4e31;
            color: #fff;
            font-weight: 600;
        }
        .formulations-table tr:hover {
            background: #f5e9dd;
        }
        .btn-custom {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 25px;
            background-color: #6b4e31;
            color: #fff;
            border: 2px solid #6b4e31;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-custom:hover {
            background-color: #8b6f47;
            border-color: #8b6f47;
            transform: translateY(-2px);
        }
        .alert-success {
            background: #d4a373;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .alert-pending {
            background: #d9534f;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <section class="formulations-container">
        <div class="container">
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::general.Formulations') }}</h2>
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (Auth::user()->hasPermissionTo('cafeto.instructor.formulations') || Auth::user()->hasPermissionTo('cafeto.admin.formulations'))
                @php
                    $pendingCount = \Modules\AGROINDUSTRIA\Entities\Formulation::where('proccess', 'pending')->count();
                @endphp
                @if ($pendingCount > 0)
                    <div class="alert-pending">
                        Hay {{ $pendingCount }} formulaciones pendientes de aprobación.
                    </div>
                @endif
            @endif
            <table class="formulations-table">
                <thead>
                    <tr>
                        <th>{{ __('cafeto::general.Name') }}</th>
                        <th>{{ __('cafeto::general.Status') }}</th>
                        <th>{{ __('cafeto::general.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulations as $formulation)
                        <tr>
                            <td>{{ $formulation->name }}</td>
                            <td>{{ $formulation->proccess }}</td>
                            <td>
                                @if (Auth::user()->hasPermissionTo('cafeto.admin.formulations') || Auth::user()->hasPermissionTo('cafeto.instructor.formulations'))
                                    <a href="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : 'instructor') . '.formulations.show', $formulation) }}" class="btn-custom">{{ __('cafeto::general.View') }}</a>
                                    <a href="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : 'instructor') . '.formulations.edit', $formulation) }}" class="btn-custom">{{ __('cafeto::general.Edit') }}</a>
                                    @if ($formulation->proccess == 'pending')
                                        <form action="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : 'instructor') . '.formulations.approve', $formulation) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-custom">{{ __('cafeto::general.Approve') }}</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : 'instructor') . '.formulations.destroy', $formulation) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom" onclick="return confirm('¿Estás seguro de eliminar esta formulación?')">{{ __('cafeto::general.Delete') }}</button>
                                    </form>
                                @else
                                    <a href="{{ route('cafeto.cashier.formulations.show', $formulation) }}" class="btn-custom">{{ __('cafeto::general.View') }}</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($this->hasFormulationPermission())
                <div class="text-center" style="margin-top: 20px;">
                    <a href="{{ route('cafeto.' . $this->getRedirectRoute() . '.formulations.create') }}" class="btn-custom">{{ __('cafeto::general.Create Formulation') }}</a>
                </div>
            @endif
        </div>
    </section>
@endsection