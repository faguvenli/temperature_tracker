@extends('admin._layouts.master-without-nav-personel')
@section('title') Çevre Modül @endsection
@section('css')
    <style>
        .device_name {
            background-color: #264f74;
            margin-bottom: 5px;
            font-size: 12px;
            color: white;
            padding: 5px;
        }

        .temperature {
            color: white;
            font-size: 25px;
        }

        .humidity {
            color: white;
            font-size: 20px;
        }

        .device_box {
            background-color: black;
            padding: 10px !important;
            display: flex;
            flex-grow: 1;
            flex-direction: column;
            border: 2px solid #4b4b4b !important;
            border-radius: 10px !important;
        }
        .device_box:hover {
            background-color: black !important;
        }

        .inner_holder {
            padding: 5px;
            display: flex;
            flex-grow: 1;
        }

        .new_holder {
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 5px;
            height: 100vh;
        }

        .left_column {
            width: 180px;
        }

        .right_column {
            width: 100px;
            flex: auto;
            text-align: right;
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
