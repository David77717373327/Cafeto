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
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::general.Edit Formulation') }}: {{ $formulation->element ? $formulation->element->name : __('cafeto::general.None') }}</h2>
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.update', $formulation) }}" method="POST" class="formulation-form">
                @csrf
                @method('POST')
               <div>
    <label>{{ __('cafeto::general.Element') }}:</label>
    <select name="element_id">
        <option value="">{{ __('cafeto::general.None') }}</option>
        @foreach ($elements as $element)
            <option value="{{ $element->id }}" {{ old('element_id', $formulation->element_id) == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
        @endforeach
    </select>
    @error('element_id')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
                <div>
                    <label>{{ __('cafeto::general.Amount') }}:</label>
                    <input type="number" name="amount" value="{{ old('amount', $formulation->amount) }}" required min="0" step="0.01">
                </div>
                <div>
                    <label>{{ __('cafeto::general.Date') }}:</label>
                    <input type="date" name="date" value="{{ old('date', $formulation->date) }}" required>
                </div>
                <div>
                    <h3>{{ __('cafeto::general.Ingredients') }}</h3>
                    <div id="ingredients">
                        @foreach ($formulation->ingredients as $index => $ingredient)
                            <div class="ingredient-group">
                                <select name="ingredients[{{ $index }}][element_id]" required>
                                    @foreach ($elements as $element)
                                        <option value="{{ $element->id }}" {{ old("ingredients.$index.element_id", $ingredient->element_id) == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="ingredients[{{ $index }}][amount]" value="{{ old("ingredients.$index.amount", $ingredient->amount) }}" required placeholder="{{ __('cafeto::general.Amount') }}" min="0" step="0.01">
                                <select name="ingredients[{{ $index }}][unit]" required>
                                    <option value="g" {{ old("ingredients.$index.unit", $ingredient->unit) == 'g' ? 'selected' : '' }}>{{ __('cafeto::general.Grams') }}</option>
                                    <option value="mg" {{ old("ingredients.$index.unit", $ingredient->unit) == 'mg' ? 'selected' : '' }}>{{ __('cafeto::general.Milligrams') }}</option>
                                    <option value="ml" {{ old("ingredients.$index.unit", $ingredient->unit) == 'ml' ? 'selected' : '' }}>{{ __('cafeto::general.Milliliters') }}</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addIngredient()" class="btn-custom">{{ __('cafeto::general.Add Ingredient') }}</button>
                </div>
                <div class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn-custom">{{ __('cafeto::general.Update') }}</button>
                    <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.index') }}" class="btn-custom">{{ __('cafeto::general.Back') }}</a>
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
                <input type="number" name="ingredients[${ingredientCount}][amount]" required placeholder="{{ __('cafeto::general.Amount') }}" min="0" step="0.01">
                <select name="ingredients[${ingredientCount}][unit]" required>
                    <option value="g">{{ __('cafeto::general.Grams') }}</option>
                    <option value="mg">{{ __('cafeto::general.Milligrams') }}</option>
                    <option value="ml">{{ __('cafeto::general.Milliliters') }}</option>
                </select>
            `;
            container.appendChild(div);
            ingredientCount++;
        }
    </script>
@endsection