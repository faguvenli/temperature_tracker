@extends('admin._layouts.master')

@section('title')
    Kullanıcı Ekle
@endsection

@section('css')
    <link href="{{ asset('admin_assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kullanıcılar</a></li>
                    <li class="breadcrumb-item active">Ekle</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'users.store'])!!}
                    <div class="row">
                        <div class="col-auto">
                            {!! Form::checkboxField('active', 'Aktif', 1, true) !!}
                        </div>
                        <div class="col-auto">
                            {!! Form::checkboxField('isPanelUser', 'Panel Erişimi', 1) !!}
                        </div>
                        <div class="col-auto">
                            {!! Form::checkboxField('send_sms_notification', 'SMS Bildirimi', 1) !!}
                        </div>
                        <div class="col-auto">
                            {!! Form::checkboxField('send_email_notification', 'E-posta Bildirimi', 1) !!}
                        </div>
                    </div>


                    {!! Form::selectField('role', 'Yetki', $roles) !!}

                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <select id="region" multiple class="form-control select2 @error('region') is-invalid @enderror"
                                        placeholder="Bölge"
                                        name="region[]">
                                    @foreach($regions as $region)
                                        <option
                                            value="{{$region->id}}" @if(in_array($region->id, old('region', []))) selected @endif>{{$region->name}} {{$region->device_type}}</option>
                                    @endforeach
                                </select>
                                <label for="region" class="form-label">Bölge</label>
                                @error('region')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {!! Form::selectField('tenant_id', 'Kurum', $tenants) !!}
                    {!! Form::textField('name', 'Adı') !!}
                    {!! Form::textField('tcKimlikNo', 'TC Kimlik No') !!}
                    {!! Form::textField('phone', 'Telefon') !!}
                    {!! Form::textField('email', 'E-posta') !!}
                    {!! Form::passwordField('password', 'Parola') !!}

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
