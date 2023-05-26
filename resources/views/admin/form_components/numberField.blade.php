<div class="row">
    <div class="col-12 mb-3">
        <div class="form-floating">
            {!! Form::number($name, $value, ['class' => 'form-control'.($errors->has($name) ? ' is-invalid ' : null), 'step' => 0.001, 'placeholder' => $text, $attributes['dataAttr']??null]) !!}
            {!! Form::label($name, $text, ['class' => 'form-label']) !!}
            @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
