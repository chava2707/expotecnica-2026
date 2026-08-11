<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>@yield('Title', 'Panel del Juez - ExpoTÉCNICA 2026')</title>
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

        @media (max-width: 767px) {
            .sidebar {
                display: none !important;
            }
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

        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            border-top: 1px solid #E2E8F0;
            z-index: 1020;
            padding: 6px 0;
            padding-bottom: max(6px, env(safe-area-inset-bottom));
        }

        .mobile-bottom-nav .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            color: #564337;
            text-decoration: none;
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 4px 0;
            transition: color 0.15s ease;
            flex: 1 1 0;
            min-width: 0;
        }

        .mobile-bottom-nav .nav-item i {
            font-size: 1.2rem;
            line-height: 1.2;
        }

        .mobile-bottom-nav .nav-item.active {
            color: #944a00;
        }

        @media (min-width: 768px) {
            .mobile-bottom-nav {
                display: none;
            }
        }

        /* ========== DARK MODE ========== */
        body.dark-mode {
            background-color: #1a1d1f !important;
            color: #e8eaec;
        }

        /* Page transition */
        body.dark-mode #page-transition {
            background: #1a1d1f;
        }

        /* Header */
        body.dark-mode header nav {
            background-color: #2d3133 !important;
            border-color: #3d4143 !important;
        }

        body.dark-mode header nav .container>div:first-child {
            color: #ffb783;
        }

        body.dark-mode header nav a {
            color: #b5b8bb !important;
        }

        body.dark-mode header nav a:hover {
            background-color: rgba(148, 74, 0, 0.15) !important;
            color: #ffb783 !important;
        }

        body.dark-mode header nav input.form-control {
            background-color: #1a1d1f;
            border-color: #3d4143;
            color: #e8eaec;
        }

        body.dark-mode header nav input.form-control::placeholder {
            color: #7a7e82;
        }

        body.dark-mode header nav input.form-control:focus {
            border-color: #944a00;
            box-shadow: 0 0 0 0.2rem rgba(148, 74, 0, 0.25);
        }

        body.dark-mode header nav button {
            color: #b5b8bb !important;
        }

        body.dark-mode header nav button:hover {
            color: #ffb783 !important;
        }

        /* Sidebar */
        body.dark-mode .sidebar {
            background-color: #252829;
            border-color: #3d4143;
        }

        body.dark-mode .sidebar .mb-4 h1 {
            color: #ffb783;
        }

        body.dark-mode .sidebar .mb-4 p {
            color: #9aa0a6;
        }

        body.dark-mode .sidebar-nav-link {
            color: #b5b8bb;
        }

        body.dark-mode .sidebar-nav-link:hover {
            background-color: #3d4143;
            color: #e8eaec;
        }

        body.dark-mode .sidebar-nav-link.active {
            background-color: rgba(148, 74, 0, 0.2);
            color: #ffb783;
        }

        body.dark-mode .sidebar-user-card {
            border-color: #3d4143;
        }

        body.dark-mode .user-sidebar-card {
            background-color: #1a1d1f;
            border-color: #3d4143;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .user-sidebar-card .overflow-hidden span:first-child {
            color: #e8eaec;
        }

        body.dark-mode .user-sidebar-card .overflow-hidden span:last-child {
            color: #9aa0a6;
        }

        /* Main content */
        body.dark-mode main>div {
            background-color: #1a1d1f !important;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3 {
            color: #e8eaec;
        }

        body.dark-mode p {
            color: #b5b8bb;
        }

        body.dark-mode strong {
            color: #ffb783;
        }

        /* Cards & widgets */
        body.dark-mode .widget-card,
        body.dark-mode .metric-card-judge,
        body.dark-mode .project-card,
        body.dark-mode .config-card {
            background-color: #2d3133;
            border-color: #3d4143;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .widget-card:hover,
        body.dark-mode .metric-card-judge:hover,
        body.dark-mode .project-card:hover,
        body.dark-mode .config-card:hover {
            border-color: rgba(148, 74, 0, 0.4);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        body.dark-mode .widget-card h2,
        body.dark-mode .widget-card h3,
        body.dark-mode .metric-card-judge h3,
        body.dark-mode .project-card h3 {
            color: #e8eaec;
        }

        body.dark-mode .widget-card p,
        body.dark-mode .metric-card-judge p,
        body.dark-mode .project-card p {
            color: #9aa0a6;
        }

        /* Border bottom on headers */
        body.dark-mode .border-bottom {
            border-color: #3d4143 !important;
        }

        /* Project image placeholder */
        body.dark-mode .d-flex.align-items-center.justify-content-center[style*="background-color: #f2f4f6"] {
            background-color: #1a1d1f !important;
        }

        /* Category label */
        body.dark-mode .category-label {
            color: #ffb783 !important;
        }

        /* Buttons inside cards */
        body.dark-mode .btn-evaluar {
            background-color: #e67e22;
            color: #fff;
        }

        body.dark-mode .btn-evaluar:hover {
            background-color: #ffb783;
            color: #1a1d1f;
        }

        /* Status badges */
        body.dark-mode .status-badge.pending {
            background-color: #3d4143;
            color: #b5b8bb;
        }

        /* Progress hero */
        body.dark-mode .progress-hero {
            background-color: #944a00;
        }

        /* Date widget */
        body.dark-mode .d-none.d-md-flex[style*="background-color: #fff"] {
            background-color: #2d3133 !important;
            border-color: #3d4143 !important;
        }

        body.dark-mode .d-none.d-md-flex[style*="background-color: #fff"] span {
            color: #e8eaec !important;
        }

        /* Filter buttons */
        body.dark-mode .btn[style*="background-color: #f2f4f6"] {
            background-color: #3d4143 !important;
            color: #b5b8bb !important;
        }

        body.dark-mode .btn[style*="background-color: #f2f4f6"]:hover {
            background-color: #4d5153 !important;
        }

        /* Empty state */
        body.dark-mode .widget-card .d-flex.align-items-center.justify-content-center {
            color: #5a5e62;
        }

        /* Footer desktop */
        body.dark-mode .desktop-footer {
            background-color: #2d3133;
            border-color: #3d4143 !important;
        }

        body.dark-mode .desktop-footer .container>div:first-child {
            color: #ffb783;
        }

        body.dark-mode .desktop-footer .footer-links {
            color: #9aa0a6;
        }

        body.dark-mode .desktop-footer .footer-links a {
            color: #b5b8bb !important;
        }

        body.dark-mode .desktop-footer .footer-links a:hover {
            color: #ffb783 !important;
        }

        body.dark-mode .desktop-footer .footer-copyright {
            color: #7a7e82;
        }

        /* Mobile footer nav */
        body.dark-mode .mobile-footer-nav {
            background-color: #252829;
            border-color: #3d4143 !important;
        }

        body.dark-mode .mobile-footer-nav .nav-link {
            color: #7a7e82 !important;
        }

        body.dark-mode .mobile-footer-nav .nav-link:first-child {
            color: #ffb783 !important;
        }

        /* Mobile bottom nav */
        body.dark-mode .mobile-bottom-nav {
            background-color: #252829;
            border-color: #3d4143;
        }

        body.dark-mode .mobile-bottom-nav .nav-item {
            color: #7a7e82;
        }

        body.dark-mode .mobile-bottom-nav .nav-item.active {
            color: #ffb783;
        }

        /* Scrollbar dark */
        body.dark-mode .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4d5153;
        }

        /* Config card extras */
        body.dark-mode .config-card__header {
            border-color: #3d4143;
        }

        body.dark-mode .config-card__icon {
            background: #1a1d1f;
        }

        body.dark-mode .font-size-btn {
            background: #1a1d1f;
            border-color: #3d4143;
        }

        body.dark-mode .font-size-btn:hover {
            background: #2d3133;
        }

        body.dark-mode .font-size-btn.active {
            background: rgba(148, 74, 0, 0.15);
            border-color: #944a00;
        }

        body.dark-mode .font-size-btn__label {
            color: #9aa0a6;
        }

        body.dark-mode .font-size-btn.active .font-size-btn__label {
            color: #ffb783;
        }

        body.dark-mode .font-size-btn__preview {
            color: #e8eaec;
        }

        body.dark-mode .font-size-btn.active .font-size-btn__preview {
            color: #ffb783;
        }

        body.dark-mode .dark-mode-preview {
            background: #1a1d1f;
        }

        /* Bootstrap form controls */
        body.dark-mode .form-control {
            background-color: #1a1d1f;
            border-color: #3d4143;
            color: #e8eaec;
        }

        body.dark-mode .form-control:focus {
            background-color: #2d3133;
            border-color: #944a00;
            color: #e8eaec;
            box-shadow: 0 0 0 0.2rem rgba(148, 74, 0, 0.25);
        }

        /* Font Size - Layout */
        body.font-large .sidebar-nav-link {
            font-size: 0.9rem !important;
        }

        body.font-large .mobile-bottom-nav .nav-item {
            font-size: 0.7rem !important;
        }

        body.font-xlarge .sidebar-nav-link {
            font-size: 1rem !important;
        }

        body.font-xlarge .mobile-bottom-nav .nav-item {
            font-size: 0.75rem !important;
        }

        /* Font Size - Indicadores (evaluación) */
        body.font-large .rubric-section__header h4,
        body.font-large .question-block__label,
        body.font-xlarge .rubric-section__header h4,
        body.font-xlarge .question-block__label {
            font-size: 1.25rem !important;
        }

        body.font-large .question-block__desc,
        body.font-large .obs-textarea {
            font-size: 1rem !important;
        }

        body.font-xlarge .question-block__desc,
        body.font-xlarge .obs-textarea {
            font-size: 1.1rem !important;
        }

        body.font-large .question-block__score {
            font-size: 1.4rem !important;
        }

        body.font-xlarge .question-block__score {
            font-size: 1.5rem !important;
        }

        body.font-large .score-btn__value {
            font-size: 1.25rem !important;
        }

        body.font-xlarge .score-btn__value {
            font-size: 1.4rem !important;
        }

        body.font-large .score-btn__label {
            font-size: 0.7rem !important;
        }

        body.font-xlarge .score-btn__label {
            font-size: 0.8rem !important;
        }

        /* Mantener alineados los botones de puntaje */
        body.font-large .score-buttons {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        }

        body.font-large .score-btn {
            min-height: 78px;
        }

        body.font-large .score-btn__label {
            line-height: 1.25;
        }

        body.font-xlarge .score-buttons {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        }

        body.font-xlarge .score-btn {
            min-height: 92px;
        }

        body.font-xlarge .score-btn__label {
            line-height: 1.25;
        }
    </style>
    @yield('Styles')
</head>

<body class="d-flex flex-column min-vh-100">

    <div id="page-transition"
        style="position:fixed;inset:0;background:#f7f9fb;z-index:9999;opacity:1;pointer-events:none;transition:opacity 0.35s ease;">
    </div>

    <header class="z-3">@include('plantillas.header')</header>

    <div class="d-flex flex-grow-1 overflow-hidden" style="padding-bottom: 0;">

        <aside class="sidebar d-flex flex-column p-4 gap-3" id="sidebar">
            <div class="mb-4 px-3">
                <h1
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 700; color: #944a00; margin-bottom: 2px;">
                    ExpoTÉCNICA</h1>
                <p
                    style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073; margin-bottom: 0;">
                    Judge Portal</p>
            </div>

            <nav class="d-flex flex-column gap-1 flex-grow-1">
                <a href="{{ route('juez.dashboard') }}" class="sidebar-nav-link @yield('JudgeSidebarActive')">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('juez.configuracion') }}" class="sidebar-nav-link @yield('JudgeSidebarActive4')">
                    <i class="bi bi-gear-fill"></i>
                    <span>Configuración</span>
                </a>
                <a href="{{ route('juez.lineamientos') }}" class="sidebar-nav-link @yield('JudgeSidebarActive5')">
                    <i class="bi bi-book-half"></i>
                    <span>Lineamientos</span>
                </a>
            </nav>

            <div class="sidebar-user-card">
                <a href="#" class="sidebar-nav-link mb-2" data-bs-toggle="modal" data-bs-target="#modalCentroAyuda" data-no-transition>
                    <i class="bi bi-question-circle-fill"></i>
                    <span>Centro de Ayuda</span>
                </a>
                <div class="user-sidebar-card d-flex align-items-center gap-3">
                    <div class="judge-avatar" style="background-color: #ffb783; color: #301400;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'JD', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <span style="font-size: 0.75rem; font-weight: 600; color: #191c1e; display: block;"
                            class="text-truncate">{{ Auth::user()->name ?? 'Juez' }}</span>
                        <span style="font-size: 0.625rem; color: #4e6073; display: block;"
                            class="text-truncate">{{ Auth::user()->rol->Nombre_rol ?? 'Juez' }}</span>
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

    <nav class="mobile-bottom-nav d-flex align-items-center justify-content-around" id="mobileBottomNav">
        <a href="{{ route('juez.dashboard') }}"
            class="nav-item {{ request()->routeIs('juez.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('juez.configuracion') }}"
            class="nav-item {{ request()->routeIs('juez.configuracion') ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            <span>Ajustes</span>
        </a>
        <a href="{{ route('juez.lineamientos') }}"
            class="nav-item {{ request()->routeIs('juez.lineamientos') ? 'active' : '' }}">
            <i class="bi bi-book-half"></i>
            <span>Normas</span>
        </a>
    </nav>

    <footer class="d-none d-sm-block z-3">@include('plantillas.footer')</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        (function () {
            var savedFontSize = localStorage.getItem('fontSize') || 'normal';
            if (savedFontSize === 'large') {
                document.body.classList.add('font-large');
            } else if (savedFontSize === 'xlarge') {
                document.body.classList.add('font-xlarge');
            }

            var savedDarkMode = localStorage.getItem('darkMode') === 'true';
            if (savedDarkMode) {
                document.body.classList.add('dark-mode');
            }
        })();
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
    @yield('Scripts')

    <div class="modal fade" id="modalCentroAyuda" tabindex="-1" aria-labelledby="modalCentroAyudaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 8px 32px rgba(0,0,0,.15);">
                <div class="modal-header" style="background:#2d3133;border-radius:16px 16px 0 0;padding:16px 24px;">
                    <h5 class="modal-title" id="modalCentroAyudaLabel" style="color:#fff;font-weight:600;font-size:1rem;">
                        <i class="bi bi-headset" style="margin-right:8px;"></i> Solicitar Asistencia
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('juez.solicitar.ayuda') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding:24px;">
                        <p style="font-size:.875rem;color:#564337;margin-bottom:16px;">
                            Un administrador será notificado y enviará una persona a asistirlo. Describa brevemente su situación:
                        </p>
                        <textarea name="mensaje" class="obs-textarea" style="min-height:100px;border-radius:10px;padding:14px;font-size:.875rem;border:1px solid #E2E8F0;resize:none;width:100%;font-family:'Inter',sans-serif;" placeholder="Ej: Necesito asistencia con el sistema de calificación...">Solicitud de asistencia en sitio.</textarea>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #E2E8F0;padding:16px 24px;">
                        <button type="button" style="height:40px;padding:0 20px;border:1px solid #E2E8F0;border-radius:8px;background:#f2f4f6;color:#564337;font-weight:600;font-size:.8125rem;cursor:pointer;" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" style="height:40px;padding:0 20px;border:none;border-radius:8px;background:#e65100;color:#fff;font-weight:600;font-size:.8125rem;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                            <i class="bi bi-send"></i> Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>