@extends('layouts.app')

@section('content')

	@php
		$vista = request('vista', 'calendario');
	@endphp

	<style>
		.calendar-page {
			padding: 10px 0 4px;
		}

		.calendar-shell {
			background: linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
			border: 1px solid #e2e8f0;
			border-radius: 24px;
			padding: 18px;
			box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
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

		.calendar-btn.active {
			background: #6366f1;
			color: white;
			border-color: #6366f1;
		}

		.calendar-month {
			min-width: 220px;
			text-align: center;
			font-size: 17px;
			font-weight: 800;
			color: #0f172a;
			padding: 0 10px;
		}

		.month-picker-form {
			margin: 0;
		}

		.month-picker {
			min-width: 220px;
			text-align: center;
			font-size: 17px;
			font-weight: 800;
			color: #0f172a;
			padding: 10px 14px;
			border-radius: 12px;
			border: 1px solid transparent;
			background: #ffffff;
			outline: none;
			cursor: pointer;
		}

		.month-picker:hover {
			border-color: #bfdbfe;
			background: #f8fbff;
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

		.search-input:focus {
			border-color: #818cf8;
			box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
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
		}

		.search-btn:hover,
		.clear-btn:hover {
			background: #eff6ff;
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
			transition:
				transform .18s ease,
				box-shadow .18s ease,
				border-color .18s ease;
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

		.day-card.future-day .day-number,
		.day-card.future-day .day-date {
			color: #6b7280;
		}

		.day-card.future-day .assignment-box {
			background: #f8f5ff;
			border: 1px solid #d8ccff;
		}

		.day-card.future-day .employee-name {
			color: #374151;
		}

		.day-card.future-day .employee-meta {
			color: #7c3aed;
		}

		.day-card.manual-change {
			background: linear-gradient(180deg,
					#f5f3ff 0%,
					#ede9fe 100%) !important;

			border: 2px solid #8b5cf6 !important;

			box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
		}

		.day-card.manual-change .assignment-box {
			background: #ffffff !important;
			border: 1px solid #ddd6fe !important;
		}

		.day-card.manual-change .assignment-label {
			background: #ede9fe !important;
			color: #6d28d9 !important;
		}

		.day-card.manual-change .employee-name {
			color: #4c1d95 !important;
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

		.match-badge {
			background: #ede9fe;
			color: #6d28d9;
			font-size: 11px;
			font-weight: 800;
			border-radius: 999px;
			padding: 6px 10px;
		}

		.search-dim {
			opacity: 0.22;
			filter: grayscale(.15);
			transition: all .2s ease;
		}

		.search-highlight {
			opacity: 1 !important;
			border: 3px solid #8b5cf6 !important;
			box-shadow:
				0 0 0 5px rgba(139, 92, 246, 0.18),
				0 12px 30px rgba(139, 92, 246, 0.18) !important;

			transform: scale(1.02);
			z-index: 10;
		}

		.assignment-link {
			text-decoration: none;
			display: block;
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

		.replacement-box {
			margin-top: 10px;
			padding: 10px;
			border-radius: 14px;
			background: linear-gradient(180deg,
					#fff7ed 0%,
					#ffedd5 100%);
			border: 1px solid #fdba74;
		}

		.replacement-label {
			font-size: 10px;
			font-weight: 900;
			text-transform: uppercase;
			letter-spacing: .6px;
			color: #ea580c;
			margin-bottom: 4px;
		}

		.replacement-name {
			font-size: 13px;
			font-weight: 800;
			color: #7c2d12;
			line-height: 1.3;
		}

		.table-wrapper {
			width: 100%;
			overflow-x: auto;
		}

		.excel-table {
			width: 100%;
			border-collapse: collapse;
			background: white;
			border-radius: 16px;
			overflow: hidden;
		}

		.excel-table th {
			background: #eef2ff;
			color: #1e293b;
			font-size: 13px;
			font-weight: 800;
			padding: 14px;
			border-bottom: 1px solid #cbd5e1;
			text-align: left;
		}

		.excel-table td {
			padding: 14px;
			border-bottom: 1px solid #e2e8f0;
			color: #0f172a;
			font-size: 14px;
			font-weight: 600;
		}

		.excel-table tr:nth-child(even) {
			background: #f8fafc;
		}

		.excel-table tr:hover {
			background: #eff6ff;
		}

		.manual-row {
			background: #f5f3ff !important;
		}

		.manual-row td {
			color: #5b21b6;
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

			.calendar-month {
				min-width: unset;
				width: 100%;
				order: -1;
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
		}
	</style>

	<div class="calendar-page">

		<div class="calendar-header">

			<div class="search-wrap">

				<form
					method="GET"
					action="{{ route('calendario.index') }}"
					class="search-form">

					<input
						type="hidden"
						name="fecha"
						value="{{ $fechaVista->format('Y-m-d') }}">

					<input
						type="text"
						name="buscar"
						value="{{ $buscar ?? '' }}"
						class="search-input"
						placeholder="Buscar">

					<button type="submit" class="search-btn">
						Buscar
					</button>
					@if (!empty($buscar))
						<a
							href="{{ route('calendario.index', ['fecha' => $fechaVista->format('Y-m-d')]) }}"
							class="clear-btn">
							Limpiar
						</a>
					@endif

				</form>

			</div>

			<div class="calendar-title">
				<h2>Calendario de teléfonos</h2>
				<p>Asignaciones Actuales</p>
			</div>

			<div class="calendar-nav">

				<a
					href="{{ route('calendario.index', [
					    'fecha' => $fechaVista->copy()->subMonth()->format('Y-m-d'),
					    'vista' => $vista,
					]) }}"
					class="calendar-btn">
					← Mes anterior
				</a>

				<form
					method="GET"
					action="{{ route('calendario.index') }}"
					class="month-picker-form">

					<input type="hidden" name="vista" value="{{ $vista }}">

					<select
						name="fecha"
						class="month-picker"
						onchange="this.form.submit()">

						@for ($mes = 1; $mes <= 12; $mes++)
							@php
								$fechaMes = $fechaVista->copy()->month($mes)->startOfMonth();
							@endphp

							<option
								value="{{ $fechaMes->format('Y-m-d') }}"
								{{ $fechaVista->month == $mes ? 'selected' : '' }}>
								{{ ucfirst($fechaMes->translatedFormat('F Y')) }}
							</option>
						@endfor

					</select>

				</form>

				<a
					href="{{ route('calendario.index', [
					    'fecha' => $fechaVista->copy()->addMonth()->format('Y-m-d'),
					    'vista' => $vista,
					]) }}"
					class="calendar-btn">
					Mes siguiente →
				</a>

			</div>

		</div>

		<div style="display:flex;gap:12px;margin-bottom:18px;flex-wrap:wrap;">

			<a
				href="{{ route('calendario.index', ['vista' => 'calendario']) }}"
				class="calendar-btn {{ $vista === 'calendario' ? 'active' : '' }}">
				Vista Calendario
			</a>

			<a
				href="{{ route('calendario.index', ['vista' => 'lista']) }}"
				class="calendar-btn {{ $vista === 'lista' ? 'active' : '' }}">
				Vista Tabla
			</a>

		</div>

		@if ($vista === 'calendario')
			<div class="calendar-shell">

				<div class="weekdays">

					<div class="weekday">Lunes</div>
					<div class="weekday">Martes</div>
					<div class="weekday">Miércoles</div>
					<div class="weekday">Jueves</div>
					<div class="weekday">Viernes</div>
					<div class="weekday">Sábado</div>
					<div class="weekday">Domingo</div>

				</div>

				<div class="calendar-grid">

					@foreach ($diasCalendario as $dia)
						@php
							$esFin = in_array($dia['fecha']->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);

							$esFuturo = $dia['fecha']->isFuture();

							$esProvisional = $esFuturo && !empty($dia['asignacion']) && !empty($dia['asignacion']->provisional);

							$esManual = !empty($dia['asignacion']) && !empty($dia['asignacion']->modificado_manual);
						@endphp

						<div
							class="day-card
                    {{ !$dia['en_mes'] ? 'out-month' : '' }}
                    {{ $dia['es_hoy'] ? 'today' : '' }}
                    {{ $esFin ? 'weekend' : '' }}
                    {{ $esProvisional ? 'future-day' : '' }}
                    {{ $esManual ? 'manual-change' : '' }}
                    {{ !empty($buscar) && !$dia['coincide_busqueda'] ? 'search-dim' : '' }}
                    {{ !empty($buscar) && $dia['coincide_busqueda'] ? 'search-hit' : '' }}
                ">

							<div class="day-top">

								<div class="day-number-wrap">

									<div class="day-number">
										{{ $dia['fecha']->format('d') }}
									</div>

									<div class="day-date">
										{{ ucfirst($dia['fecha']->translatedFormat('D')) }}
										·
										{{ $dia['fecha']->format('d/m/Y') }}
									</div>

								</div>

								@if ($dia['es_hoy'])
									<div class="day-pill pill-hoy">
										Hoy
									</div>
								@endif

							</div>

							@if ($dia['asignacion'])
								@php
									$fechaDetalle = $dia['fecha']->format('Y-m-d');
								@endphp

								<a
									href="{{ route('calendario.show', $fechaDetalle) }}"
									class="assignment-link">

									<div class="assignment-box">

										<div class="assignment-label">

											<span class="dot"></span>

											@if ($esManual)
												Modificado
											@elseif($esProvisional)
												Provisional
											@else
												{{ $dia['asignacion']->tipo === 'fin_semana' ? 'Fin de semana' : 'Asignado' }}
											@endif

										</div>

										<div class="employee-name">

											{{ $dia['asignacion']->empleado->nombre ?? '' }}

											{{ $dia['asignacion']->empleado->apellidoPaterno ?? '' }}

											{{ $dia['asignacion']->empleado->apellidoMaterno ?? '' }}

										</div>

										@if ($esManual && !empty($dia['asignacion']->empleadoOriginal))
											<div class="replacement-box">

												<span class="replacement-label">
													Reemplaza a
												</span>

												<span class="replacement-name">

													{{ $dia['asignacion']->empleadoOriginal->nombre ?? '' }}

													{{ $dia['asignacion']->empleadoOriginal->apellidoPaterno ?? '' }}

													{{ $dia['asignacion']->empleadoOriginal->apellidoMaterno ?? '' }}

												</span>

											</div>
										@endif

										<div class="employee-meta">
											{{ $dia['asignacion']->nombre_dia }}
										</div>

									</div>

								</a>
							@else
								<div class="empty-state">
									Sin asignación
								</div>
							@endif

						</div>
					@endforeach

				</div>

			</div>
		@else
			<div class="calendar-shell">

				<div class="table-wrapper">

					<table class="excel-table">

						<thead>
							<tr>
								<th>Fecha</th>
								<th>Día</th>
								<th>Empleado</th>
								<th>Tipo</th>
								<th>Estado</th>
								<th>Reemplaza a</th>
							</tr>
						</thead>

						<tbody>

							@foreach ($diasCalendario as $dia)
								@php
									$asignacion = $dia['asignacion'] ?? null;

									$esManual = !empty($asignacion) && !empty($asignacion->modificado_manual);

									$esFuturo = $dia['fecha']->isFuture();

									$esProvisional = $esFuturo && !empty($asignacion) && !empty($asignacion->provisional);
								@endphp

								<tr class="{{ $esManual ? 'manual-row' : '' }}">

									<td>
										{{ $dia['fecha']->format('d/m/Y') }}
									</td>

									<td>
										{{ ucfirst($dia['fecha']->translatedFormat('l')) }}
									</td>

									<td>

										@if ($asignacion && $asignacion->empleado)
											{{ $asignacion->empleado->nombre }}

											{{ $asignacion->empleado->apellidoPaterno }}

											{{ $asignacion->empleado->apellidoMaterno }}
										@else
											Sin asignación
										@endif

									</td>

									<td>

										@if ($asignacion)
											{{ $asignacion->tipo === 'fin_semana' ? 'Fin de semana' : 'Normal' }}
										@else
											—
										@endif

									</td>

									<td>

										@if ($esManual)
											Modificado
										@elseif($esProvisional)
											Provisional
										@else
											Asignado
										@endif

									</td>

									<td>

										@if ($esManual && !empty($asignacion->empleadoOriginal))
											{{ $asignacion->empleadoOriginal->nombre ?? '' }}

											{{ $asignacion->empleadoOriginal->apellidoPaterno ?? '' }}

											{{ $asignacion->empleadoOriginal->apellidoMaterno ?? '' }}
										@else
											—
										@endif

									</td>

								</tr>
							@endforeach

						</tbody>

					</table>

				</div>

			</div>
		@endif

	</div>

@endsection
