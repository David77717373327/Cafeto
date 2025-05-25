@extends('cafeto::layouts.mainPage.master-mainPage')

@section('content')
    <div class="container">
        <h1>{{ $view['titlePage'] }}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($formulations->isEmpty())
            <p>{{ __('cafeto::general.No formulations found') }}</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('cafeto::general.Element') }}</th>
                        <th>{{ __('cafeto::general.Amount') }}</th>
                        <th>{{ __('cafeto::general.Date') }}</th>
                        <th>{{ __('cafeto::general.Status') }}</th>
                        <th>{{ __('cafeto::general.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulations as $formulation)
                        <tr>
                            <td>{{ $formulation->element ? $formulation->element->name : __('cafeto::general.None') }}</td>
                            <td>{{ $formulation->amount }}</td>
                            <td>{{ $formulation->date }}</td>
                            <td>{{ $formulation->proccess }}</td>
                            <td>
                                <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : (Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') ? 'instructor' : 'cashier')) . '.formulations.show', $formulation->id) }}" class="btn btn-info btn-sm">{{ __('cafeto::general.View') }}</a>
                                @if (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') || Auth::user()->roles->pluck('slug')->contains('cafeto.instructor'))
                                    <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.edit', $formulation->id) }}" class="btn btn-primary btn-sm">{{ __('cafeto::general.Edit') }}</a>
                                    <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.destroy', $formulation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('cafeto::general.Are you sure?') }}')">{{ __('cafeto::general.Delete') }}</button>
                                    </form>
                                    @if ($formulation->proccess !== 'approved')
                                        <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.approve', $formulation->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">{{ __('cafeto::general.Approve') }}</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') || Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') || Auth::user()->roles->pluck('slug')->contains('cafeto.cashier') || Auth::user()->roles->pluck('slug')->contains('cafeto.cashier_intern'))
            <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : (Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') ? 'instructor' : 'cashier')) . '.formulations.create') }}" class="btn btn-primary">{{ __('cafeto::general.Create New Formulation') }}</a>
        @endif
    </div>
@endsection