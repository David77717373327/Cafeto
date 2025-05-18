@extends('cafeto::layouts.mainPage.master-mainPage')

@push('head')
    <title>{{ __('cafeto::general.Edit Formulation') }}</title>
    <style>
        .formulations-container {
            padding: 40px 0;
            background: #f8f1e9;
        }
        .formulation-form {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 800px;
            margin: 0 auto;
        }
        .formulation-form label {
            font-weight: 600;
            color: #4a3721;
            margin-bottom: 5px;
            display: block;
        }
        .formulation-form input, .formulation-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #e6d5b8;
            border-radius: 5px;
            font-size: 16px;
        }
        .ingredient-group {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .ingredient-group select, .ingredient-group input {
            flex: 1;
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
            cursor: pointer;
        }
        .btn-custom:hover {
            background-color: #8b6f47;
            border-color: #8b6f47;
            transform: translateY(-2px);
        }
        .alert-danger {
            background: #d9534f;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <section class="formulations-container">
        <div class="container">
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::general.Edit Formulation') }}: {{ $formulation->name }}</h2>
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('cafeto.' . (Auth::user()->hasPermissionTo('cafeto.admin.formulations') ? 'admin' : 'instructor') . '.formulations.update', $formulation) }}" method="POST" class="formulation-form">
                @csrf
                <div>
                    <label>{{ __('cafeto::general.Name') }}:</label>
                    <input type="text" name="name" value="{{ $formulation->name }}" required>
                </div>
                <div>
                    <label>{{ __('cafeto::general.Element') }} ({{ __('cafeto::general.Optional') }}):</label>
                    <select name="element_id">
                        <option value="">{{ __('cafeto::general.None') }}</option>
                        @foreach ($elements as $element)
                            <option value="{{ $element->id }}" {{ $formulation->element_id == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>{{ __('cafeto::general.Amount') }}:</label>
                    <input type="number" name="amount" step="0.01" value="{{ $formulation->amount }}" required>
                </div>
                <div>
                    <label>{{ __('cafeto::general.Date') }}:</label>
                    <input type="date" name="date" value="{{ $formulation->date }}" required>
                </div>
                <div>
                    <h3>{{ __('cafeto::general.Ingredients') }}</h3>
                    <div id="ingredients">
                        @foreach ($formulation->ingredients as $index => $ingredient)
                            <div class="ingredient-group">
                                <select name="ingredients[{{ $index }}][element_id]" required>
                                    @foreach ($elements as $element)
                                        <option value="{{ $element->id }}" {{ $ingredient->element_id == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="ingredients[{{ $index }}][amount]" step="0.01" value="{{ $ingredient->amount }}" required placeholder="{{ __('cafeto::general.Amount') }}">
                                <select name="ingredients[{{ $index }}][unit]" required>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit['abbreviation'] }}">{{ $unit['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addIngredient()" class="btn-custom">{{ __('cafeto::general.Add Ingredient') }}</button>
                </div>
                <div class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn-custom">{{ __('cafeto::general.Update') }}</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        let ingredientCount = {{ count($formulation->ingredients) }};
        function addIngredient() {
            const container = document.getElementById('ingredients');
            const div = document.createElement('div');
            div.className = 'ingredient-group';
            div.innerHTML = `
                <select name="ingredients[${ingredientCount}][element_id]" required>
                    @foreach ($elements as $element)
                        <option value="{{ $element->id }}">{{ $element->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="ingredients[${ingredientCount}][amount]" step="0.01" required placeholder="{{ __('cafeto::general.Amount') }}">
                <select name="ingredients[${ingredientCount}][unit]" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit['abbreviation'] }}">{{ $unit['name'] }}</option>
                    @endforeach
                </select>
            `;
            container.appendChild(div);
            ingredientCount++;
        }
    </script>
@endsection