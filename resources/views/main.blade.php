<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SVTB CRISBAR</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
      .mobile-menu {
        left: -200%;
        transition: 0.5s;
      }

      .mobile-menu.active {
      left: 0;
      }

      .mobile-menu ul li ul {
        display: none;
      }

      .mobile-menu ul li:hover ul {
        display: block;
      }
    </style>
  </head>
  <body class="bg-slate-400">

    <header class="bg-white">
      <nav class="relative p-8">

        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold tracking-wide text-gray-800">SVTB CRISBAR</div>

            <ul class="md:flex space-x-6">
              <li><a href="#">Home</a></li>
              <li><a href="#">News</a></li>
              <li class="flex relative group">
                <a href="#" class="mr-1">Services</a>
                <i class="fa-solid fa-chevron-down fa-2xs pt-3"></i>
                <!-- Submenu starts -->
                <ul class="absolute bg-white p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                  <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Webdesign</a></li>
                  <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Digital marketing</a></li>
                  <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">SEO</a></li>
                  <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Ad campaigns</a></li>
                  <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">UX Design</a></li>
                </ul>
                <!-- Submenu ends -->
              </li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>
            </ul>

            <a href="{{ route('auth.login') }}" class="bg-red-400 px-5 py-1 rounded-3xl hover:bg-red-500 text-white hidden md:flex" role="button">Sign In</a>

          <!-- Mobile menu icon -->
          <button id="mobile-icon" class="md:hidden">
            <i onclick="changeIcon(this)" class="fa-solid fa-bars"></i>
          </button>

          </div>

        <!-- Mobile menu -->
        <div class="md:hidden flex justify-center mt-3 w-full">
          <div id="mobile-menu" class="mobile-menu absolute top-23 w-full"> <!-- add hidden here later -->
            <ul class="bg-gray-100 shadow-lg leading-9 font-bold h-screen">
              <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="https://google.com" class="block pl-7">Home</a></li>
              <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#" class="block pl-7">News</a></li>
              <li class="border-b-2 border-white hover:bg-red-400 hover:text-white">
                <a href="#" class="block pl-11">Services <i class="fa-solid fa-chevron-down fa-2xs pt-4"></i></a>

                <!-- Submenu starts -->
                <ul class="bg-white text-gray-800 w-full">
                  <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16" href="#">Webdesign</a></li>
                  <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16" href="#">Digital marketing</a></li>
                  <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16" href="#">SEO</a></li>
                  <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16" href="#">Ad campaigns</a></li>
                  <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16" href="#">UX Design</a></li>
                </ul>
                <!-- Submenu ends -->
              </li>
              <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#" class="block pl-7">About</a></li>
              <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#" class="block pl-7">Contact</a></li>
            </ul>
            </div>
        </div>

      </nav>
    </header>

    <!-- Hero section starts -->
    <section class="flex bg-gradient-to-r from-red-100 to-orange-100 h-9/10">

      <div class="container mx-auto relative">
        <div class="flex flex-wrap items-center p-9">
          <div class="w-1/2">
            <div>

              <h1 class="text-black text-5xl md:text-6xl font-bold  w-full">
                Ketahui Nilai Pasti Setiap Produksi Bumbu Anda
              </h1>

              <h3 class="text-black text-xl mt-2 w-10/12">
                SVTBCrisbar: Solusi Cerdas untuk Pelacakan Biaya Bahan yang Akurat dan Efisien di Central Kitchen Crisbar Melong.
              </h3>

              <button href="#" class="mt-9 bg-red-400 px-12 py-3 rounded-3xl hover:bg-red-500 text-white" role="button">
                Lihat Cara Kerjanya
              </button>

            </div>

          </div>
          <div class="w-1/2">
            <svg id="_0360_financial_analyst" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" data-imageid="financial-analyst-31" imageName="Financial Analyst" class="illustrations_image"><defs><style>.cls-1_financial-analyst-31{fill:#fff;}.cls-2_financial-analyst-31{fill:#f4a28c;}.cls-3_financial-analyst-31{opacity:.46;}.cls-3_financial-analyst-31,.cls-4_financial-analyst-31,.cls-5_financial-analyst-31,.cls-6_financial-analyst-31,.cls-7_financial-analyst-31{fill:none;}.cls-8_financial-analyst-31{fill:#a5a5a5;}.cls-9_financial-analyst-31{fill:#ce8172;}.cls-4_financial-analyst-31{opacity:.44;}.cls-10_financial-analyst-31{fill:#e6e6e6;}.cls-5_financial-analyst-31{opacity:.08;}.cls-6_financial-analyst-31{opacity:.31;}.cls-7_financial-analyst-31{opacity:.3;}.cls-11_financial-analyst-31{fill:#24285b;}.cls-12_financial-analyst-31{fill:#000001;}.cls-13_financial-analyst-31{fill:#ffd200;}.cls-14_financial-analyst-31{fill:#68e1fd;}</style></defs><g class="cls-7_financial-analyst-31"><path class="cls-10_financial-analyst-31" d="m108.36,108.95c-48.73,23.5-84.87,83.09-92,155.17-6.01,60.74,7.09,150.22,92.81,146.98,193.63-7.3,318.3,47.81,357.6-52.57,39.3-100.39,20.89-256.8-117.23-270.72-66.57-6.71-146.01-24.75-241.18,21.15Z"/></g><g id="bg_financial-analyst-31" class="cls-5_financial-analyst-31"><path class="cls-12_financial-analyst-31" d="m351.71,348.5c-23.29,19.16-51.39,32.72-82.22,38.56-5.07-10.15-9.79-11.43-20.6-14.51-7.24-2.06-14.23-9.74-19.82-14.54-4.1-3.5-8.24-7.35-10.07-12.44-1.45-4.03-1.22-8.23.08-12.26,5.2.64,10.48.97,15.86.97,31.26,0,59.9-11.22,82.1-29.84,7.17,3.67,13.75,8.47,19.4,14.23,6.37,6.51,11.58,14.33,14,23.1.61,2.2,1.02,4.46,1.27,6.73Z"/></g><g id="wheel_chart_financial-analyst-31"><path class="cls-8_financial-analyst-31" d="m234.95,22.48c-101.57,0-183.92,82.35-183.92,183.92s82.35,183.92,183.92,183.92c11.81,0,23.36-1.12,34.55-3.26,30.83-5.84,58.93-19.4,82.22-38.56,41.01-33.74,67.15-84.87,67.15-142.1,0-101.57-82.35-183.92-183.92-183.92Zm82.1,281.96c-22.21,18.62-50.85,29.84-82.1,29.84-5.38,0-10.66-.33-15.86-.97-63.14-7.81-112.03-61.66-112.03-126.92,0-70.62,57.26-127.89,127.89-127.89s127.89,57.26,127.89,127.89c0,39.37-17.8,74.59-45.78,98.05Z"/><g class="cls-3_financial-analyst-31"><path class="cls-1_financial-analyst-31" d="m233.7,78.53c-40.45.38-76.43,19.56-99.59,49.22-2.5,3.19-4.85,6.51-7.04,9.94-12.67,19.86-20,43.43-20,68.71,0,5.41.35,10.76.99,16.01l-55.59,7.01c-.95-7.53-1.43-15.22-1.43-23.01,0-24.3,4.7-47.49,13.29-68.71,11.3-28.08,29.35-52.74,52.13-71.92,31.59-26.65,72.25-42.82,116.7-43.25l.54,56.01Z"/></g><g class="cls-5_financial-analyst-31"><path class="cls-12_financial-analyst-31" d="m134.11,65.76v61.99c-2.5,3.19-4.85,6.51-7.04,9.94h-62.74c11.3-28.08,29.35-52.74,52.13-71.92h17.65Z"/></g></g><g id="person_financial-analyst-31"><path class="cls-13_financial-analyst-31" d="m325.22,303.4l-26.99-103.14c-.85-3.25-3.87-5.44-7.22-5.24l-110.98,6.62c-4.34.26-7.41,4.35-6.44,8.59l24.51,106.81c.79,3.43,3.99,5.75,7.49,5.43l113.46-10.29c4.33-.39,7.27-4.58,6.17-8.78Z"/><polygon class="cls-1_financial-analyst-31" points="287.75 205.64 185.78 210.96 208.95 308.98 311.6 299.65 287.75 205.64"/><g class="cls-5_financial-analyst-31"><polygon class="cls-12_financial-analyst-31" points="256.99 253.31 266.43 296.99 297.06 294.74 286.73 251.38 256.99 253.31"/></g><polygon class="cls-10_financial-analyst-31" points="281.38 214.09 198.43 219.37 204.75 247.84 288.49 241.07 281.38 214.09"/><polygon class="cls-2_financial-analyst-31" points="360.78 164.34 368.82 210.79 340.86 218.98 345.94 180.16 360.78 164.34"/><g class="cls-6_financial-analyst-31"><path class="cls-9_financial-analyst-31" d="m344.47,188.61s5.34-1.16,9.3-5.72c0,0-.28,9.61-10.7,19.23l1.4-13.52Z"/></g><path class="cls-2_financial-analyst-31" d="m331.37,162.72s-.26,16.03,3.18,26.43c1.39,4.22,6.02,6.54,10.21,5.09,5.21-1.8,11.74-5.76,12.92-14.33l3.79-14.3s2.06-9.04-7.41-14.89c-9.47-5.84-23.02,2.23-22.69,11.99Z"/><path class="cls-2_financial-analyst-31" d="m349.33,175.2s-.32-6.16,4.34-6.02c4.66.15,5.17,9.05-1.06,10.32l-3.28-4.31Z"/><path class="cls-2_financial-analyst-31" d="m331.73,172.83l-4.02,6.47c-.99,1.6.02,3.69,1.89,3.9l6.19.72-4.06-11.09Z"/><g class="cls-5_financial-analyst-31"><path class="cls-12_financial-analyst-31" d="m296.77,194.67l-29.05,1.73s11.35,91.37-24.27,122.63l48.91-5.28,13.15-41.38-2.66-54.43-6.09-23.27Z"/></g><path class="cls-14_financial-analyst-31 targetColor" d="m439.42,419.36s33.02-129.53-7.92-173.4-83.21-41.7-114.91-20.77c-31.7,20.93-60.76,50.15-15.85,194.17h138.68Z" style="fill: rgb(241, 184, 119);"/><path class="cls-2_financial-analyst-31" d="m315.7,230.97s-12.77-17.39-18.93-11.98c-6.16,5.4,5.4,10.47,3.36,18.94-2.04,8.47,19.09,3.15,15.57-6.96Z"/><path class="cls-11_financial-analyst-31" d="m374.69,167.68c.15.4.31.81.47,1.21,6.19,15.92,14.42,31.05,24.42,44.89,4.64,6.42,9.93,13.35,9.46,21.26-.24,4.14-2.09,8.02-4.25,11.56-3.36,5.5-7.79,10.63-13.67,13.28-11.9,5.36-26.57-1.35-33.99-12.1-7.42-10.74-9.11-24.38-9.48-37.43-.41-14.36.34-28.43-4.85-41.92-5.81-.09-14.69-2.52-14.95-9.62-.33-9.26,3.13-16.72,16.19-15.47,8.76.84,19.04,4.03,24.45,11.48,2.8,3.86,4.49,8.38,6.21,12.85Z"/><path class="cls-14_financial-analyst-31 targetColor" d="m344.07,244.43c-2.51-14.08-15.98-22.39-29.69-18.28-15.79,4.73-27.91,23.96-33.46,43.59-11.45,40.5,1.65,91.13-29.61,84.97-31.26-6.16-15.85-99.06-15.85-99.06l-18.49-.88s-34.78,134.72,40.5,142.64c66.32,6.98,97.99-88.99,86.59-152.98Z" style="fill: rgb(241, 184, 119);"/><g class="cls-4_financial-analyst-31"><path class="cls-1_financial-analyst-31" d="m344.07,244.43c-2.51-14.08-15.98-22.39-29.69-18.28-15.79,4.73-27.91,23.96-33.46,43.59-11.45,40.5,1.65,91.13-29.61,84.97-31.26-6.16-15.85-99.06-15.85-99.06l-18.49-.88s-34.78,134.72,40.5,142.64c66.32,6.98,97.99-88.99,86.59-152.98Z"/></g><g class="cls-5_financial-analyst-31"><path class="cls-12_financial-analyst-31" d="m368.82,210.79s36.55,36.49,30.09,84.33c-6.46,47.84-39.04,124.24-39.04,124.24h79.54s23.41-86.55,5.69-149.13c0,0-11.28-44.57-76.28-59.45Z"/></g><path class="cls-2_financial-analyst-31" d="m232.08,255.48s-1.35-25.37-16.32-24.49c-14.97.88,1.21,23.77,1.21,23.77l15.11.72Z"/><polygon class="cls-11_financial-analyst-31" points="439.42 419.36 437.89 477.52 286.85 477.52 300.73 419.36 439.42 419.36"/></g><g id="line_financial-analyst-31"><rect class="cls-11_financial-analyst-31" x="32.87" y="266.99" width="124.12" height="91.58" transform="translate(189.86 625.56) rotate(-180)"/><path class="cls-1_financial-analyst-31" d="m139.99,339.4c-.36,0-.7-.19-.88-.53l-12.83-24.16-20.33,11.94c-.46.27-1.04.13-1.33-.3l-17.54-26.05-18.28,10.04c-.46.25-1.04.1-1.33-.34l-14.44-22.82c-.3-.47-.16-1.08.31-1.38.47-.29,1.08-.16,1.38.31l13.94,22.02,18.26-10.03c.46-.25,1.02-.11,1.31.32l17.53,26.03,20.42-11.99c.23-.14.51-.17.78-.1.26.07.48.25.61.49l13.32,25.09c.26.49.07,1.09-.41,1.35-.15.08-.31.12-.47.12Z"/><circle class="cls-13_financial-analyst-31" cx="54.52" cy="287.68" r="4.38"/><circle class="cls-14_financial-analyst-31 targetColor" cx="87.65" cy="299.28" r="4.38" style="fill: rgb(241, 184, 119);"/><circle class="cls-14_financial-analyst-31 targetColor" cx="126.86" cy="313.71" r="4.38" style="fill: rgb(241, 184, 119);"/><g class="cls-7_financial-analyst-31"><circle class="cls-1_financial-analyst-31" cx="136.25" cy="285.17" r="7.86"/></g></g><g id="charts_financial-analyst-31"><rect class="cls-11_financial-analyst-31" x="330.41" y="39.53" width="103.64" height="77.97"/><rect class="cls-1_financial-analyst-31" x="342.48" y="75.58" width="14.39" height="29.58"/><rect class="cls-1_financial-analyst-31" x="362.69" y="60.36" width="14.39" height="44.8"/><rect class="cls-1_financial-analyst-31" x="384.31" y="82.76" width="14.39" height="22.4"/><rect class="cls-14_financial-analyst-31 targetColor" x="405.4" y="56.25" width="14.39" height="48.91" style="fill: rgb(241, 184, 119);"/></g><g id="dollar_financial-analyst-31"><rect class="cls-13_financial-analyst-31" x="33.9" y="56.47" width="92.18" height="71.91"/><path class="cls-1_financial-analyst-31" d="m76.52,68.3h6.97c0,1.63,0,3.26,0,4.9,0,.31.09.41.4.49.95.25,1.92.48,2.83.85,3.66,1.49,6.3,3.95,7.26,7.92.22.93.31,1.9.46,2.87h-7.59c-.25-2.83-1.77-4.13-3.33-4.76v9.37c.05.03.09.05.13.06.11.03.21.06.32.08,2.37.49,4.69,1.12,6.86,2.25,1.22.64,2.27,1.48,3.03,2.62,2.03,3.05,2.17,6.38,1.06,9.74-1.15,3.47-3.66,5.71-7.05,6.95-1.39.51-2.85.81-4.36,1.22v3.7h-6.97v-3.8c-1.45-.41-2.87-.7-4.21-1.2-3.84-1.42-6.54-3.98-7.49-8.08-.22-.96-.28-1.97-.42-2.99h7.53c.19,1.28.53,2.52,1.36,3.56.83,1.04,1.94,1.63,3.22,1.98v-10.08c-1.86-.59-3.69-1.09-5.47-1.74-2.59-.95-4.45-2.71-5.37-5.37-.57-1.64-.69-3.35-.54-5.06.19-2.11.92-4.02,2.23-5.7,1.92-2.46,4.51-3.78,7.51-4.39.55-.11,1.1-.2,1.66-.3v-5.08Zm6.99,37.81c1.29-.12,2.79-.9,3.59-1.85,1.09-1.31,1.56-4.15-.61-5.52-.9-.57-1.93-.92-2.98-1.4v8.77Zm-7-26.2c-.83.37-1.6.65-2.3,1.04-1.92,1.07-2.53,3.87-1.22,5.51.89,1.12,2.22,1.41,3.52,1.83v-8.38Z"/></g></svg>
          </div>
        </div>
      </div>

    </section>

  </body>

  <script>
    const mobile_icon = document.getElementById('mobile-icon');
    const mobile_menu = document.getElementById('mobile-menu');
    const hamburger_icon = document.querySelector("#mobile-icon i");

    function openCloseMenu() {
      mobile_menu.classList.toggle('block');
      mobile_menu.classList.toggle('active');
    }

    function changeIcon(icon) {
      icon.classList.toggle("fa-xmark");
    }

    mobile_icon.addEventListener('click', openCloseMenu);
  </script>
</html>
