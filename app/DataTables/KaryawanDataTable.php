<?php

namespace App\DataTables;

use App\Helpers\AuthCommon;
use App\Helpers\ConstantUtility;
use App\Helpers\Util;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KaryawanDataTable extends DataTable
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
                $html .= '<button onclick="edit('.$data->id.')" type="button" class="text-xs p-2 cursor-pointer" title="Ubah"><i class="fas fa-pen"></i></button>';
                $html .= '<button onclick="destroy('.$data->id.')" type="button" class="ml-1 text-xs p-2 cursor-pointer" title="Hapus"><i class="fas fa-trash"></i></button>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('nomor_karyawan', function ($data) {
                $html = '';
                $html = '<a href="javascript:show('.$data->id.')" class="text-sky-500 font-bold hover:text-sky-600 cursor-pointer">'.$data->nomor_karyawan.'</a>';
                return $html;
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
            ->rawColumns(['aksi', 'nomor_karyawan']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Karyawan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Karyawan $model): QueryBuilder
    {
        return $model->newQuery()->with('user');
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
            Column::make('nomor_karyawan'),
            Column::make('nama_karyawan'),
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
        return 'Karyawan_' . date('YmdHis');
    }
}
