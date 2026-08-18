<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario público</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<style>
    body {
        margin: 0;
        background: #f1f5f9;
        font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color: #0f172a;
    }

    .calendar-page {
        padding: 28px;
        max-width: 1600px;
        margin: 0 auto;
        min-height: 100vh;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .calendar-title h2 {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .calendar-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .calendar-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 8px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .calendar-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: 1px solid #dbeafe;
        background: #f8fbff;
        color: #1e3a8a;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 14px;
        border-radius: 12px;
        transition: all .2s ease;
    }

    .calendar-btn:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        transform: translateY(-1px);
    }

    .month-select-form {
        margin: 0;
    }

    .month-select {
        min-width: 210px;
        text-align: center;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #dbeafe;
        background: #ffffff;
        outline: none;
        cursor: pointer;
    }

    .month-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
    }

    .calendar-shell {
        background: linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 18px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
    }

    .weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .weekday {
        text-align: center;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        padding: 10px 0;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
    }

    .day-card {
        position: relative;
        min-height: 150px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        padding: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        overflow: hidden;
    }

    .day-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .day-card.out-month {
        background: #f8fafc;
        opacity: .58;
    }

    .day-card.today {
        border: 2px solid #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
    }

    .day-card.weekend {
        background: linear-gradient(180deg, #fcfcff 0%, #f8f7ff 100%);
    }

    .day-card.future-day {
        background: linear-gradient(180deg, #faf7ff 0%, #f4f0ff 100%);
        border: 1px dashed #c4b5fd;
        box-shadow: 0 8px 24px rgba(139, 92, 246, 0.08);
    }

    .day-card.manual-change {
        background: linear-gradient(180deg, #f5f3ff 0%, #ede9fe 100%) !important;
        border: 2px solid #8b5cf6 !important;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    }

    .day-card.manual-change .assignment-box {
        background: #ffffff !important;
        border: 1px solid #ddd6fe !important;
    }

    .day-card.manual-change .employee-name {
        color: #4c1d95 !important;
    }

    .day-card.manual-change .assignment-label {
        background: #ede9fe !important;
        color: #6d28d9 !important;
    }

    .day-top {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
    }

    .day-number-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .day-number {
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
        color: #0f172a;
    }

    .day-date {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .day-pill {
        font-size: 11px;
        font-weight: 800;
        border-radius: 999px;
        padding: 6px 10px;
        white-space: nowrap;
    }

    .pill-hoy {
        background: #e0e7ff;
        color: #4338ca;
    }

    .assignment-box {
        margin-top: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 12px;
    }

    .assignment-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        color: #4f46e5;
        background: #eef2ff;
        border-radius: 999px;
        padding: 5px 9px;
        margin-bottom: 10px;
    }

    .employee-name {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 6px;
    }

    .employee-meta {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .replacement-box {
        margin-top: 10px;
        padding: 10px;
        border-radius: 14px;
        background: linear-gradient(180deg, #eef2ff 0%, #e0e7ff 100%);
        border: 1px solid #c7d2fe;
    }

    .replacement-label {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #4f46e5;
        margin-bottom: 4px;
    }

    .replacement-name {
        font-size: 13px;
        font-weight: 800;
        color: #312e81;
        line-height: 1.3;
    }

    .empty-state {
        margin-top: 18px;
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6366f1;
        display: inline-block;
    }

    .search-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-input {
        min-width: 300px;
        padding: 10px 14px;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        background: #fff;
        font-size: 14px;
        color: #0f172a;
        outline: none;
    }

    .search-btn,
    .clear-btn {
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #dbeafe;
        background: #f8fbff;
        color: #1e3a8a;
        cursor: pointer;
    }

    .search-btn:hover,
    .clear-btn:hover {
        background: #eff6ff;
    }

    .day-card.search-dim {
        opacity: .35;
        transform: scale(.98);
    }

    .day-card.search-hit {
        border: 2px solid #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
    }

    .match-badge {
        background: #ede9fe;
        color: #6d28d9;
        font-size: 11px;
        font-weight: 800;
        border-radius: 999px;
        padding: 6px 10px;
    }

    @media (max-width: 1300px) {
        .calendar-grid,
        .weekdays {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 900px) {
        .calendar-grid,
        .weekdays {
            grid-template-columns: repeat(2, 1fr);
        }

        .month-select {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .calendar-grid,
        .weekdays {
            grid-template-columns: 1fr;
        }

        .day-card {
            min-height: 125px;
        }

        .search-input {
            min-width: unset;
            width: 100%;
        }
    }
</style>

<div class="calendar-page">

    <div class="calendar-header">

        {{-- BUSCADOR --}}
        <div class="search-wrap">
            <form
                method="GET"
                action="{{ route('calendario.publico') }}"
                class="search-form"
            >

                <input
                    type="hidden"
                    name="fecha"
                    value="{{ $fechaVista->format('Y-m-d') }}"
                >

                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar ?? '' }}"
                    class="search-input"
                    placeholder="Buscar por alias"
                >

                <button
                    type="submit"
                    class="search-btn"
                >
                    Buscar
                </button>

                @if(!empty($buscar))

                    <a
                        href="{{ route('calendario.publico', [
                            'fecha' => $fechaVista->format('Y-m-d')
                        ]) }}"
                        class="clear-btn"
                    >
                        Limpiar
                    </a>

                @endif

            </form>
        </div>


        {{-- TITULO --}}
        <div class="calendar-title">
            <h2>Calendario Público</h2>
            <p>Consulta de asignaciones</p>
        </div>


        {{-- NAVEGACION --}}
        <div class="calendar-nav">

            <a
                href="{{ route('calendario.publico', [
                    'fecha' => $fechaVista->copy()->subMonth()->format('Y-m-d'),
                    'buscar' => $buscar
                ]) }}"
                class="calendar-btn"
            >
                ← Mes anterior
            </a>


            <form
                method="GET"
                action="{{ route('calendario.publico') }}"
                class="month-select-form"
            >

                @if(!empty($buscar))

                    <input
                        type="hidden"
                        name="buscar"
                        value="{{ $buscar }}"
                    >

                @endif


                <select
                    name="fecha"
                    class="month-select"
                    onchange="this.form.submit()"
                >

                    @php
                        $anioActual = $fechaVista->year;
                    @endphp


                    @for($mes = 1; $mes <= 12; $mes++)

                        @php
                            $fechaMes = \Carbon\Carbon::create(
                                $anioActual,
                                $mes,
                                1
                            );
                        @endphp


                        <option
                            value="{{ $fechaMes->format('Y-m-d') }}"
                            {{ $fechaVista->month == $mes ? 'selected' : '' }}
                        >

                            {{ ucfirst($fechaMes->translatedFormat('F Y')) }}

                        </option>

                    @endfor

                </select>

            </form>


            <a
                href="{{ route('calendario.publico', [
                    'fecha' => $fechaVista->copy()->addMonth()->format('Y-m-d'),
                    'buscar' => $buscar
                ]) }}"
                class="calendar-btn"
            >
                Mes siguiente →
            </a>

        </div>

    </div>


    <div class="calendar-shell">

        {{-- DIAS DE LA SEMANA --}}
        <div class="weekdays">
            <div class="weekday">Lunes</div>
            <div class="weekday">Martes</div>
            <div class="weekday">Miércoles</div>
            <div class="weekday">Jueves</div>
            <div class="weekday">Viernes</div>
            <div class="weekday">Sábado</div>
            <div class="weekday">Domingo</div>
        </div>


        {{-- CALENDARIO --}}
        <div class="calendar-grid">

            @foreach($diasCalendario as $dia)

                @php

                    $esFin = in_array(
                        $dia['fecha']->dayOfWeek,
                        [
                            \Carbon\Carbon::SATURDAY,
                            \Carbon\Carbon::SUNDAY
                        ]
                    );

                    $esFuturo =
                        $dia['fecha']->isFuture();

                    $esProvisional =
                        $esFuturo &&
                        !empty($dia['asignacion']) &&
                        !empty($dia['asignacion']->provisional);

                    $esManual =
                        !empty($dia['asignacion']) &&
                        !empty($dia['asignacion']->modificado_manual);

                @endphp


                <div class="day-card
                    {{ !$dia['en_mes'] ? 'out-month' : '' }}
                    {{ $dia['es_hoy'] ? 'today' : '' }}
                    {{ $esFin ? 'weekend' : '' }}
                    {{ $esProvisional ? 'future-day' : '' }}
                    {{ $esManual ? 'manual-change' : '' }}
                    {{ !empty($buscar) && !$dia['coincide_busqueda'] ? 'search-dim' : '' }}
                    {{ !empty($buscar) && $dia['coincide_busqueda'] ? 'search-hit' : '' }}
                ">

                    {{-- CABECERA DEL DIA --}}
                    <div class="day-top">

                        <div class="day-number-wrap">

                            <div class="day-number">
                                {{ $dia['fecha']->format('d') }}
                            </div>

                            <div class="day-date">

                                {{ ucfirst(
                                    $dia['fecha']->translatedFormat('D')
                                ) }}

                                ·

                                {{ $dia['fecha']->format('d/m/Y') }}

                            </div>

                        </div>


                        <div
                            style="
                                display:flex;
                                gap:6px;
                                flex-wrap:wrap;
                                justify-content:flex-end;
                            "
                        >

                            @if($dia['es_hoy'])

                                <span class="day-pill pill-hoy">
                                    Hoy
                                </span>

                            @endif


                            @if(!empty($buscar) && $dia['coincide_busqueda'])

                                <span class="match-badge">
                                    Coincide
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- ASIGNACION --}}
                    @if($dia['asignacion'])

                        <div class="assignment-box">

                            <div class="assignment-label">

                                <span class="dot"></span>


                                @if($esManual)

                                    Modificado

                                @elseif($esProvisional)

                                    Provisional

                                @else

                                    {{
                                        $dia['asignacion']->tipo === 'fin_semana'
                                            ? 'Fin de semana'
                                            : 'Asignado'
                                    }}

                                @endif

                            </div>


                            {{-- EMPLEADO ACTUAL --}}
                            <div class="employee-name">

                                @if(
                                    !empty(
                                        $dia['asignacion']
                                            ->empleado
                                            ->alias
                                    )
                                )

                                    {{
                                        $dia['asignacion']
                                            ->empleado
                                            ->alias
                                    }}

                                @else

                                    {{
                                        trim(
                                            ($dia['asignacion']->empleado->nombre ?? '')
                                            . ' ' .
                                            ($dia['asignacion']->empleado->apellidoPaterno ?? '')
                                            . ' ' .
                                            ($dia['asignacion']->empleado->apellidoMaterno ?? '')
                                        )
                                    }}

                                @endif

                            </div>


                            {{-- REEMPLAZO MANUAL --}}
                            @if(
                                $esManual &&
                                !empty(
                                    $dia['asignacion']
                                        ->empleadoOriginal
                                )
                            )

                                <div class="replacement-box">

                                    <div class="replacement-label">
                                        Reemplaza a
                                    </div>


                                    <div class="replacement-name">

                                        @if(
                                            !empty(
                                                $dia['asignacion']
                                                    ->empleadoOriginal
                                                    ->alias
                                            )
                                        )

                                            {{
                                                $dia['asignacion']
                                                    ->empleadoOriginal
                                                    ->alias
                                            }}

                                        @else

                                            {{
                                                trim(
                                                    ($dia['asignacion']->empleadoOriginal->nombre ?? '')
                                                    . ' ' .
                                                    ($dia['asignacion']->empleadoOriginal->apellidoPaterno ?? '')
                                                    . ' ' .
                                                    ($dia['asignacion']->empleadoOriginal->apellidoMaterno ?? '')
                                                )
                                            }}

                                        @endif

                                    </div>

                                </div>

                            @endif


                            <div class="employee-meta">

                                {{
                                    $dia['asignacion']
                                        ->nombre_dia
                                }}

                            </div>

                        </div>

                    @else

                        <div class="empty-state">
                            Sin asignación
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

</div>

</body>
</html>