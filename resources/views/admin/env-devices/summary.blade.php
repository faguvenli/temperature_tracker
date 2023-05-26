@extends('admin._layouts.master')

@section('title') Çevre Cihazları @endsection

@section('css')
    <link href="{{ asset('admin_assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    @if(auth()->user()->isSuperAdmin)
        <select id="region" class="form-select select2">
            <option value="0">Tümünü Göster</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" {{ (session()->get('env_device_region') == $region->id) ? 'selected' : null }}>
                {{$region->name}}
                </option>
            @endforeach
        </select>
    @endif
    <div class="holder mb-3">Yükleniyor...</div>
    <livewire:env-summary></livewire:env-summary>
@endsection
@section('script')
    <script src="{{ asset('admin_assets/libs/select2/select2.min.js') }}"></script>
@endsection
@section('script-bottom')
<script>
    $(document).on("change", "#region", function(e) {
        axios.post('{{route('env-device-setRegion')}}', {region:$(this).val()})
            .then(() => {
                $(".holder").html("Yükleniyor...");
                refreshFeed();
            })
    })

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
                $(".holder").html(result.data);
            });
    }

    refreshFeed();

    setInterval(refreshFeed, 15000);
</script>
@endsection
