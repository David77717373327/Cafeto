@extends('cafeto::layouts.master')

@section('content')
    <section class="formulations-container">
        <div class="container">
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::formulations.Show') }}: {{ $formulation->element ? $formulation->element->name : __('cafeto::formulations.None') }}</h2>
            <div class="formulation-details">
                <p><strong>{{ __('cafeto::formulations.Status') }}:</strong> {{ $formulation->proccess }}</p>
                <p><strong>{{ __('cafeto::formulations.Amount') }}:</strong> {{ $formulation->amount }} {{ __('cafeto::formulations.units') }}</p>
                <p><strong>{{ __('cafeto::formulations.Date') }}:</strong> {{ $formulation->date }}</p>
                <p><strong>{{ __('cafeto::formulations.Element') }}:</strong> {{ $formulation->element ? $formulation->element->name : __('cafeto::formulations.None') }}</p>
                <h3>{{ __('cafeto::formulations.Ingredients') }}</h3>
                <ul>
                    @foreach ($formulation->ingredients as $ingredient)
                        <li>{{ $ingredient->element->name }}: {{ $ingredient->amount }} {{ __('cafeto::formulations.units') }}</li>
                    @endforeach
                </ul>
                <div class="text-center" style="margin-top: 20px;">
                    <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : (Auth::user()->roles->pluck('slug')->contains('cafeto.instructor') ? 'instructor' : 'cashier')) . '.formulations.index') }}" class="btn btn-custom">{{ __('cafeto::formulations.Back to Formulations') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
