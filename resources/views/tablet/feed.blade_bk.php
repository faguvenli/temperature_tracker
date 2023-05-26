@foreach($temp_values->groupBy('region_name') as $tmp_values)

    @foreach($tmp_values as $temp_value)

        <div data-id="{{ $temp_value->id }}"
             class="device_box @if(($temp_value->temperature && $temp_value->temperature < $temp_value->temperature_min or $temp_value->temperature > $temp_value->temperature_max) and $temp_value->difference < 8) red @endif ">


            <div class="device_name">{{ $temp_value->name }}</div>
            <div class="inner_holder">
                <div class="left_column">
                    <div class="temperature text-white">Isı: <span>{{ number_format($temp_value->temperature,1) }}°
                    @if($temp_value->old_temperature)
                                @if(number_format($temp_value->temperature,1) < number_format($temp_value->old_temperature,1))
                                    <i class="bx bx-chevron-down" style="color:dodgerblue"></i>
                                @else
                                    <i class="bx bx-chevron-up" style="color:red;"></i>
                                @endif
                            @else
                                <i style="color:green;">-</i>
                            @endif
                    </span>
                    </div>
                    <div class="humidity text-white">
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
                    </div>
                </div>
                <div class="d-flex align-items-end flex-column right_column">
                    <div class="progress progress-lg position-relative mb-1">

                        @include('admin.env-devices.battery_level', ['battery_status' => $temp_value->battery])

                    </div>

                    @if($temp_value->difference > 10)
                        <span class="text-danger"><strong>Offline</strong></span>
                    @else
                        <span class="text-success"><strong>Online</strong></span>
                    @endif
                </div>
            </div>







        </div>
    @endforeach
@endforeach
