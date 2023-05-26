<?php

namespace App\DataTables;

use App\Models\BagDevice;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BagDeviceDataTable extends DataTable
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
            ->filterColumn('region', function($query, $keyword) {
                $query->whereRaw('LOWER(regions.name) like ?', ["%".strtolower($keyword)."%"]);
            })
            ->filterColumn('device_type', function($query, $keyword) {
                $query->whereRaw('LOWER(bag_device_types.name) like ?', ["%".strtolower($keyword)."%"]);
            })
            ->setRowData([
                'entry-id' => function ($data) {
                    return $data->id;
                }
            ])
            ->setRowAttr([
                'data-href' => function($data) {
                    return route('bag-devices.edit', $data->id);
                }
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BagDevice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BagDevice $model)
    {
        $regionDatabase = Config::get('database.connections.mysql.database');

        return $model->newQuery()
            ->select(
                'regions.name as region',
                'bag_device_types.name as device_type',
                'bag_devices.device_model',
                'bag_devices.id',
                'bag_devices.device_location',
                'bag_devices.serial_number'
            )
            ->leftJoin($regionDatabase.'.regions as regions', 'regions.id', '=', 'bag_devices.region_id')
            ->leftJoin('bag_device_types', 'bag_device_types.id', '=', 'bag_devices.bag_device_type_id');
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
            ->setTableId('bagDevice-table')
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
            Column::make('device_type')->title('Cihaz Tipi'),
            Column::make('device_model')->title('Cihaz Modeli'),
            Column::make('device_location')->title('Konum'),
            Column::make('serial_number')->title('Seri Numarası'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BagDevice_' . date('YmdHis');
    }
}
