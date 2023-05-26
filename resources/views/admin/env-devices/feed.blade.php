@foreach($temp_values->groupBy('region_name') as $tmp_values)
    <h5 class="w-100 my-3">{{ ($temp_values->first())->region_name??'Bölge Yok' }}</h5>

    @foreach($tmp_values as $temp_value)

        <div data-id="{{ $temp_value->id }}"
             class="device_box device_env @if(($temp_value->temperature && $temp_value->temperature < $temp_value->temperature_min or $temp_value->temperature > $temp_value->temperature_max) and $temp_value->difference < 8) red @endif">
            <div>
                {{ $temp_value->name }}<br>
                Isı: <span>{{ number_format($temp_value->temperature,1) }}°
            @if($temp_value->old_temperature)
                        @if(number_format($temp_value->temperature,1) < number_format($temp_value->old_temperature,1))
                            <i class="bx bx-chevron-down" style="color:dodgerblue"></i>
                        @else
                            <i class="bx bx-chevron-up" style="color:red;"></i>
                        @endif
                    @else
                        <i style="color:green;">-</i>
                    @endif
            </span><br>
                Nem: <span>{!! number_format($temp_value->humidity) !!}
                    @if($temp_value->old_humidity)
                        @if(number_format($temp_value->humidity,1) < number_format($temp_value->old_humidity,1))
                            <i class="bx bx-chevron-down" style="color:dodgerblue"></i>
                        @else
                            <i class="bx bx-chevron-up" style="color:red;"></i>
                        @endif
                    @else
                        <i style="color:green;">-</i>
                    @endif
            </span>
                </span>
            </div>
            <div class="d-flex align-items-end flex-column">
                <div class="d-flex align-items-center gap-1">
                    @if(in_array($temp_value->battery, ["Kapatılacak", "Pili Değiştirin", "Pilde Sorun Var", "Aşırı Güç"]))
                        <span class="badge bg-danger">{{ $temp_value->battery }}</span>
                    @endif
                    <div class="progress progress-lg position-relative">
                        @include('admin.env-devices.battery_level', ['battery_status' => $temp_value->battery])
                    </div>
                </div>
                @if($temp_value->difference > 10)
                    <span class="text-danger">Offline</span>
                @else
                    <span class="text-success">Online</span>
                @endif
            </div>
        </div>
    @endforeach
@endforeach
