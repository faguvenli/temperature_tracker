@extends('admin._layouts.master')

@section('title') Dashboard @endsection

@section('css')

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="holder env_holder mb-3">Yükleniyor...</div>
                    <livewire:env-summary></livewire:env-summary>

                    <div class="holder bag_holder mb-3">Yükleniyor...</div>
                    <livewire:bag-summary></livewire:bag-summary>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script-bottom')
    <script>

        $(document).on("click", ".device_box.device_env", function() {
            let id = $(this).attr("data-id");
            Livewire.emitTo("env-summary", 'setData', id);
        })

        $(document).on("click", ".device_box.device_bag", function() {
            let imei = $(this).attr("data-imei");
            Livewire.emitTo("bag-summary", 'setData', imei);
        })

        window.addEventListener("summary_loaded", event => {
            if(event.detail.result === "success") {
                if(event.detail.deviceType === "env") {
                    $(".bs-env_summary-modal").modal("show");
                }
                if(event.detail.deviceType === "bag") {
                    $(".bs-bag_summary-modal").modal("show");
                }

            }
        })

        function refreshFeed() {
            axios.post('{{ route('env-device-refreshFeed') }}')
                .then(result => {
                    $(".env_holder").html(result.data);
                });
            axios.post('{{ route('bag-device-refreshFeed') }}')
                .then(result => {
                    $(".bag_holder").html(result.data);
                });
        }

        refreshFeed();

        setInterval(refreshFeed, 15000);
    </script>
@endsection
