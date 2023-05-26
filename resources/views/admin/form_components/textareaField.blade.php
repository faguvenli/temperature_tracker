<div class="row">
    <div class="col-12 mb-3 {{ $attributes['class']??null }}">
        <div class="form-floating">
            {!! Form::textarea($name, $value, ['class' => 'form-control '.($attributes["custom_class"]??null).' '.($errors->has($name) ? ' is-invalid ' : null), 'placeholder' => $text, 'style'=>'height:150px;']) !!}
            @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
