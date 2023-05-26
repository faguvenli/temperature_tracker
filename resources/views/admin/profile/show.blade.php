@extends('admin._layouts.master')

@section('title') Profil @endsection

@section('css')

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">PROFİL</h4>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-3">
                            <label>Yetki</label>
                            <div class="form-control">{!! $user->getRoleNames()->first() !!}</div>
                        </div>
                        <div class="mb-3">
                            <label>Adı</label>
                            <div class="form-control">{{$user->name}}</div>
                        </div>
                        <div class="mb-3">
                            <label>TC Kimlik No</label>
                            <div class="form-control">{{$user->tcKimlikNo}}</div>
                        </div>
                        <div class="mb-3">
                            <label>Telefon</label>
                            <div class="form-control">{{$user->phone}}</div>
                            @if(!$user->phoneNumberVerified)
                                <div class="alert alert-danger mt-1">Lütfen telefon numaranızı onaylayın.</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>E-posta</label>
                            <div class="form-control">{{$user->email}}</div>
                        </div>

                        <div class="alt_button_holder">
                            <a href="{{ route('profile.edit', $user) }}" class="btn btn-danger waves-effect waves-light">
                                Düzenle
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection
@section('script-bottom')

@endsection
