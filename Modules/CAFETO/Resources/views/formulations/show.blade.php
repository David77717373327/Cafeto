@extends('cafeto::layouts.mainPage.master-mainPage')

@push('head')
    <title>{{ __('cafeto::general.Formulation Details') }}</title>
    <style>
        .formulations-container {
            padding: 40px 0;
            background: #f8f1e9;
        }
        .formulation-details {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 800px;
            margin: 0 auto;
        }
        .formulation-details h3 {
            color: #4a3721;
            margin-bottom: 20px;
        }
        .formulation-details p {
            color: #6b4e31;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .formulation-details ul {
            list-style: none;
            padding: 0;
        }
        .formulation-details ul li {
            color: #6b4e31;
            margin-bottom: 10px;
            font-size: 16px;
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
    </style>
@endpush

@section('content')
    <section class="formulations-container">
        <div class="container">
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::general.Formulation Details') }}: {{ $formulation->element ? $formulation->element->name : __('cafeto::general.None') }}</h2>
            <div class="formulation-details">
                <p><strong>{{ __('cafeto::general.Status') }}:</strong> {{ $formulation->proccess }}</p>
                <p><strong>{{ __('cafeto::general.Amount') }}:</strong> {{ $formulation->amount }} {{ __('cafeto::general.units') }}</p>
                <p><strong>{{ __('cafeto::general.Date') }}:</strong> {{ $formulation->date }}</p>
                <p><strong>{{ __('cafeto::general.Element') }}:</strong> {{ $formulation->element ? $formulation->element->name : __('cafeto::general.None') }}</p>
                <h3>{{ __('cafeto::general.Ingredients') }}</h3>
                <ul>
                    @foreach ($formulation->ingredients as $ingredient)
                        <li>{{ $ingredient->element->name }}: {{ $ingredient->amount }} {{ __('cafeto::general.units') }}</li>
                    @endforeach
                </ul>
                <div class="text-center" style="margin-top: 20px;">
                    <a href="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : (Auth::user()->hasPermissionTo('cafeto.instructor.formulations') ? 'instructor' : 'cashier')) . '.formulations.index') }}" class="btn-custom">{{ __('cafeto::general.Back') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
