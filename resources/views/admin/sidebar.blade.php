<nav class="sidenav h-screen w-full" id="sidenav-main">
  <div class="bg-white h-full rounded-lg shadow-md">
    <!-- Brand -->
    <div class="sidenav-header p-5 border-b border-b border-gray-100 h-20">
      <a class="text-xl font-bold tracking-wide text-gray-800 text-center block menu-text" href="{{ route('dashboard.index') }}">
        SVTB CRISBAR
      </a>
    </div>
    <div class="p-5 text-gray-800">
      @php
        use App\Helpers\Menu;
        $menu = '';

        $obj_menu = new Menu();
        $obj_menu
            ->init()
            ->start_group()
            ->item('Dashboard', 'fas fa-tv', 'admin', Request::is('admin'), ['Pemilik','Karyawan'])
            ->end_group();

        $obj_menu
            ->divinder('Manajemen', [
                'Pemilik',
            ])
            ->start_group()
            ->item('Karyawan', 'fas fa-users', 'admin/manajemen/karyawan', Request::is('admin/manajemen/karyawan'), ['Pemilik'])

            ->end_group();

        $obj_menu
            ->divinder('Proses Produksi Harian', [
                'Karyawan',
            ])
            ->start_group()
            ->item('Opname (Pre-Production)', 'fas fa-sun', 'admin/proses_produksi_harian/opname_pre_production', Request::is('admin/proses_produksi_harian/opname_pre_production'), ['Karyawan'])
            ->item('Opname (Post-Production)', 'fas fa-moon', 'admin/proses_produksi_harian/opname_post_production', Request::is('admin/proses_produksi_harian/opname_post_production'), ['Karyawan'])
            ->item('Catat Hasil Produksi', 'fas fa-box', 'admin/proses_produksi_harian/laporan_produksi', Request::is('admin/proses_produksi_harian/laporan_produksi'), ['Karyawan'])

            ->end_group();

        $obj_menu
            ->divinder('Laporan', [
                'Pemilik',
            ])
            ->start_group()
            ->item('Laporan Produksi', 'fas fa-file-alt', 'admin/laporan/laporan_produksi', Request::is('admin/laporan/laporan_produksi'), ['Pemilik'])
            ->end_group();

        $menu = $obj_menu->to_html();

      @endphp
      {!! $menu !!}
    </div>
  </div>
</nav>
