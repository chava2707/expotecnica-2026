<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <title>@yield('Title', 'Admin - ExpoTÉCNICA 2026')</title>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f7f9fb;
    }

    .sidebar {
      width: 260px;
      background-color: #f2f4f6;
      border-right: 1px solid #E2E8F0;
      transition: transform 0.3s ease;
    }

    .sidebar-nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 16px;
      border-radius: 0.5rem;
      color: #564337;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.8125rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      transition: all 0.15s ease;
    }

    .sidebar-nav-link:hover {
      background-color: #e6e8ea;
      color: #191c1e;
    }

    .sidebar-nav-link.active {
      background-color: #cfe2f9;
      color: #526478;
    }

    .sidebar-nav-link i {
      font-size: 1.25rem;
    }

    .sidebar-user-card {
      border-top: 1px solid #E2E8F0;
      padding-top: 16px;
    }

    .user-sidebar-card {
      background-color: #fff;
      border-radius: 0.75rem;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      padding: 16px;
    }

    .judge-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.75rem;
      flex-shrink: 0;
    }

    .burger-btn {
      display: none;
      position: fixed;
      top: 76px;
      left: 12px;
      z-index: 1030;
      width: 44px;
      height: 44px;
      border-radius: 0.5rem;
      background-color: #fff;
      border: 1px solid #E2E8F0;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      color: #2C3E50;
      font-size: 1.25rem;
      align-items: center;
      justify-content: center;
      transition: all 0.15s ease;
    }

    .burger-btn:hover {
      background-color: #FFF3E0;
      color: #E67E22;
    }

    @media (max-width: 767px) {
      .burger-btn {
        display: flex;
      }

      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1050;
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1040;
      }

      .sidebar-overlay.show {
        display: block;
      }
    }

    .custom-scrollbar::-webkit-scrollbar {
      width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #d8dadc;
      border-radius: 10px;
    }

    .z-3 {
      position: relative;
      z-index: 3;
    }

    .accordion-button::after {
      margin-left: auto;
      transform: scale(.8);
    }

    .accordion-button:not(.collapsed)::after {
      transform: rotate(-180deg) scale(.8);
    }

    .accordion-button {
      box-shadow: none !important;
    }

    .accordion-item {
      background: transparent;
    }

    .accordion-body {
      padding-right: 0;
    }

    .accordion-body .sidebar-nav-link {

      font-size: .74rem;

      padding-left: 2.2rem;

      gap: 10px;

    }

    .accordion-body .sidebar-nav-link i {

      font-size: 1rem;

    }
  </style>
  @yield('Styles')
</head>

