@extends('admin._layouts.master')

@section('title')
    Profil Düzenle
@endsection

@section('css')

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('profile.show', $user->id) }}">Profil</a></li>
                    <li class="breadcrumb-item active">Düzenle</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(!$user->phoneNumberVerified)
                        <div class="alert alert-danger">Lütfen test sms gönderme butonuna basın ve telefon numaranızı onaylayın.</div>
                    @endif
                    {!! Form::model($user, ['route' => ['profile.update', $user->id], 'method' => 'PATCH', 'autocomplete' => "off"])!!}

                    {!! Form::textField('name', 'Adı') !!}
                    {!! Form::textField('tcKimlikNo', 'TC Kimlik No') !!}
                    {!! Form::textField('phone', 'Telefon') !!}

                    {!! Form::textField('email', 'E-posta') !!}
                    {!! Form::passwordField('password', 'Parola') !!}

                    <div class="alt_button_holder">
                        @if(!$user->phoneNumberVerified)
                            <button type="button" class="btn btn-success send_test_sms">Test SMS Gönder</button>
                        @endif
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
    <script>
        $(document).on("click", ".send_test_sms", function() {
            axios.post('/send_test_sms', {userID: {{$user->id}}})
                .then(response => {
                    console.log(response.data);
                    if(response.data.status === 'error') {
                        $.alert(response.data.message);
                    } else {
                        $.confirm({
                            title: 'SMS Onay!',
                            content: '' +
                                '<form action="" class="formName">' +
                                '<div class="form-group">' +
                                '<label>Cep telefonunuza gelen kodu aşağıdaki alana giriniz.</label>' +
                                '<input type="text" id="smsConfirmation" placeholder="Sms Kodu" class="name form-control" required />' +
                                '</div>' +
                                '</form>',
                            buttons: {
                                confirm: {
                                    text: 'Kaydet',
                                    btnClass: 'btn-orange',
                                    action: function(){
                                        var input = this.$content.find('input#smsConfirmation');
                                        var errorText = this.$content.find('.text-danger');
                                        if(!input.val().trim()){
                                            $.alert({
                                                title: "Hata!",
                                                content: "Lütfen alanı boş bırakmayın.",
                                                type: 'red'
                                            });
                                            return false;
                                        }else{
                                            axios.post('/check_sms_confirmation', {code:input.val()})
                                                .then(response => {
                                                    if(response.data.status === 'success') {
                                                        $.alert(response.data.message);
                                                        document.location.reload();
                                                    } else {
                                                        $.alert(response.data.message);
                                                    }
                                                })
                                        }
                                    }
                                },
                                'Kapat': function(){
                                    // do nothing.
                                }
                            }
                        });
                    }
                });
        })

    </script>
@endsection
