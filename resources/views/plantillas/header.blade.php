<nav class="w-100 py-2 site-header" style="background-color: #fff; border-bottom: 1px solid #E2E8F0;">
    <div class="container d-flex align-items-center flex-nowrap gap-2 px-2" style="max-width: 1200px;">
        <div class="d-flex align-items-center gap-2" style="font-family: 'Inter', sans-serif; font-weight: 700; color: #7A431D; font-size: clamp(0.875rem, 4vw, 1.125rem); letter-spacing: -0.02em; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('imagenes/Web-Covao-Nocturno.webp') }}" alt="COVAO Nocturno"
                 style="height: 34px; width: auto; object-fit: contain; display: block; flex-shrink: 0;">
            <img src="{{ asset('imagenes/icono.png') }}" alt="ExpoTÉCNICA 2026"
                 style="height: 34px; width: auto; object-fit: contain; display: block; flex-shrink: 0;">
            <span class="d-none d-sm-inline">ExpoTÉCNICA 2026</span>
        </div>

        <div class="d-none d-sm-flex align-items-center justify-content-center gap-1" style="flex: 1 1 auto;">
            @php
                $currentPath = request()->path();
            @endphp

            <a href="/"
               class="text-decoration-none px-3 py-1 rounded header-link"
               style="font-weight: 500; font-size: 0.9375rem; border-radius: 0.5rem; transition: all 0.15s ease; {{ $currentPath === '' ? 'background-color: #FFF3E0; color: #E67E22;' : 'color: #2C3E50;' }}"
               onmouseover="if('{{ $currentPath }}' !== '') { this.style.backgroundColor='#FFF3E0'; this.style.color='#E67E22'; }"
               onmouseout="if('{{ $currentPath }}' !== '') { this.style.backgroundColor='transparent'; this.style.color='#2C3E50'; }">Inicio</a>

            <a href="/#proceso"
               class="text-decoration-none px-3 py-1 rounded header-link"
               style="font-weight: 500; font-size: 0.9375rem; border-radius: 0.5rem; transition: all 0.15s ease; color: #2C3E50;"
               onmouseover="this.style.backgroundColor='#FFF3E0'; this.style.color='#E67E22';"
               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2C3E50';">Proceso</a>

            <a href="/#categorias"
               class="text-decoration-none px-3 py-1 rounded header-link"
               style="font-weight: 500; font-size: 0.9375rem; border-radius: 0.5rem; transition: all 0.15s ease; color: #2C3E50;"
               onmouseover="this.style.backgroundColor='#FFF3E0'; this.style.color='#E67E22';"
               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2C3E50';">Categorías</a>

            @auth
                @if(Auth::user()->IDrol === 1)
                    <a href="/admin/dashboard"
                       class="text-decoration-none px-3 py-1 rounded header-link"
                       style="font-weight: 500; font-size: 0.9375rem; border-radius: 0.5rem; transition: all 0.15s ease; {{ str_starts_with($currentPath, 'admin') ? 'background-color: #FFF3E0; color: #E67E22;' : 'color: #2C3E50;' }}"
                       onmouseover="this.style.backgroundColor='#FFF3E0'; this.style.color='#E67E22';"
                       onmouseout="if(!{{ str_starts_with($currentPath, 'admin') ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='#2C3E50'; }">Admin</a>
                @endif
            @endauth
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 ms-auto" style="flex-shrink: 0; min-width: 0;">
            @auth
                <button type="button" class="btn btn-sm d-inline-flex align-items-center gap-1"
                    style="border: 1px solid #E2E8F0; border-radius: 0.5rem; color: #2C3E50; background-color: #F8FAFC; font-weight: 600; font-size: 0.8125rem; flex-shrink: 0; white-space: nowrap;"
                    onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                    <i class="bi bi-box-arrow-right" style="font-size: 0.9375rem;"></i>
                    Cerrar sesión
                </button>
                <form id="logout-form-header" action="/logout" method="POST" class="d-none">@csrf</form>
            @else
                <a href="/login" class="btn btn-sm d-inline-flex align-items-center gap-1 text-decoration-none"
                    style="border: 1px solid #E2E8F0; border-radius: 0.5rem; color: #2C3E50; background-color: #F8FAFC; font-weight: 600; font-size: 0.8125rem; flex-shrink: 0; white-space: nowrap;" aria-label="Iniciar sesión">
                    <i class="bi bi-person-circle" style="font-size: 0.9375rem;"></i>
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </div>
</nav>
