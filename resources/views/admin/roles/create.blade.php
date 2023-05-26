@extends('admin._layouts.master')

@section('title')
    Yetki Ekle
@endsection

@section('css')

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Yetkiler</a></li>
                    <li class="breadcrumb-item active">Ekle</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'roles.store'])!!}

                    {!! Form::textField('name', 'Adı') !!}

                    @foreach($permission_groups as $section_name => $pg)
                        <div class="card">
                            <div class="card-header">
                                <h5>{{$section_name}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    @foreach($pg as $key => $permission_group)
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="card">
                                                <div class="card-header">{{$key}}</div>
                                                <div class="card-body border-1 border shadow-sm">
                                                    @foreach($permission_group as $permission_id => $permission)
                                                        <div class="form-check form-check-primary mb-3">
                                                            <input class="form-check-input" type="checkbox" id="permissions{{$permission_id}}" name="permissions[]" @if(in_array($permission_id, old('permissions', []))) checked @endif value="{{ $permission_id }}">
                                                            <label class="form-check-label" for="permissions{{$permission_id}}">
                                                                {{ $permission }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

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

@endsection
@section('script-bottom')


@endsection
