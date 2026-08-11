<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>@yield('Title', 'ExpoTÉCNICA 2026')</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }
        .technical-grid {
            background-image:
                linear-gradient(rgba(45, 49, 51, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45, 49, 51, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #897365;
            font-size: 1.125rem;
            transition: color 0.2s ease;
            pointer-events: none;
        }
        .form-control:focus ~ .input-icon,
        .form-control:focus + .input-icon {
            color: #944a00;
        }
        .auth-card {
            box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        }
        .btn-login {
            background-color: #e67e22;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        .btn-login:hover {
            background-color: #944a00;
        }
        .btn-login:active {
            transform: scale(0.98);
        }
        .link-primary-custom {
            color: #944a00;
            transition: color 0.15s ease;
        }
        .link-primary-custom:hover {
            color: #713700;
        }
        .link-secondary-custom {
            color: #4e6073;
            transition: color 0.15s ease;
        }
        .link-secondary-custom:hover {
            color: #36485b;
        }
        .blueprint-accent {
            position: absolute;
            pointer-events: none;
            overflow: hidden;
            opacity: 0.03;
        }
    </style>
</head>
<body class="min-vh-100 d-flex flex-column justify-content-center technical-grid position-relative overflow-x-hidden">

    {{-- Page transition overlay --}}
    <div id="page-transition" style="position:fixed;inset:0;background:#f7f9fb;z-index:9999;opacity:1;pointer-events:none;transition:opacity 0.35s ease;"></div>

    {{-- Blueprint decorative SVGs --}}
    <div class="blueprint-accent top-0 start-0 w-100 h-100">
        <svg class="position-absolute" style="top: -40px; right: -40px; width: 384px; height: 384px; color: #2d3133;" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" fill="none" r="80" stroke="currentColor" stroke-dasharray="4 2" stroke-width="0.5"/>
            <path d="M20,100 L180,100 M100,20 L100,180" stroke="currentColor" stroke-width="0.2"/>
            <rect fill="none" height="80" stroke="currentColor" stroke-width="0.5" width="80" x="60" y="60"/>
        </svg>
        <svg class="position-absolute" style="bottom: -80px; left: -80px; width: 480px; height: 480px; color: #2d3133;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <path d="M10,10 L90,10 L90,90 L10,90 Z" fill="none" stroke="currentColor" stroke-width="0.1"/>
            <path d="M0,50 L100,50 M50,0 L50,100" stroke="currentColor" stroke-width="0.05"/>
            <circle cx="50" cy="50" fill="none" r="40" stroke="currentColor" stroke-width="0.1"/>
        </svg>
    </div>

    @yield('Content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        (function() {
            var overlay = document.getElementById('page-transition');
            if (!overlay) return;

            requestAnimationFrame(function() {
                overlay.style.opacity = '0';
                setTimeout(function() { overlay.style.pointerEvents = 'none'; }, 400);
            });

            document.addEventListener('click', function(e) {
                var link = e.target.closest('a');
                if (!link) return;
                var href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('#') || href.startsWith('/#') || href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('data-no-transition')) return;
                if (href.startsWith('http') && !href.startsWith(window.location.origin)) return;

                e.preventDefault();
                overlay.style.pointerEvents = 'auto';
                overlay.style.opacity = '1';
                setTimeout(function() { window.location.href = href; }, 380);
            });
        })();
    </script>
</body>
</html>
