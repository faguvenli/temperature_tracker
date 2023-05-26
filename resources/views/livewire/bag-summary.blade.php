<div>
    <div wire:ignore.self class="modal fade bs-bag_summary-modal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">{{$device->device_location??null}}</h5>
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
                                                @switch($temp_value->batarya)
                                                    @case(0)
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                             style="width: 0%;"
                                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        @break
                                                    @case(25)
                                                        <div class="progress-bar bg-danger text-black" role="progressbar"
                                                             style="width: 25%;"
                                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        @break
                                                    @case(50)
                                                        <div class="progress-bar bg-warning text-black" role="progressbar"
                                                             style="width: 50%;"
                                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        @break
                                                    @case(75)
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                             style="width: 75%;"
                                                             aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        @break
                                                    @case(100)
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                             style="width: 100%;"
                                                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        @break
                                                @endswitch
                                            </div>
                                        </td>
                                        <td>{{ number_format($temp_value->isi1,1) }}°</td>
                                        <td>{{ \Carbon\Carbon::parse($temp_value->date_time)->format('d.m.Y H:i') }}</td>
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
