@extends('admin._layouts.master')

@section('title') Çanta Cihaz Tipleri @endsection

@section('css')

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">ÇANTA CİHAZ TİPLERİ</h4>
            </div>
        </div>
    </div>

    {{ $dataTable->table() }}
    <div class="main_button_holder">
        <a href="{{ route('bag-device-types.create') }}" class="btn btn-danger waves-effect waves-light">
            Yeni Cihaz Tipi Ekle
        </a>
    </div>

@endsection
@section('script')

@endsection
@section('script-bottom')
    {{ $dataTable->scripts() }}
@endsection
