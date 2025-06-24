<?php

namespace App\DataTables;

use App\Helpers\Util;
use App\Models\OpnamePreProduction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OpnamePreProductionDataTable extends DataTable
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
                $html = '<div class="relative inline-flex bg-gray-800 text-white rounded-lg text-center group-aksi" branch="group">';
                // $html .= '<button onclick="edit('.$data->id.')" type="button" class="text-xs p-2 cursor-pointer" title="Ubah"><i class="fas fa-pen"></i></button>';
                $html .= '<button onclick="destroy('.$data->id.')" type="button" class="mx-1 text-xs p-2 cursor-pointer" title="Hapus"><i class="fas fa-trash"></i></button>';
                $html .= '</div>';
                return $html;
            })
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
     * @param \App\Models\OpnamePreProduction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OpnamePreProduction $model): QueryBuilder
    {
        $query = $model->newQuery()->with('karyawan');

        $request = request();

        if(@$request['search']['tanggal']){
            $query->whereDate('tanggal', Carbon::createFromFormat('d-m-Y', $request['search']['tanggal']));
        }

        return $query;
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('aksi')
                ->title('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->orderable(false)
                ->searchable(false),
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
        return 'OpnamePreProduction_' . date('YmdHis');
    }
}
