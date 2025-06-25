<?php

namespace App\DataTables;

use App\Helpers\Util;
use App\Models\LaporanProduksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LaporanProduksiDataTable extends DataTable
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
            ->addColumn('aksi', function ($data) {
                $html = '<div class="relative inline-flex bg-gray-800 text-white rounded-lg text-center" branch="group">';
                $html .= '<a href="javascript:show('.$data->id.')" class="text-xs p-2 cursor-pointer">Detail</a>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('nilai_bahan', function ($data) {
                return Util::rupiah($data->nilai_bahan ?? 0);
            })
            ->editColumn('nilai_laporan_per_produksi', function ($data) {
                return Util::rupiah($data->nilai_laporan_per_produksi ?? 0);
            })
            ->editColumn('tanggal', function ($data) {
                if ($data->tanggal) {
                    return Carbon::parse($data->tanggal)->format('d-m-Y');
                }
                return '';
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
            ->rawColumns(['aksi', 'nilai_rupiah', 'nilai_persatuan']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanProduksi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LaporanProduksi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('aksi')->title('aksi')->orderable(false)->searchable(false),
            Column::make('tanggal'),
            Column::make('nama_produk'),
            Column::make('qty'),
            Column::make('nilai_bahan'),
            Column::make('nilai_laporan_per_produksi'),
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
        return 'LaporanProduksi_' . date('YmdHis');
    }
}
