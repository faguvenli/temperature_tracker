<div class="row">
    <div class="col-12 mb-3">
        <div class="form-floating">
            {!! Form::password($name, ['class' => 'form-control'.($errors->has($name) ? ' is-invalid ' : null), 'placeholder' => $text, 'autocomplete' => 'new-password']) !!}
            {!! Form::label($name, $text, ['class' => 'form-label']) !!}
            @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
