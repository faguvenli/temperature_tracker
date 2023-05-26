@foreach($temp_values->groupBy('region_name') as $tmp_values)
    <h5 class="w-100 my-3">{{ ($tmp_values->first())->region_name??'Bölge Yok' }}</h5>
    @foreach($tmp_values as $temp_value)

        <div data-imei="{{ $temp_value->serial_number }}"
             class="device_box device_bag @if(($temp_value->isi1 && $temp_value->isi1 < $temp_value->temperature_min or $temp_value->isi1 > $temp_value->temperature_max) and $temp_value->difference < 8) red @endif">
            <div>
                {{ $temp_value->device_location }}<br>
                <span style="font-size:20px;"> {{ number_format($temp_value->isi1,1) }}°</span>
                @if($temp_value->old_value)
                    @if(number_format($temp_value->isi1,1) < number_format($temp_value->old_value,1))
                        <i class="bx bx-chevron-down" style="color:dodgerblue"></i>
                    @else
                        <i class="bx bx-chevron-up" style="color:red;"></i>
                    @endif
                @else
                    <i style="color:green;">-</i>
                @endif


            </div>
            <div class="d-flex align-items-end flex-column">

                <div class="progress progress-lg position-relative">
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

                @if(!$temp_value->difference || $temp_value->difference > 5)
                    <span class="text-danger">Offline</span>
                    <span>{{ $temp_value->offline_time }}</span>
                @else
                    <span class="text-success">Online</span>
                @endif

            </div>
        </div>
    @endforeach
@endforeach
