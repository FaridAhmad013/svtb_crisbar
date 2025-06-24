<?php

namespace App\DataTables;

use App\Helpers\Util;
use App\Models\OpnamePostProduction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OpnamePostProductionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('nilai_rupiah', function ($data) {
                return Util::rupiah($data->nilai_rupiah ?? 0);
            })
            ->editColumn('nilai_persatuan', function ($data) {
                return Util::rupiah($data->nilai_persatuan ?? 0);
            })
            ->editColumn('tanggal', function ($data) {
                if ($data->tanggal) {
                    return Carbon::parse($data->tanggal)->format('d-m-Y');
                }
                return '';
            })
            ->editColumn('qty', function ($data) {
                return '<input type="number" name="qty" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" id="qty" value="'.$data->qty.'" >';
            })
            ->editColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->editColumn('updated_at', function ($data) {
                if ($data->updated_at) {
                    return Carbon::parse($data->updated_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->rawColumns(['nilai_rupiah', 'qty', 'nilai_persatuan']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OpnamePostProduction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OpnamePostProduction $model): QueryBuilder
    {
        return $model->newQuery()->with('karyawan');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('tanggal'),
            Column::make('nama_produk'),
            Column::make('nama_bahan'),
            Column::make('qty'),
            Column::make('satuan'),
            Column::make('nilai_rupiah'),
            Column::make('nilai_persatuan'),
            Column::make('karyawan.nama_karyawan')->title('Dicatat Oleh'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'OpnamePostProduction_' . date('YmdHis');
    }
}
