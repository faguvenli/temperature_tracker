@extends('admin._layouts.master')

@section('title')
    Rapor
@endsection

@section('css')

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">RAPOR</h4>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'report.create', 'id' => 'reportForm']) !!}

                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            {!! Form::date('date_from', null, ['class' => 'form-control'.($errors->has('date_from') ? ' is-invalid ' : null), 'placeholder' => 'Başlangıç Tarihi']) !!}
                            {!! Form::label('date_from', 'Başlangıç Tarihi', ['class' => 'form-label']) !!}
                            @error('date_from')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            {!! Form::date('date_to', null, ['class' => 'form-control'.($errors->has('date_to') ? ' is-invalid ' : null), 'placeholder' => 'Bitiş Tarihi']) !!}
                            {!! Form::label('date_to', 'Bitiş Tarihi', ['class' => 'form-label']) !!}
                            @error('date_to')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            {!! Form::select('device_type', ["Çevre Cihazları" => "Çevre Cihazları", "Çanta Cihazları" => "Çanta Cihazları"], null, ["class" => "form-control form-select ".($errors->has('device_type') ? 'is-invalid' : '')]) !!}
                            {!! Form::label('device_type', 'Cihaz Tipi', ['class' => 'form-label']) !!}
                            @error('device_type')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            {!! Form::select('report_type', ["Anomali Raporu" => "Anomali Raporu", "Tam Rapor" => "Tam Rapor"], null, ["class" => "form-control form-select".($errors->has('report_type') ? 'is-invalid' : '')]) !!}
                            {!! Form::label('report_type', 'Rapor Tipi', ['class' => 'form-label']) !!}
                            @error('report_type')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="alt_button_holder">
                    <button type="submit" class="btn btn-primary">Rapor Oluştur</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div id="report">
        @include('admin.report.display', ['reports' => $reports])
    </div>

@endsection
@section('script')

@endsection
@section('script-bottom')
    <script>
        $("#reportForm").on("submit", function (e) {
            e.preventDefault();
            let form = document.getElementById('reportForm');
            let data = new FormData(form);
            axios.post('{{route('report.create')}}', data)
                .then((response) => {
                    if(response.data.status.status ==="success") {
                        $("#report").empty().html(response.data.html);
                    } else {
                        $.alert(response.data.status.message);
                    }
                })
        })
    </script>
@endsection
