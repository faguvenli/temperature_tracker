@extends('admin._layouts.master')

@section('title')
    Bölge Düzenle
@endsection

@section('css')
    <link href="{{ asset('admin_assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Bölgeler</a></li>
                    <li class="breadcrumb-item active">Düzenle</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model($region, ['route' => ['regions.update', $region->id], 'method' => 'PATCH'])!!}

                    {!! Form::selectField('device_type', 'Cihaz Tipi', $deviceTypes, $region->device_type) !!}

                    {!! Form::textField('name', 'Bölge') !!}

                    <div class="alt_button_holder">
                        <button type="button" class="btn btn-danger delete_btn" data-route="{{ route('regions.destroy', $region->id) }}">Sil</button>
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
    <script>
        $(document).on("click", ".delete_btn", function (e) {
            e.preventDefault();
            new Confirmation.default(
                {
                    title: 'Bölge Sil',
                    route: $(this).attr('data-route')
                }
            )
        })
    </script>
@endsection
