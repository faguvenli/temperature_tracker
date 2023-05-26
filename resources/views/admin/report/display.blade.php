<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Rapor Adı</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d.m.Y H:i:s')}}</td>
                            <td>{{$report->description}}</td>
                            <td>
                                @if($report->status != 'waiting')
                                <a href="{{ asset('reports/'.auth()->user()->tenant_id.'/'.$report->name) }}" download class="btn btn-sm btn-info">İndir</a>
                                @else
                                    Hazırlanıyor
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
