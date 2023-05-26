@extends('admin._layouts.master')

@section('title') Kullanıcılar @endsection

@section('css')

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">KULLANICILAR</h4>
            </div>
        </div>
    </div>

    {{ $dataTable->table() }}
    <div class="main_button_holder">
        <a href="{{ route('users.create') }}" class="btn btn-danger waves-effect waves-light">
            Yeni Kullanıcı Ekle
        </a>
    </div>

@endsection
@section('script')

@endsection
@section('script-bottom')
    {{ $dataTable->scripts() }}
@endsection
