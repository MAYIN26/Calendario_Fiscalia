<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleados;
use App\Models\AsignacionCalendario;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->construirDatosCalendario($request, true);

        $empleadosParaCambiar = Empleados::where('activo', 1)
            ->orderBy('id', 'asc')
            ->get();

        return view('calendario.index', array_merge($data, [
            'empleadosParaCambiar' => $empleadosParaCambiar,
        ]));
    }

    public function publico(Request $request)
    {
    $data = $this->construirDatosCalendario($request, true, true);

    return view('calendario.publico', $data);
    }

    public function show($fecha)
    {
        $fechaCarbon = Carbon::parse($fecha);
        $fechaInicioSistema = Carbon::create(config('app.system_create'))->startOfDay();

        $empleadosActivos = $this->obtenerEmpleadosActivos();

        $asignacion = AsignacionCalendario::with('empleado', "empleadoOriginal")
            ->where('fecha', $fechaCarbon->format('Y-m-d'))
            ->first();

        if (!$asignacion && $fechaCarbon->gte($fechaInicioSistema)) {
            $asignacion = $this->calcularAsignacionBase(
                $fechaCarbon->copy(),
                $fechaInicioSistema,
                $empleadosActivos,
                true
            );
        }

        if (!$asignacion) {
            abort(404);
        }

        $empleadosJS = $empleadosActivos->map(function ($emp) {
            $nombreCompleto = trim(
                $emp->nombre . ' ' .
                $emp->apellidoPaterno . ' ' .
                $emp->apellidoMaterno
            );

            return [
                'id' => $emp->id,
                'nombre' => $nombreCompleto,
                'normalizado' => strtolower(
                    str_replace(
                        ['á','é','í','ó','ú','ñ'],
                        ['a','e','i','o','u','n'],
                        $nombreCompleto
                    )
                ),
            ];
        });

        $puedeCambiar = $fechaCarbon->gte(Carbon::today());

        return view('calendario.show', [
            'asignacion' => $asignacion,
            'fecha' => $fechaCarbon,
            'empleadosParaCambiar' => $empleadosActivos,
            'empleadosJS' => $empleadosJS,
            'puedeCambiar' => $puedeCambiar,
        ]);
    }

    private function construirDatosCalendario(
    Request $request,
    bool $permitirBusqueda = true,
    bool $usarAlias = false
    ): array

    {
        Carbon::setLocale('es');

        $fechaInicioSistema = Carbon::create(config('app.system_create'))->startOfDay();
        $hoy = Carbon::today();

        $busqueda = $permitirBusqueda ? trim($request->get('buscar', '')) : '';

        $fechaVista = $request->get('fecha')
            ? Carbon::parse($request->get('fecha'))
            : $hoy->copy();

        if ($hoy->gte($fechaInicioSistema)) {
            $this->generarAsignacionesHastaHoy($fechaInicioSistema, $hoy);
        }

        $inicioMes = $fechaVista->copy()->startOfMonth();
        $finMes = $fechaVista->copy()->endOfMonth();

        $inicioCalendario = $inicioMes->copy()->startOfWeek(Carbon::MONDAY);
        $finCalendario = $finMes->copy()->endOfWeek(Carbon::SUNDAY);

        $asignacionesGuardadas = AsignacionCalendario::with('empleado', 'empleadoOriginal')
            ->whereBetween('fecha', [
                $inicioCalendario->format('Y-m-d'),
                $finCalendario->format('Y-m-d')
            ])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->fecha)->format('Y-m-d');
            });

        $empleadosActivos = $this->obtenerEmpleadosActivos();

        $asignacionesProvisionales = collect();

        if ($empleadosActivos->isNotEmpty() && $finCalendario->gt($hoy)) {
            $fechaInicioProvisional = $hoy->copy()->addDay();

            $asignacionesProvisionales = $this->generarAsignacionesProvisionalesContinuas(
                $fechaInicioProvisional,
                $finCalendario,
                $empleadosActivos
            );
        }

        $diasCalendario = [];
        $cursor = $inicioCalendario->copy();

        while ($cursor->lte($finCalendario)) {
            $fechaStr = $cursor->format('Y-m-d');

            $asignacion = $asignacionesGuardadas[$fechaStr] ?? null;

            if (
                !$asignacion &&
                $cursor->gt($hoy) &&
                $cursor->gte($fechaInicioSistema)
            ) {
                $asignacion = $asignacionesProvisionales[$fechaStr] ?? null;
            }

            $coincideBusqueda = false;

            if ($permitirBusqueda && $asignacion && $asignacion->empleado && $busqueda !== '') {
                $nombreCompleto = trim(
                    ($asignacion->empleado->nombre ?? '') . ' ' .
                    ($asignacion->empleado->apellidoPaterno ?? '') . ' ' .
                    ($asignacion->empleado->apellidoMaterno ?? '')
                    
                    );
                    
                    if ($usarAlias) {
                        $alias = $asignacion->empleado->alias ?? '';
                        $coincideBusqueda =
                        str_contains(
                            $this->normalizarTexto($alias),
                            $this->normalizarTexto($busqueda)
                            )
                            ||
                            str_contains(
                                $this->normalizarTexto($nombreCompleto),
                                $this->normalizarTexto($busqueda)
                                );
                                
                            } else {
                            $coincideBusqueda = str_contains(
                                $this->normalizarTexto($nombreCompleto),
                                $this->normalizarTexto($busqueda)
                                );
                            }
            }

            $diasCalendario[] = [
                'fecha' => $cursor->copy(),
                'en_mes' => $cursor->month === $fechaVista->month,
                'es_hoy' => $cursor->isSameDay($hoy),
                'asignacion' => $asignacion,
                'coincide_busqueda' => $coincideBusqueda,
            ];

            $cursor->addDay();
        }

        return [
            'fechaVista' => $fechaVista,
            'inicioMes' => $inicioMes,
            'finMes' => $finMes,
            'diasCalendario' => $diasCalendario,
            'buscar' => $busqueda,
        ];
    }

    private function generarAsignacionesHastaHoy(Carbon $fechaInicioSistema, Carbon $hoy): void
    {
        $empleadosActivos = $this->obtenerEmpleadosActivos();

        if ($empleadosActivos->isEmpty()) {
            return;
        }

        $fecha = $fechaInicioSistema->copy();

        while ($fecha->lte($hoy)) {
            $fechaStr = $fecha->format('Y-m-d');

            $yaExiste = AsignacionCalendario::where('fecha', $fechaStr)->exists();

            if (!$yaExiste) {
                $asignacion = $this->calcularAsignacionBase(
                    $fecha->copy(),
                    $fechaInicioSistema,
                    $empleadosActivos,
                    false
                );

                if ($asignacion && isset($asignacion->empleado)) {
                    AsignacionCalendario::create([
                        'empleado_id' => $asignacion->empleado->id,
                        'empleado_original_id' => null,
                        'fecha' => $fechaStr,
                        'nombre_dia' => $asignacion->nombre_dia,
                        'tipo' => $asignacion->tipo,
                        'modificado_manual' => false,
                    ]);
                }
            }

            $fecha->addDay();
        }
    }

    private function generarAsignacionesProvisionalesContinuas(
        Carbon $fechaInicio,
        Carbon $fechaFin,
        $empleadosActivos
    ) {
        $resultado = collect();

        if ($empleadosActivos->isEmpty() || $fechaInicio->gt($fechaFin)) {
            return $resultado;
        }

        $totalEmpleados = $empleadosActivos->count();


        $ultimoLaboralReal = AsignacionCalendario::with('empleado', 'empleadoOriginal')
            ->whereDate('fecha', '<', $fechaInicio->format('Y-m-d'))
            ->where('tipo', 'normal')
            ->orderBy('fecha', 'desc')
            ->first();

        $indiceLaboralActual = 0;

        if ($ultimoLaboralReal) {
            $empleadoBaseId = $this->obtenerEmpleadoBaseId($ultimoLaboralReal);

            $indiceUltimoLaboral = $this->obtenerIndiceEmpleadoPorId(
                $empleadosActivos,
                $empleadoBaseId
            );

            if ($indiceUltimoLaboral !== null) {
                $indiceLaboralActual = ($indiceUltimoLaboral + 1) % $totalEmpleados;
            }
        }

        $ultimoFinSemanaReal = AsignacionCalendario::with('empleado', 'empleadoOriginal')
            ->whereDate('fecha', '<', $fechaInicio->format('Y-m-d'))
            ->where('tipo', 'fin_semana')
            ->orderBy('fecha', 'desc')
            ->first();

        $indiceFinSemanaActual = 0;

        if ($ultimoFinSemanaReal) {
            $empleadoBaseId = $this->obtenerEmpleadoBaseId($ultimoFinSemanaReal);

            $indiceUltimoFinSemana = $this->obtenerIndiceEmpleadoPorId(
                $empleadosActivos,
                $empleadoBaseId
            );

            if ($indiceUltimoFinSemana !== null) {
                $indiceFinSemanaActual = ($indiceUltimoFinSemana + 1) % $totalEmpleados;
            }
        }

        $fecha = $fechaInicio->copy();

        while ($fecha->lte($fechaFin)) {
            $tipo = $fecha->isWeekend() ? 'fin_semana' : 'normal';

            if ($fecha->isSaturday()) {
                $empleadoAsignado = $empleadosActivos[$indiceFinSemanaActual];
            } elseif ($fecha->isSunday()) {
                $empleadoAsignado = $empleadosActivos[$indiceFinSemanaActual];
                $indiceFinSemanaActual = ($indiceFinSemanaActual + 1) % $totalEmpleados;
            } else {
                $empleadoAsignado = $empleadosActivos[$indiceLaboralActual];
                $indiceLaboralActual = ($indiceLaboralActual + 1) % $totalEmpleados;
            }

            $resultado[$fecha->format('Y-m-d')] = (object) [
                'empleado' => $empleadoAsignado,
                'tipo' => $tipo,
                'nombre_dia' => ucfirst($fecha->translatedFormat('l')),
                'provisional' => true,
                'modificado_manual' => false,
            ];

            $fecha->addDay();
        }

        return $resultado;
    }

    private function calcularAsignacionBase(
        Carbon $fecha,
        Carbon $fechaInicioSistema,
        $empleadosActivos,
        bool $provisional = false
    ) {
        $totalEmpleados = $empleadosActivos->count();

        if ($totalEmpleados === 0) {
            return null;
        }

        if ($fecha->isSaturday() || $fecha->isSunday()) {
            $indiceFinSemana = $this->obtenerIndiceFinSemana($fechaInicioSistema, $fecha);
            $indiceEmpleado = $indiceFinSemana % $totalEmpleados;
            $empleadoAsignado = $empleadosActivos[$indiceEmpleado];

            return (object) [
                'empleado' => $empleadoAsignado,
                'tipo' => 'fin_semana',
                'nombre_dia' => ucfirst($fecha->translatedFormat('l')),
                'provisional' => $provisional,
                'modificado_manual' => false,
            ];
        }

        $indiceLaboral = $this->obtenerIndiceLaboral($fechaInicioSistema, $fecha);
        $indiceEmpleado = $indiceLaboral % $totalEmpleados;
        $empleadoAsignado = $empleadosActivos[$indiceEmpleado];

        return (object) [
            'empleado' => $empleadoAsignado,
            'tipo' => 'normal',
            'nombre_dia' => ucfirst($fecha->translatedFormat('l')),
            'provisional' => $provisional,
            'modificado_manual' => false,
        ];
    }
    public function asignarManual(Request $request)
{
    $request->validate([
        'fecha' => 'required|date',
        'empleado_id' => 'required|exists:empleados,id',
    ]);

    $fecha = Carbon::parse($request->fecha);

    if ($fecha->lt(Carbon::today())) {
        return redirect()->back()->withErrors([
            'fecha' => 'No puedes modificar días anteriores.'
        ]);
    }

    $tipo = $fecha->isWeekend() ? 'fin_semana' : 'normal';

    $empleadosActivos = $this->obtenerEmpleadosActivos();

    $asignacionBase = $this->calcularAsignacionBase(
        $fecha->copy(),
        Carbon::create(config('app.system_create'))->startOfDay(),
        $empleadosActivos,
        false
    );

    $empleadoOriginalId = $asignacionBase && isset($asignacionBase->empleado)
        ? $asignacionBase->empleado->id
        : null;

    AsignacionCalendario::updateOrCreate(
        ['fecha' => $fecha->format('Y-m-d')],
        [
            'empleado_id' => $request->empleado_id,
            'empleado_original_id' => $empleadoOriginalId,
            'nombre_dia' => ucfirst($fecha->translatedFormat('l')),
            'tipo' => $tipo,
            'modificado_manual' => true,
        ]
    );

    return redirect()
        ->route('calendario.show', $fecha->format('Y-m-d'))
        ->with('mensaje', 'El Empleado a cambiado con Exito');
}

    public function restaurarManual(Request $request)
{
    $request->validate([
        'fecha' => 'required|date',
    ]);

    $fecha = Carbon::parse($request->fecha);

    if ($fecha->lt(Carbon::today())) {
        return redirect()->back()->withErrors([
            'fecha' => 'No puedes restaurar días anteriores.'
        ]);
    }

    $asignacion = AsignacionCalendario::where('fecha', $fecha->format('Y-m-d'))->first();

    if (!$asignacion) {
        return redirect()->back()->with('mensaje', 'No hay cambio manual para restaurar.');
    }

    if (!$asignacion->modificado_manual) {
        return redirect()->back()->with('mensaje', 'Esta asignación ya está en modo automático.');
    }

    $empleadoOriginalId = $asignacion->empleado_original_id;

    if (!$empleadoOriginalId) {
        return redirect()->back()->withErrors([
            'fecha' => 'No se encontró el empleado original.'
        ]);
    }

    $asignacion->update([
        'empleado_id' => $empleadoOriginalId,
        'empleado_original_id' => null,
        'modificado_manual' => false,
    ]);

    return redirect()
        ->route('calendario.show', $fecha->format('Y-m-d'))
        ->with('mensaje', 'Cambio manual asignado con éxito.');
}

    private function obtenerEmpleadoBaseId($asignacion): int
    {
        if (
            isset($asignacion->modificado_manual) &&
            $asignacion->modificado_manual &&
            !empty($asignacion->empleado_original_id)
        ) {
            return (int) $asignacion->empleado_original_id;
        }

        return (int) $asignacion->empleado_id;
    }

    private function obtenerIndiceLaboral(Carbon $fechaInicioSistema, Carbon $fechaObjetivo): int
    {
        $cursor = $fechaInicioSistema->copy();
        $contador = 0;

        while ($cursor->lt($fechaObjetivo)) {
            if ($cursor->isWeekday()) {
                $contador++;
            }

            $cursor->addDay();
        }

        return $contador;
    }

    private function obtenerIndiceFinSemana(Carbon $fechaInicioSistema, Carbon $fechaObjetivo): int
    {
        $inicioSemanaSistema = $fechaInicioSistema->copy()->startOfWeek(Carbon::MONDAY);
        $inicioSemanaObjetivo = $fechaObjetivo->copy()->startOfWeek(Carbon::MONDAY);

        return $inicioSemanaSistema->diffInWeeks($inicioSemanaObjetivo);
    }

    private function obtenerEmpleadosActivos()
    {
        return Empleados::where('activo', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->values();
    }

    private function obtenerIndiceEmpleadoPorId($empleadosActivos, int $empleadoId): ?int
    {
        $indice = $empleadosActivos->search(function ($empleado) use ($empleadoId) {
            return (int) $empleado->id === (int) $empleadoId;
        });

        return $indice === false ? null : $indice;
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        $reemplazos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'u', 'ü' => 'u',
            'ñ' => 'n',
        ];

        return strtr($texto, $reemplazos);
    }
}
