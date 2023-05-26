<div class="row">
    <div class="col-12 mb-3">
        <div class="form-floating">
            <select
                class="form-control form-select select2 {{ $errors->has($name) ? 'is-invalid' : '' }}"
                placeholder="{{$text}}"
                data-placeholder="{{$text}} Seçin"
                name="{{$name}}" id="{{$name}}">
                <option></option>
                @foreach($values as $value)
                    <option
                        value="{{ $value->id }}" {{ (old($name, $selected) == $value->id ? "selected":null) }}>{{ $value->name }}</option>
                @endforeach
            </select>
            <label for="role" class="form-label">{{ $text }}</label>
            @if($errors->has($name))
                <div class="invalid-feedback">
                    {{ $errors->first($name) }}
                </div>
            @endif
        </div>
    </div>
</div>