<body class="d-flex flex-column min-vh-100">

  {{-- Page transition overlay --}}
  <div id="page-transition"
    style="position:fixed;inset:0;background:#f7f9fb;z-index:9999;opacity:1;pointer-events:none;transition:opacity 0.35s ease;">
  </div>

  <header class="z-3">@include('plantillas.header')</header>

  <div class="d-flex flex-grow-1 overflow-hidden">

    <button class="burger-btn" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar d-flex flex-column p-4 gap-3" id="sidebar">
      <div class="mb-4 px-3">
        <h1
          style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 700; color: #944a00; margin-bottom: 2px;">
          ExpoTÉCNICA</h1>
        <p
          style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073; margin-bottom: 0;">
          Admin Portal</p>
      </div>

      <nav class="d-flex flex-column gap-1 flex-grow-1">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link @yield('AdminSidebarActive')">
          <i class="bi bi-grid-1x2-fill"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.usuarios') }}" class="sidebar-nav-link @yield('AdminSidebarActive3')">
          <i class="bi bi-people-fill"></i>
          <span>Usuarios</span>
        </a>
        <a href="{{ route('admin.proyectos') }}" class="sidebar-nav-link @yield('AdminSidebarActive2')">
          <i class="bi bi-rocket-takeoff-fill"></i>
          <span>Proyectos</span>
        </a>
        <a href="/categorias" class="sidebar-nav-link">
          <i class="bi bi-tags-fill"></i>
          <span>Categorías</span>
        </a>
        <a href="/admin/ejes" class="sidebar-nav-link">
          <i class="bi bi-diagram-3"></i>
          <span>Ejes Tematicos</span>
        </a>
        <a href="{{ route('admin.resultados') }}" class="sidebar-nav-link @yield('AdminSidebarActiveResultados')">
          <i class="bi bi-bar-chart-fill"></i>
          <span>Resultados</span>
        </a>
        <a href="{{ route('admin.solicitudes') }}" class="sidebar-nav-link @yield('AdminSidebarActiveSolicitudes')">
          <i class="bi bi-bell-fill"></i>
          <span>Solicitudes</span>
        </a>
        <a href="{{ route('admin.ayudas') }}" class="sidebar-nav-link @yield('AdminSidebarActiveAyudas')">
          <i class="bi bi-headset"></i>
          <span>Ayuda</span>
        </a>
        <a href="{{ route('admin.avisos') }}" class="sidebar-nav-link @yield('AdminSidebarActiveAvisos')">
          <i class="bi bi-printer-fill"></i>
          <span>Impresiones</span>
          @if(\App\Models\AvisoImpresion::where('Estado', 'Pendiente')->count() > 0)
          <span class="badge rounded-pill" style="background:#ba1a1a;color:#fff;font-size:0.625rem;font-weight:700;margin-left:auto;">
            {{\App\Models\AvisoImpresion::where('Estado', 'Pendiente')->count()}}
          </span>
          @endif
        </a>

        {{-- RÚBRICA --}}
        <a href="{{ route('apartados.index') }}" class="sidebar-nav-link @yield('AdminSidebarActiveApartados')">
          <i class="bi bi-list-task"></i>
          <span>Apartados</span>
        </a>

        <a href="{{ route('preguntas.index') }}" class="sidebar-nav-link @yield('AdminSidebarActivePreguntas')">
          <i class="bi bi-ui-checks-grid"></i>
          <span>Indicadores</span>
        </a>
        <a href="{{ route('admin.configuracion') }}" class="sidebar-nav-link @yield('AdminSidebarActiveConfig')">
          <i class="bi bi-gear-fill"></i>
          <span>Configuración</span>
        </a>
      </nav>

      <div class="sidebar-user-card">
        <a href="#" class="sidebar-nav-link mb-2">
          <i class="bi bi-question-circle-fill"></i>
          <span>Centro de Ayuda</span>
        </a>
        <div class="user-sidebar-card d-flex align-items-center gap-3">
          <div class="judge-avatar" style="background-color: #ffb783; color: #301400;">
            <i class="bi bi-person-fill"></i>
          </div>
          <div class="overflow-hidden">
            <span style="font-size: 0.75rem; font-weight: 600; color: #191c1e; display: block;"
              class="text-truncate">{{ Auth::user()->name ?? 'Admin User' }}</span>
            <span style="font-size: 0.625rem; color: #4e6073; display: block;" class="text-truncate">Global
              Supervisor</span>
          </div>
        </div>
      </div>
    </aside>

    <main class="flex-grow-1 d-flex flex-column overflow-hidden">
      <div class="flex-grow-1 overflow-auto custom-scrollbar p-3 p-lg-4" style="background-color: #f7f9fb;">
        @yield('Main')
      </div>
    </main>
  </div>

  <footer class="z-3">@include('plantillas.footer')</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
      document.getElementById('sidebarOverlay').classList.toggle('show');
    }
  </script>
  <script>
    (function () {
      var overlay = document.getElementById('page-transition');
      if (!overlay) return;

      requestAnimationFrame(function () {
        overlay.style.opacity = '0';
        setTimeout(function () { overlay.style.pointerEvents = 'none'; }, 400);
      });

      document.addEventListener('click', function (e) {
        var link = e.target.closest('a');
        if (!link) return;
        var href = link.getAttribute('href');
        if (!href || href === '#' || href.startsWith('#') || href.startsWith('/#') || href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('data-no-transition')) return;
        if (href.startsWith('http') && !href.startsWith(window.location.origin)) return;

        e.preventDefault();
        overlay.style.pointerEvents = 'auto';
        overlay.style.opacity = '1';
        setTimeout(function () { window.location.href = href; }, 380);
      });
    })();
  </script>
</body>

</html>