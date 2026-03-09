<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tuservice') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0b1f3a">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-bg: #0b1f3a;
            --sidebar-link: rgba(255, 255, 255, 0.7);
            --sidebar-link-active: #fff;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f5f7fb;
            margin: 0;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            background-color: #f5f7fb;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: #fff;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sidebar-logo {
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--sidebar-link);
            text-decoration: none;
            padding: 0.65rem 0.9rem;
            border-radius: 0.65rem;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--sidebar-link-active);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.12);
            color: var(--sidebar-link-active);
        }

        .sidebar-user {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            padding-top: 1rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.35);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        body.sidebar-open .sidebar-overlay {
            opacity: 1;
            visibility: visible;
        }

        .main-content {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            border: none;
            background: transparent;
            font-size: 1.5rem;
            color: #0f172a;
        }

        .page-content {
            flex: 1;
            padding: 2rem;
        }

        .auth-card {
            max-width: 520px;
            margin: 3rem auto;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 240px;
                z-index: 1050;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .topbar {
                padding: 0.85rem 1.25rem;
            }

            .page-content {
                padding: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @auth
        @php
            $menuItems = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi-grid', 'active' => ['dashboard']],
                ['label' => 'Servicios', 'route' => 'servicios.index', 'icon' => 'bi-scissors', 'active' => ['servicios.*']],
                ['label' => 'Profesionales', 'route' => 'profesionales.index', 'icon' => 'bi-people', 'active' => ['profesionales.*']],
                ['label' => 'Clientes', 'route' => 'clientes.index', 'icon' => 'bi-person-lines-fill', 'active' => ['clientes.*']],
                ['label' => 'Agenda', 'route' => 'turnos.index', 'icon' => 'bi-calendar-event', 'active' => ['turnos.*']],
            ];
        @endphp

        <div class="app-shell">
            <aside class="sidebar" id="sidebar">
                <a class="sidebar-logo" href="{{ route('dashboard') }}">
                    <i class="bi bi-stars"></i> {{ config('app.name', 'Tuservice') }}
                </a>

                <nav class="sidebar-nav">
                    @foreach ($menuItems as $item)
                        @php
                            $patterns = (array) ($item['active'] ?? $item['route']);
                            $isActive = collect($patterns)->contains(fn ($pattern) => request()->routeIs($pattern));
                        @endphp
                        <a class="sidebar-link {{ $isActive ? 'active' : '' }}" href="{{ route($item['route']) }}">
                            <i class="bi {{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <div class="sidebar-user mt-auto">
                    <p class="mb-0">{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
                    <small>{{ auth()->user()->email }}</small>
                </div>
            </aside>

            <div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>

            <div class="main-content">
                <header class="topbar">
                    <button class="sidebar-toggle d-lg-none" id="sidebarToggle" type="button" aria-label="Abrir menú">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <span class="text-muted small d-none d-md-inline">
                            {{ auth()->user()->negocio?->nombre ?? 'Mi negocio' }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm" type="submit">Salir</button>
                        </form>
                    </div>
                </header>

                <div class="page-content">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="nav-logo" href="{{ route('login') }}">
                    {{ config('app.name', 'Tuservice') }}
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Ingresar</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Crear cuenta</a>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const links = document.querySelectorAll('.sidebar-link');

            const closeSidebar = () => body.classList.remove('sidebar-open');

            toggle?.addEventListener('click', () => {
                body.classList.toggle('sidebar-open');
            });

            overlay?.addEventListener('click', closeSidebar);

            links.forEach(link => {
                link.addEventListener('click', closeSidebar);
            });

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js').catch(() => {
                    console.warn('No se pudo registrar el service worker.');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
