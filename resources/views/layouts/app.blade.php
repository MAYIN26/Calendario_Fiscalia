<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --sidebar-bg:    #0f172a;
                --sidebar-line:  rgba(255,255,255,0.07);
                --accent:        #6366f1;
                --body-bg:       #f1f5f9;
                --sidebar-w:     240px;
                --topbar-h:      60px;
            }

            body { font-family: 'Inter', sans-serif; background: var(--body-bg); margin: 0; }

            /* ── SIDEBAR ───────────────────────────────── */
            .sidebar {
                position: fixed; top: 0; left: 0;
                width: var(--sidebar-w); height: 100vh;
                background: var(--sidebar-bg);
                border-right: 1px solid var(--sidebar-line);
                display: flex; flex-direction: column;
                z-index: 200;
            }

            .sidebar-brand {
                display: flex; align-items: center; gap: 10px;
                padding: 20px; border-bottom: 1px solid var(--sidebar-line);
                text-decoration: none;
            }
            .brand-logo {
                width: 36px; height: 36px; background: var(--accent);
                border-radius: 9px; display: flex; align-items: center;
                justify-content: center; font-size: 15px; font-weight: 700;
                color: white; flex-shrink: 0;
            }
            .brand-name { font-size: 15px; font-weight: 700; color: #f8fafc; }

            .sidebar-user {
                display: flex; align-items: center; gap: 10px;
                padding: 14px 20px; border-bottom: 1px solid var(--sidebar-line);
            }
            .user-av {
                width: 32px; height: 32px; border-radius: 50%;
                background: linear-gradient(135deg, var(--accent), #a855f7);
                display: flex; align-items: center; justify-content: center;
                font-size: 12px; font-weight: 700; color: white; flex-shrink: 0;
            }
            .user-name  { font-size: 13px; font-weight: 600; color: #e2e8f0; }
            .user-email { font-size: 11px; color: #64748b; margin-top: 1px; }

            .sidebar-nav {
                flex: 1; padding: 12px; overflow-y: auto;
                display: flex; flex-direction: column; gap: 2px;
            }
            .nav-sec {
                font-size: 10px; text-transform: uppercase; letter-spacing: 1.2px;
                color: #475569; padding: 10px 10px 4px; font-weight: 600;
            }
            .s-link {
                display: flex; align-items: center; gap: 10px;
                padding: 9px 12px; border-radius: 8px;
                color: #94a3b8; text-decoration: none;
                font-size: 13.5px; font-weight: 500; transition: all .15s;
            }
            .s-link i { width: 16px; text-align: center; font-size: 13px; }
            .s-link:hover  { background: rgba(255,255,255,.06); color: #f1f5f9; }
            .s-link.active { background: rgba(99,102,241,.15); color: #a5b4fc; font-weight: 600; }

            .sidebar-footer { padding: 12px; border-top: 1px solid var(--sidebar-line); }
            .logout-btn {
                display: flex; align-items: center; gap: 10px;
                width: 100%; padding: 9px 12px; border-radius: 8px;
                background: none; border: none; color: #f87171;
                font-size: 13.5px; font-weight: 500; cursor: pointer;
                transition: background .15s; font-family: 'Inter', sans-serif;
            }
            .logout-btn:hover { background: rgba(239,68,68,.1); }

            /* ── TOPBAR ────────────────────────────────── */
            .topbar {
                position: fixed; top: 0; left: var(--sidebar-w); right: 0;
                height: var(--topbar-h); background: white;
                border-bottom: 1px solid #e2e8f0;
                display: flex; align-items: center; padding: 0 28px;
                z-index: 100; gap: 10px;
            }
            .topbar-title { font-size: 16px; font-weight: 700; color: #0f172a; }
            .topbar-crumb { font-size: 13px; color: #94a3b8; }

            /* ── MAIN ──────────────────────────────────── */
            .main-wrap { margin-left: var(--sidebar-w); padding-top: var(--topbar-h); min-height: 100vh; }
            .page-content { padding: 28px 32px; }

            /* ── RESPONSIVE ────────────────────────────── */
            @media (max-width: 768px) {
                .sidebar { transform: translateX(-100%); transition: transform .25s; }
                .sidebar.show { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.35); }
                .main-wrap { margin-left: 0; }
                .topbar { left: 0; }
                .page-content { padding: 10px 14px; }
            }
        </style>
    </head>

    <body>
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <a class="sidebar-brand" href="{{ url('/empleados') }}">
                <div class="brand-logo">HR</div>
                <span class="brand-name">{{ config('app.name', 'Laravel') }}</span>
            </a>

            @auth
            <div class="sidebar-user">
                <div class="user-av">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            @endauth

            <nav class="sidebar-nav">
                <div class="nav-sec">Principal</div>

                <a href="{{ url('/empleados') }}"
                   class="s-link {{ request()->is('empleados*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Empleados
                </a>

                <a href="{{ url('/calendario') }}"
                   class="s-link {{ request()->is('calendario*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Calendario
                </a>

                @auth
                <div class="nav-sec" style="margin-top:6px">Cuenta</div>
                <a href="{{ route('profile.edit') }}"
                   class="s-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> Mi Perfil
                </a>
                @endauth
            </nav>

            @auth
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- TOPBAR -->
        <div class="topbar">
            <button class="btn btn-sm d-md-none me-1"
                    style="border:1px solid #e2e8f0;color:#64748b"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>

            @php
                $tituloPagina = 'Panel';

                if (request()->is('empleados*')) {
                    $tituloPagina = 'Empleados';
                } elseif (request()->is('calendario*')) {
                    $tituloPagina = 'Calendario';
                } elseif (request()->routeIs('profile.edit')) {
                    $tituloPagina = 'Mi Perfil';
                }
            @endphp

            <span class="topbar-title">
                @isset($header)
                    {{ $header }}
                @else
                    {{ $tituloPagina }}
                @endisset
            </span>

            <span class="topbar-crumb">
                ›
                @isset($header)
                    {{ $header }}
                @else
                    {{ $tituloPagina }}
                @endisset
            </span>
        </div>

        <!-- CONTENIDO -->
        <div class="main-wrap">
            <div class="page-content">
                @yield('content')
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>