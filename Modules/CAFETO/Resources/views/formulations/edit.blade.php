<!-- Edit View -->
@extends('cafeto::layouts.master')

@section('content')
    <section class="formulations-container">
        <div class="container">
            <h2 class="heading--title text-center" style="color: #4a3721;">{{ __('cafeto::formulations.Edit') }}: {{ $formulation->element ? $formulation->element->name : __('cafeto::formulations.None') }}</h2>
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
                    <label>{{ __('cafeto::formulations.Element') }}:</label>
                    <select name="element_id">
                        <option value="">{{ __('cafeto::formulations.None') }}</option>
                        @foreach ($elements as $element)
                            <option value="{{ $element->id }}" {{ old('element_id', $formulation->element_id) == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                        @endforeach
                    </select>
                    @error('element_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>{{ __('cafeto::formulations.Amount') }}:</label>
                    <input type="number" name="amount" value="{{ old('amount', $formulation->amount) }}" required min="0" step="0.01">
                </div>
                <div>
                    <label>{{ __('cafeto::formulations.Date') }}:</label>
                    <input type="date" name="date" value="{{ old('date', $formulation->date) }}" required>
                </div>
                <div>
                    <h3>{{ __('cafeto::formulations.Ingredients') }}</h3>
                    <div id="ingredients">
                        @foreach ($formulation->ingredients as $index => $ingredient)
                            <div class="ingredient-group">
                                <select name="ingredients[{{ $index }}][element_id]" required>
                                    @foreach ($elements as $element)
                                        <option value="{{ $element->id }}" {{ old("ingredients.$index.element_id", $ingredient->element_id) == $element->id ? 'selected' : '' }}>{{ $element->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="ingredients[{{ $index }}][amount]" value="{{ old("ingredients.$index.amount", $ingredient->amount) }}" required placeholder="{{ __('cafeto::formulations.Amount') }}" min="0" step="0.01">
                                <select name="ingredients[{{ $index }}][unit]" required>
                                    <option value="g" {{ old("ingredients.$index.unit", $ingredient->unit) == 'g' ? 'selected' : '' }}>{{ __('cafeto::formulations.Grams') }}</option>
                                    <option value="mg" {{ old("ingredients.$index.unit", $ingredient->unit) == 'mg' ? 'selected' : '' }}>{{ __('cafeto::formulations.Milligrams') }}</option>
                                    <option value="ml" {{ old("ingredients.$index.unit", $ingredient->unit) == 'ml' ? 'selected' : '' }}>{{ __('cafeto::formulations.Milliliters') }}</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addIngredient()" class="btn-custom">{{ __('cafeto::formulations.Add Ingredient') }}</button>
                </div>
                <div class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn-custom">{{ __('cafeto::formulations.Update') }}</button>
                    <a href="{{ route('cafeto.' . (Auth::user()->roles->pluck('slug')->contains('cafeto.admin') ? 'admin' : 'instructor') . '.formulations.index') }}" class="btn-custom">{{ __('cafeto::formulations.Back') }}</a>
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
                <input type="number" name="ingredients[${ingredientCount}][amount]" required placeholder="{{ __('cafeto::formulations.Amount') }}" min="0" step="0.01">
                <select name="ingredients[${ingredientCount}][unit]" required>
                    <option value="g">{{ __('cafeto::formulations.Grams') }}</option>
                    <option value="mg">{{ __('cafeto::formulations.Milligrams') }}</option>
                    <option value="ml">{{ __('cafeto::formulations.Milliliters') }}</option>
                </select>
            `;
            container.appendChild(div);
            ingredientCount++;
        }
    </script>
@endsection

<!-- Show View -->
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