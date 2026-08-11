<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>@yield('Title', 'ExpoTÉCNICA 2026')</title>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Page transition overlay --}}
    <div id="page-transition" style="position:fixed;inset:0;background:#f7f9fb;z-index:9999;opacity:1;pointer-events:none;transition:opacity 0.35s ease;"></div>

    @hasSection('Header')
        <header class="">@yield('Header')</header>
    @else
        <header class="">@include('plantillas.header')</header>
    @endif

    <main class="flex-grow-1">@yield('Main')</main>

    @hasSection('Footer')
        @yield('Footer')
    @else
        <footer>@include('plantillas.footer')</footer>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        (function() {
            var overlay = document.getElementById('page-transition');
            if (!overlay) return;

            // Reveal page on load
            requestAnimationFrame(function() {
                overlay.style.opacity = '0';
                setTimeout(function() { overlay.style.pointerEvents = 'none'; }, 400);
            });

            // Intercept internal links
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
