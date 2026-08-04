@extends("layouts.app")

@section("content")

<style>
    .detalle-wrap { max-width: 980px; margin: 0 auto; }
    .detalle-head { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 24px; }
    .detalle-head h2 { margin: 0; font-size: 30px; font-weight: 800; color: #0f172a; }
    .detalle-head p { margin: 6px 0 0; color: #64748b; font-size: 14px; }

    .btn-volver {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 16px; border-radius: 12px;
        border: 1px solid #cbd5e1; background: #fff;
        color: #1e293b; text-decoration: none; font-weight: 700;
    }

    .detalle-card {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0; border-radius: 24px;
        overflow: hidden; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    }

    .detalle-top {
        padding: 28px; display: grid;
        grid-template-columns: 160px 1fr; gap: 24px; align-items: center;
    }

    .foto-box {
        width: 160px; height: 160px; border-radius: 24px;
        overflow: hidden; border: 4px solid #e2e8f0;
        background: #eef2ff; display: flex; align-items: center; justify-content: center;
    }

    .foto-box img { width: 100%; height: 100%; object-fit: cover; }
    .foto-placeholder { font-size: 54px; font-weight: 800; color: #6366f1; }

    .empleado-nombre {
        font-size: 34px; line-height: 1.1;
        font-weight: 800; color: #0f172a; margin-bottom: 12px;
    }

    .estado-badge {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 14px; border-radius: 999px;
        font-size: 13px; font-weight: 800;
    }

    .estado-activo { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .estado-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .mini-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }

    .manual-alert {
        margin: 0 28px 20px;
        padding: 16px;
        border-radius: 16px;
        background: #fff1f2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        font-size: 14px;
        font-weight: 700;
    }

    .detalle-info {
        border-top: 1px solid #e2e8f0;
        padding: 24px 28px 28px;
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    }

    .info-box {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 18px; padding: 18px;
    }

    .info-label {
        font-size: 11px; text-transform: uppercase; letter-spacing: .8px;
        color: #64748b; font-weight: 700; margin-bottom: 8px;
    }

    .info-value { font-size: 18px; font-weight: 800; color: #0f172a; }

    .change-box {
        margin: 0 28px 28px; background: #ffffff;
        border: 1px solid #e2e8f0; border-radius: 20px; padding: 20px;
    }

    .change-title { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .change-text { font-size: 13px; color: #64748b; margin-bottom: 14px; }

    .autocomplete-wrap { position: relative; }

    .autocomplete-input {
        width: 100%; padding: 12px 14px;
        border-radius: 12px; border: 1px solid #cbd5e1;
        outline: none; font-size: 14px; font-weight: 600;
        color: #0f172a; background: #f8fafc;
    }

    .autocomplete-input:focus {
        border-color: #6366f1; background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .12);
    }

    .suggestions-box {
        position: absolute; top: calc(100% + 8px); left: 0; right: 0;
        background: #111827; border-radius: 14px; padding: 6px;
        display: none; z-index: 50;
        box-shadow: 0 16px 30px rgba(15, 23, 42, .25);
        max-height: 230px; overflow-y: auto;
    }

    .suggestion-item {
        width: 100%; border: none; background: transparent;
        color: white; text-align: left; padding: 10px 12px;
        border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer;
    }

    .suggestion-item:hover { background: rgba(255,255,255,.12); }

    .btn-change {
        margin-top: 12px; width: 100%; padding: 12px;
        border: none; border-radius: 12px;
        background: linear-gradient(135deg, #6366f1, #2563eb);
        color: white; font-weight: 800;
        cursor: pointer;
    }

    .btn-change:disabled { opacity: .45; cursor: not-allowed; }

    .btn-restore {
        margin-top: 12px;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: #fff1f2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        font-weight: 800;
        cursor: pointer;
    }

    .btn-restore:hover {
        background: #ffe4e6;
    }

    .locked-box {
        margin: 0 28px 28px; padding: 16px; border-radius: 16px;
        background: #f1f5f9; border: 1px solid #e2e8f0;
        color: #64748b; font-weight: 700; font-size: 14px;
    }

    .actions-row { margin: 0 28px 28px; }

    @media (max-width: 768px) {
        .detalle-top { grid-template-columns: 1fr; text-align: center; }
        .foto-box { margin: 0 auto; }
        .detalle-info { grid-template-columns: 1fr; }
        .empleado-nombre { font-size: 28px; }
    }
</style>

<div class="detalle-wrap">
    <div class="detalle-head">
        <div>
            <h2>Detalle del día</h2>
            <p>Información del empleado asignado</p>
        </div>

        <a href="{{ url('/calendario?fecha=' . $fecha->format('Y-m-d')) }}" class="btn-volver">
            ← Volver al calendario
        </a>
    </div>

    @if(Session::has('mensaje'))
        <div class="alert alert-success">{{ Session::get('mensaje') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="detalle-card">
        <div class="detalle-top">
            <div class="foto-box">
                @if(!empty($asignacion->empleado->foto))
                    <img src="{{ Storage::url($asignacion->empleado->foto) }}" alt="Foto del empleado">
                @else
                    <div class="foto-placeholder">
                        {{ strtoupper(substr($asignacion->empleado->nombre, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div>
                <div class="empleado-nombre">
                    {{ $asignacion->empleado->nombre }}
                    {{ $asignacion->empleado->apellidoPaterno }}
                    {{ $asignacion->empleado->apellidoMaterno }}
                </div>

                @if(isset($asignacion->empleado->activo) && $asignacion->empleado->activo)
                    <span class="estado-badge estado-activo">
                        <span class="mini-dot"></span> Activo
                    </span>
                @else
                    <span class="estado-badge estado-inactivo">
                        <span class="mini-dot"></span> Inactivo
                    </span>
                @endif
            </div>
        </div>

        @if(!empty($asignacion->modificado_manual) && $asignacion->modificado_manual)
            <div class="manual-alert">
                Este dia fue modificado manualmente.
            </div>
        @endif

        <div class="detalle-info">
            <div class="info-box">
                <div class="info-label">Fecha</div>
                <div class="info-value">{{ $fecha->format('d/m/Y') }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Día</div>
                <div class="info-value">{{ $asignacion->nombre_dia }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Tipo</div>
                <div class="info-value">
                    {{ $asignacion->tipo === 'fin_semana' ? 'Fin de semana' : 'Día normal' }}
                </div>
            </div>
        </div>

        @if($puedeCambiar)
            <div class="change-box">
                <div class="change-title">Cambiar empleado</div>
                <div class="change-text">
                    Escribe el nombre del empleado para cambiarlo
                </div>

                <form method="POST" action="{{ route('calendario.asignarManual') }}" id="formCambioEmpleado">
                    @csrf

                    <input type="hidden" name="fecha" value="{{ $fecha->format('Y-m-d') }}">
                    <input type="hidden" name="empleado_id" id="empleadoId">

                    <div class="autocomplete-wrap">
                        <input
                            type="text"
                            id="empleadoBuscar"
                            class="autocomplete-input"
                            placeholder=""
                            autocomplete="off"
                        >

                        <div class="suggestions-box" id="suggestionsBox"></div>
                    </div>

                    <button type="submit" class="btn-change" id="btnGuardarCambio" disabled>
                        Guardar cambio 
                    </button>
                </form>

                @if(!empty($asignacion->modificado_manual) && $asignacion->modificado_manual)
                    <form method="POST" action="{{ route('calendario.restaurarManual') }}">
                        @csrf

                        <input type="hidden" name="fecha" value="{{ $fecha->format('Y-m-d') }}">

                        <button
                            type="submit"
                            class="btn-restore"
                            onclick="return confirm('¿Seguro que quieres restaurar este día al empleado original?')"
                        >
                            Restaurar cambio manual
                        </button>
                    </form>
                @endif
            </div>
        @else
            <div class="locked-box">
                Este día ya pasó. Solo puedes consultar la asignación guardada.
            </div>
        @endif

        <div class="actions-row">
            <a class="btn-volver" href="{{ url('/empleados/'.$asignacion->empleado->id.'/edit') }}">
                <i class="fas fa-pen"></i> Editar empleado
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const empleados = @json($empleadosJS);

    const input = document.getElementById('empleadoBuscar');
    const empleadoId = document.getElementById('empleadoId');
    const suggestionsBox = document.getElementById('suggestionsBox');
    const btnGuardar = document.getElementById('btnGuardarCambio');

    if (!input || !empleadoId || !suggestionsBox || !btnGuardar) return;

    function normalizar(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/ñ/g, 'n');
    }

    function cerrarSugerencias() {
        suggestionsBox.style.display = 'none';
        suggestionsBox.innerHTML = '';
    }

    function seleccionarEmpleado(emp) {
        input.value = emp.nombre;
        empleadoId.value = emp.id;
        btnGuardar.disabled = false;
        cerrarSugerencias();
    }

    input.addEventListener('input', function () {
        const texto = normalizar(input.value.trim());

        empleadoId.value = '';
        btnGuardar.disabled = true;

        if (texto.length < 1) {
            cerrarSugerencias();
            return;
        }

        const coincidencias = empleados
            .filter(emp => normalizar(emp.nombre).includes(texto))
            .slice(0, 8);

        if (coincidencias.length === 0) {
            suggestionsBox.innerHTML = `
                <div style="padding:10px 12px; color:#cbd5e1; font-size:13px; font-weight:700;">
                    No se encontraron empleados
                </div>
            `;
            suggestionsBox.style.display = 'block';
            return;
        }

        suggestionsBox.innerHTML = coincidencias.map(emp => `
            <button type="button" class="suggestion-item" data-id="${emp.id}" data-name="${emp.nombre}">
                ${emp.nombre}
            </button>
        `).join('');

        suggestionsBox.style.display = 'block';
    });

    suggestionsBox.addEventListener('click', function (e) {
        const btn = e.target.closest('.suggestion-item');
        if (!btn) return;

        seleccionarEmpleado({
            id: btn.dataset.id,
            nombre: btn.dataset.name
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.autocomplete-wrap')) {
            cerrarSugerencias();
        }
    });
});
</script>

@endsection