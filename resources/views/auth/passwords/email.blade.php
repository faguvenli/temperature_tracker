@extends('admin._layouts.master-without-nav')

@section('title') Parolamı Sıfırla @endsection

    @section('content')
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary"> Parolamı Sıfırla</h5>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('admin_assets/images/profile-img.png') }}" alt=""
                                             class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="p-2">
                                    @if (session('status'))
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Eposta</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="useremail" name="email" placeholder="Eposta"
                                                   value="{{ old('email') }}" id="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                    type="submit">Sıfırla</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Hatırladınız mı ? <a href="{{ url('login') }}" class="fw-medium text-primary"> Giriş yapın</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
@section('script')
    <script src="{{ asset('admin_assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
