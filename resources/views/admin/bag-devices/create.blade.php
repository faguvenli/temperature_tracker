@extends('admin._layouts.master')

@section('title')
    Çanta Cihazı Ekle
@endsection

@section('css')
    <link href="{{ asset('admin_assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('bag-devices.index') }}">Çanta Cihazları</a></li>
                    <li class="breadcrumb-item active">Ekle</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'bag-devices.store'])!!}

                    {!! Form::textField('serial_number', 'Seri Numarası') !!}
                    {!! Form::selectField('region_id', 'Bölge', $regions) !!}
                    {!! Form::selectField('bag_device_type_id', 'Cihaz Tipi', $bagDeviceTypes) !!}
                    {!! Form::textField('device_model', 'Cihaz Modeli') !!}
                    {!! Form::textField('device_mac', 'Mac Adresi') !!}
                    {!! Form::textField('device_location', 'Cihaz Konumu') !!}
                    {!! Form::numberField('temperature_calibration_trim', 'Isı Değeri Kalibrasyon') !!}
                    {!! Form::numberField('temperature_max', 'Isı Maksimum Alarm') !!}
                    {!! Form::numberField('temperature_min', 'Isı Minimum Alarm') !!}

                    <div class="alt_button_holder">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('admin_assets/libs/select2/select2.min.js') }}"></script>
@endsection
@section('script-bottom')


@endsection
