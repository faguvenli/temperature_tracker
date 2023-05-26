@if(in_array($battery_status, ["Kapatılacak", "Pili Değiştirin", "Pilde Sorun Var", "Aşırı Güç"]))
    <div></div>
@endif
@if($battery_status >= 10 && $battery_status < 20)
    <div class="progress-bar bg-danger" role="progressbar"
         style="width: 10%;"
         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
@endif
@if($battery_status >= 20 && $battery_status < 50)
    <div class="progress-bar bg-danger text-black" role="progressbar"
         style="width: 20%;"
         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
@endif
@if($battery_status >= 50 && $battery_status < 80)
    <div class="progress-bar bg-warning text-black" role="progressbar"
         style="width: 50%;"
         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
@endif
@if($battery_status >= 80 && $battery_status < 100)
    <div class="progress-bar bg-success" role="progressbar"
         style="width: 80%;"
         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
@endif
@if($battery_status >= 100)
    <div class="progress-bar bg-success" role="progressbar"
         style="width: 100%;"
         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@endif
