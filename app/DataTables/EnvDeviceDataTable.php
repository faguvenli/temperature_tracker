<?php

namespace App\DataTables;

use App\Models\EnvDevice;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EnvDeviceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('confirmed', function($data) {
                return $data->confirmed?'<span class="alert alert-success p-1">Onaylı</span>':'<span class="alert alert-danger p-1">Onaysız</span>';
            })
            ->editColumn('device_type', function($data) {
                $result = 'Nemli Model';
                if($data->device_type == 1) {
                    $result = 'Nemsiz Model';
                }
                return $result;
            })
            ->editColumn('name', function($data) {
                $result = $data->name;

                if(!$data->alarm_active) {
                    $result .= " (Alarm Susturuldu)";
                }
                return $result;
            })
            ->filterColumn('region', function($query, $keyword) {
                $query->whereRaw('LOWER(regions.name) like ?', ["%".strtolower($keyword)."%"]);
            })
            ->setRowData([
                'entry-id' => function ($data) {
                    return $data->id;
                }
            ])
            ->setRowAttr([
                'data-href' => function($data) {
                    return route('env-devices.edit', $data->id);
                }
            ])
            ->rawColumns(['confirmed']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EnvDevice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EnvDevice $model)
    {
        $regionDatabase = Config::get('database.connections.mysql.database');
        return $model->newQuery()
            ->select(
                'regions.name as region',
                'env_devices.*'
            )
            ->leftJoin($regionDatabase.'.regions as regions', 'regions.id', '=', 'env_devices.region_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->parameters([
                'searchDelay' => 500,
                'language' => ['searchPlaceholder' => 'Arama', 'search' => ''],
                'buttons' => ['excel']
            ])
            ->setTableId('envDevice-table')
            ->language(asset('admin_assets/libs/datatables/turkish.json'))
            ->setTableAttribute('class', 'table table-striped table-hover rowClick')
            ->columns($this->getColumns())
            ->pageLength(15)
            ->minifiedAjax()
            ->dom("<'row'<'col-12 col-md mb-3'f><'col-12 col-md-auto'<'.search_place_holder'>>>" .
                "<'row'<'col-sm-12'<'bg-white full-height p-3'<'table-responsive'tr>>>>" .
                "<'row my-3'<'col-12 d-flex justify-content-center align-items-center'pB>>")
            ->orderBy(0, 'asc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('region')->title('Bölge'),
            Column::make('name')->title('Cihaz Adı'),
            Column::make('device_type')->title('Cihaz Tipi'),
            Column::make('confirmed')->title('Onay Durumu')

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EnvDevice_' . date('YmdHis');
    }
}
