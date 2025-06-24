<nav class="p-5 border-b border-b border-gray-100 bg-white text-gray-800 relative h-20">
  <div class="flex flex-wrap justify-between items-center">
    <div class="p-1">
      <button id="toggle-menu" class="cursor-pointer" type="button"><i class="fas fa-bars text-xl"></i></button>
    </div>
    <div class="flex items-center cursor-pointer" id="navbar-button-dropdown">
      <img src="{{ asset('img/user.png') }}" alt="Farid Ahmad Fadhilah" class="w-10 h-10 rounded-full object-cover">
      <div class="text-gray-700 tracking-wide ml-2">Farid Ahmad Fadhilah</div>
    </div>
  </div>
  <div id="navbar-dropdown" style="display: none" class="absolute right-0 z-10 min-w-44 mt-2 mr-3 rounded-md shadow-sm bg-white border border-gray-300">
    <div class="py-1">
      <a href="{{ route('auth.logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-bold tracking-wide"><i class="fas fa-sign-out-alt mr-3"></i> Logout</a>
    </div>
  </div>
</nav>
