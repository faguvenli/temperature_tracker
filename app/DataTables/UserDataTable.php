<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('active', function($data) {
                return $data->active?'<span class="alert alert-success p-1">Aktif</span>':'<span class="alert alert-danger p-1">Pasif</span>';
            })
            ->editColumn('isPanelUser', function($data) {
                return $data->isPanelUser?'<span class="alert alert-success p-1">Var</span>':'<span class="alert alert-danger p-1">Yok</span>';
            })
            ->editColumn('send_sms_notification', function($data) {
                return $data->send_sms_notification?'<span class="alert alert-success p-1">Var</span>':'<span class="alert alert-danger p-1">Yok</span>';
            })
            ->editColumn('send_email_notification', function($data) {
                return $data->send_email_notification?'<span class="alert alert-success p-1">Var</span>':'<span class="alert alert-danger p-1">Yok</span>';
            })
            ->filterColumn('tenant', function($query, $keyword) {
                $query->whereRaw('LOWER(tenants.name) like ?', ["%".strtolower($keyword)."%"]);
            })
            ->setRowData([
                'entry-id' => function ($data) {
                    return $data->id;
                }
            ])
            ->setRowAttr([
                'data-href' => function($data) {
                    return route('users.edit', $data->id);
                }
            ])
            ->rawColumns(['active', 'isPanelUser', 'send_sms_notification', 'send_email_notification']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.send_sms_notification',
                'users.send_email_notification',
                'users.isPanelUser',
                'users.active',
                'tenants.name as tenant'
            )
            ->leftJoin('tenants', 'tenants.id', '=', 'users.tenant_id');
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
            ->setTableId('user-table')
            ->language(asset('admin_assets/libs/datatables/turkish.json'))
            ->setTableAttribute('class', 'table table-striped table-hover rowClick')
            ->columns($this->getColumns())
            ->pageLength(15)
            ->minifiedAjax()
            ->dom("<'row'<'col-12 col-md mb-3'f><'col-12 col-md-auto'<'.search_place_holder'>>>" .
                "<'row'<'col-sm-12'<'bg-white full-height p-3'<'table-responsive'tr>>>>" .
                "<'row my-3'<'col-12 d-flex justify-content-center align-items-center'pB>>")
            ->orderBy(1, 'asc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('tenant')->title('Kurum Adı'),
            Column::make('name')->title('Adı'),
            Column::make('email')->title('E-posta'),
            Column::make('send_sms_notification')->title('SMS Bildirimi')->className('width-120 text-center'),
            Column::make('send_email_notification')->title('E-posta Bildirimi')->className('width-120 text-center'),
            Column::make('active')->title('Durumu')->className('width-60 text-center'),
            Column::make('isPanelUser')->title('Panel Erişimi')->className('width-100 text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
