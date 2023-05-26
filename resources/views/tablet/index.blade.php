@extends('admin._layouts.master-without-nav-personel')
@section('title') Çevre Modül @endsection
@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <style>
        html {
            height: 100%;
        }
        body {
            background: black;
            font-family:  'Roboto Condensed', sans-serif !important;
        }
        .new_holder {
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content:  space-between;
            gap:  5px;
            height: 100vh;
        }
        .device_box {
            display: flex;
            width: 20%;
            padding:  10px;
            flex-grow: 1;
            flex-direction:  column;
            background-color: #d3f7f5;
        }
        .device_name {
            color: #3f868c;
        }
        .value_holder {

            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            flex-grow: 1;

        }
        .value {
            display: flex;
            text-align: center;
            color: #000000;
            font-size: 100px;
            align-items: flex-end;
            letter-spacing: -2px;
        }
        .value .icon {
            font-size: 30px;
        }
        .value.humidity {
            font-size: 50px;
        }
        .separator {
            width: 80%;
            border-bottom: 1px solid #3f868c;
        }
    </style>

@endsection
@section('content')
    <div class="new_holder mb-3">Yükleniyor...</div>
    <livewire:env-summary></livewire:env-summary>
@endsection

@section('script')

@endsection

@section('script-bottom')
    <script>

        $(document).on("click", ".device_box", function() {
            let id = $(this).attr("data-id");
            Livewire.emitTo("env-summary", 'setData', id);
        })

        window.addEventListener("summary_loaded", event => {
            if(event.detail.result === "success") {
                $(".bs-env_summary-modal").modal("show");
            }
        })

        function refreshFeed() {
            axios.post('{{ route('env-device-refreshFeed') }}')
                .then(result => {
                    $(".new_holder").html(result.data);
                });
        }

        refreshFeed();

        setInterval(refreshFeed, 15000);

    </script>
@endsection
