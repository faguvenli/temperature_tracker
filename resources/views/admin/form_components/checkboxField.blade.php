<div class="row">
    <div class="col-12">
        <div class="form-check form-switch mb-3">
            {!! Form::checkbox($name, $value, $selected, ['id' => $name, 'class' => 'form-check-input']) !!}
            {!! Form::label($name, $text, ['class' => 'form-check-label']) !!}
        </div>
    </div>
</div>
