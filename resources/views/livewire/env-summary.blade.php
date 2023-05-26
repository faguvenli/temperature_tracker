<div>
    <div wire:ignore.self class="modal fade bs-env_summary-modal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title text-primary">{{$device->name??null}}</h5>
                        <small>{{$device->device_mac??null}}</small>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            @if($recordCount >= 10)
                                <div class="mb-1">Normal değerlerin dışına çıkan toplam {{ $recordCount }} kayıttan son {{ $recordCount>10?10:$recordCount }} tanesi listelenmiştir.</div>
                            @else
                                <div class="mb-1">Normal değerlerin dışına çıkan toplam {{ $recordCount }} kayıt listelenmiştir.</div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th>Batarya</th>
                                <th>Isı</th>
                                <th>Tarih</th>
                                </thead>
                                <tbody>
                                @foreach($temp_values as $temp_value)
                                    <tr>
                                        <td>
                                            <div class="progress progress-lg position-relative" style="max-width:30px;">
                                                @include('admin.env-devices.battery_level', ['battery_status' => batteryPercentage($temp_value->battery)])
                                            </div>
                                        </td>
                                        <td>{{ number_format($temp_value->temperature,1) }}°</td>
                                        <td>{{ \Carbon\Carbon::parse($temp_value->record_date)->format('d.m.Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
