<x-guest-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    body::before {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 20%, rgba(99,102,241,.25) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(168,85,247,.18) 0%, transparent 55%),
            radial-gradient(ellipse 50% 40% at 60% 10%, rgba(14,165,233,.12) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    body::after {
        content: '';
        position: fixed; inset: 0;
        background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        z-index: 0;
    }

    .login-wrap {
        position: relative; z-index: 10;
        width: 100%; max-width: 420px;
        padding: 20px;
        animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    
    .brand {
        display: flex; flex-direction: column;
        align-items: center; margin-bottom: 28px;
    }

    .brand-logo {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 800; color: white;
        margin-bottom: 14px;
        box-shadow: 0 8px 24px rgba(99,102,241,.4);
    }

    .brand-title {
        font-size: 22px; font-weight: 800;
        color: #f8fafc; letter-spacing: -.4px;
    }

    .brand-sub {
        font-size: 13px; color: #64748b;
        margin-top: 4px; text-align: center;
    }

    .login-card {
        background: rgba(255,255,255,.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 18px;
        padding: 32px 30px;
        box-shadow:
            0 4px 6px rgba(0,0,0,.2),
            0 20px 40px rgba(0,0,0,.3),
            inset 0 1px 0 rgba(255,255,255,.08);
    }

    .status-msg {
        background: rgba(16,185,129,.12);
        border: 1px solid rgba(16,185,129,.3);
        color: #6ee7b7;
        padding: 10px 14px; border-radius: 9px;
        font-size: 13px; font-weight: 500;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }

    .f-group { margin-bottom: 18px; }

    .f-label {
        display: block;
        font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .8px;
        color: #94a3b8; margin-bottom: 7px;
    }

    .f-input-wrap { position: relative; }

    .f-icon {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%);
        color: #475569; font-size: 13px; pointer-events: none;
    }

    .f-input {
        width: 100%; padding: 11px 13px 11px 38px;
        border-radius: 10px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        color: #000; font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none; transition: border-color .15s, box-shadow .15s, background .15s;
    }

    .f-input::placeholder { color: #475569; }

    .f-input:focus {
        border-color: rgba(99,102,241,.6);
        box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        background: rgba(255,255,255,.08);
    }

    .f-error {
        font-size: 12px; color: #fca5a5;
        margin-top: 6px; display: flex; align-items: center; gap: 5px;
    }

    .f-row {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-top: 4px; margin-bottom: 22px;
    }

    .remember-label {
        display: flex; align-items: center; gap: 8px;
        cursor: pointer; font-size: 13px; color: #94a3b8;
        user-select: none;
    }

    .remember-check {
        width: 16px; height: 16px;
        accent-color: #6366f1;
        border-radius: 4px; cursor: pointer;
    }

    .forgot-link {
        font-size: 13px; color: #818cf8;
        text-decoration: none; font-weight: 500;
        transition: color .15s;
    }
    .forgot-link:hover { color: #a5b4fc; }

    .btn-login {
        width: 100%; padding: 12px;
        border-radius: 10px; border: none; cursor: pointer;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white; font-size: 15px; font-weight: 700;
        font-family: 'Inter', sans-serif; letter-spacing: .2px;
        transition: opacity .15s, transform .1s;
        box-shadow: 0 4px 14px rgba(99,102,241,.4);
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .btn-login:hover { opacity: .9; transform: translateY(-1px); }
    .btn-login:active { transform: translateY(0); }

    .login-footer {
        text-align: center; margin-top: 22px;
        font-size: 12px; color: #334155;
    }
</style>

<div class="login-wrap">

   
    <div class="brand">
        <div class="brand-logo">HR</div>
        <div class="brand-title">Bienvenido de nuevo</div>
        <div class="brand-sub">Inicia sesión para continuar al sistema</div>
    </div>

   
    <div class="login-card">

        @if(session('status'))
            <div class="status-msg">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            
            <div class="f-group">
                <label class="f-label" for="email">Correo electrónico</label>
                <div class="f-input-wrap">
                    <i class="fas fa-envelope f-icon"></i>
                    <input id="email" class="f-input" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="tu@correo.com"
                           required autofocus autocomplete="username">
                </div>
                @if($errors->get('email'))
                    @foreach($errors->get('email') as $msg)
                        <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $msg }}</div>
                    @endforeach
                @endif
            </div>

         
            <div class="f-group">
                <label class="f-label" for="password">Contraseña</label>
                <div class="f-input-wrap">
                    <i class="fas fa-lock f-icon"></i>
                    <input id="password" class="f-input" type="password" name="password"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                </div>
                @if($errors->get('password'))
                    @foreach($errors->get('password') as $msg)
                        <div class="f-error"><i class="fas fa-exclamation-circle"></i> {{ $msg }}</div>
                    @endforeach
                @endif
            </div>

            <div class="f-row">
                <label class="remember-label" for="remember_me">
                    <input id="remember_me" class="remember-check" type="checkbox" name="remember">
                    Recordarme
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
    </div>

    <div class="login-footer">
        © {{ date('Y') }} {{ config('app.name', 'Laravel') }} — Sistema de Gestión
    </div>
</div>

</x-guest-layout>