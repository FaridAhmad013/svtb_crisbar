<nav class="sidenav fixed h-screen w-xs flex justify-center items-center" id="sidenav-main">

  <div class="bg-white h-11/12 w-10/12 rounded-lg">
    <!-- Brand -->
    <div class="sidenav-header p-5 border-b border-b border-gray-100">
      <a class="text-xl font-bold tracking-wide text-gray-800 text-center block" href="{{ route('dashboard.index') }}">
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
            ->item('Pengguna', 'fas fa-user', 'admin/manajemen/user', Request::is('admin/manajemen/user'), ['Admin'])
            ->item('Role', 'fas fa-building', 'admin/manajemen/role', Request::is('admin/manajemen/role'), ['Admin'])
            ->end_group();

        $obj_menu
            ->divinder('Master', [
                'Admin',
            ])
            ->start_group()
            ->item('Kategori Pertanyaan', 'fas fa-th-large', 'admin/master/kategori_pertanyaan', Request::is('admin/master/kategori_pertanyaan'), ['Admin'])
            ->item('Pertanyaan', 'fas fa-comments', 'admin/master/pertanyaan', Request::is('admin/master/pertanyaan'), ['Admin'])
            ->end_group();

        $obj_menu
            ->divinder('Ruang Cerita', [
                'Pengguna',
            ])
            ->start_group()
            ->item('Obrolan', 'fas fa-comments', 'admin/ruang_cerita/obrolan', Request::is('admin/ruang_cerita/obrolan'), ['Pengguna'])
            ->item('Riwayat Obrolan', 'fas fa-history', 'admin/ruang_cerita/riwayat_obrolan', Request::is('admin/ruang_cerita/riwayat_obrolan'), ['Pengguna'])
            ->end_group();

        $menu = $obj_menu->to_html();

      @endphp
      {!! $menu !!}
    </div>
  </div>
</nav>
