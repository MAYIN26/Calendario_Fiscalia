@extends("layouts.app")

@section("content")

<style>
    /* ── PAGE HEADER ─────────────────────────── */
    .page-hd {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
    }
    .page-hd h2 { font-size: 22px; font-weight: 700; color: #0f172a; margin: 0; }
    .page-hd small { font-size: 13px; color: #94a3b8; display: block; margin-top: 2px; }
    

    /* ── BTN AGREGAR ─────────────────────────── */
    .btn-agregar {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 9px;
        background: #6366f1; color: white; font-size: 14px;
        font-weight: 600; text-decoration: none; border: none;
        transition: background .15s, transform .1s;
    }
    .btn-agregar:hover { background: #4f46e5; color: white; transform: translateY(-1px); }

    /* ── ALERT ───────────────────────────────── */
    .alert-ok {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; font-size: 14px; font-weight: 500;
        margin-bottom: 20px; animation: fadeIn .3s ease;
    }
    @keyframes fadeIn { from { opacity:0; transform:translateY(-8px) } to { opacity:1; transform:none } }

    /* ── CARD + TABLE ────────────────────────── */
    .table-card {
        background: white; border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.06);
    }
    .table-card-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .table-card-head span { font-size: 14px; font-weight: 600; color: #0f172a; }
    .badge-count {
        background: #ede9fe; color: #6366f1;
        font-size: 12px; font-weight: 600;
        padding: 2px 10px; border-radius: 20px;
    }

    /* tabla */
    .emp-table { width: 100%; border-collapse: collapse; }
    .emp-table thead th {
        background: #f8fafc; padding: 11px 16px;
        font-size: 11px; text-transform: uppercase;
        letter-spacing: .9px; color: #64748b;
        font-weight: 600; border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .emp-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
    .emp-table tbody tr:last-child { border-bottom: none; }
    .emp-table tbody tr:hover { background: #f8fafc; }
    .emp-table td { padding: 13px 16px; font-size: 14px; color: #1e293b; vertical-align: middle; }

    /* número de fila */
    .row-n { font-size: 12px; color: #94a3b8; font-weight: 600; width: 40px; }

    /* foto */
    .emp-img {
        width: 46px; height: 46px; object-fit: cover;
        border-radius: 10px; border: 2px solid #e2e8f0;
    }

    .emp-img.placeholder {
        display: inline-flex; align-items: center; justify-content: center;
        width: 46px; height: 46px; background: #f8fafc;
        border-radius: 10px; border: 2px solid #e2e8f0;
        color: #64748b; font-size: 11px; font-weight: 700;
        text-transform: uppercase;
    }

    /* nombre */
    .emp-name { font-weight: 600; color: #0f172a; }

    /* curp */
    .curp-pill {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .5px;
    }

    /* email */
    .email-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: #eff6ff; border: 1px solid #bfdbfe;
        color: #1d4ed8; padding: 4px 10px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
    }

    /* acciones */
    .btn-edit-t {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 7px; font-size: 12px;
        font-weight: 600; text-decoration: none;
        background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8;
        transition: all .15s;
    }
    .btn-edit-t:hover { background: #dbeafe; color: #1d4ed8; }

    .btn-del-t {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 7px; font-size: 12px;
        font-weight: 600; background: #fff1f2; border: 1px solid #fecdd3;
        color: #be123c; cursor: pointer; transition: all .15s;
        font-family: 'Inter', sans-serif;
    }
    .btn-del-t:hover { background: #ffe4e6; }

    .employee-search-wrap {
    margin-bottom: 18px;
}

.employee-search-form {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.employee-search-input {
    width: 360px;
    max-width: 100%;
    padding: 10px 14px;
    border: 1px solid #dbeafe;
    border-radius: 10px;
    background: white;
    color: #0f172a;
    font-size: 14px;
    outline: none;
}

.employee-search-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
}

.employee-search-btn,
.employee-clear-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.employee-search-btn {
    border: none;
    background: #6366f1;
    color: white;
    cursor: pointer;
}

.employee-search-btn:hover {
    background: #4f46e5;
}

.employee-clear-btn {
    border: 1px solid #dbeafe;
    background: white;
    color: #1e3a8a;
}

.employee-clear-btn:hover {
    background: #eff6ff;
}

    /* paginación */
    .pag-wrap { padding: 14px 20px; border-top: 1px solid #f1f5f9; }
    .pag-wrap .pagination { margin: 0; justify-content: flex-end; }
</style>

{{-- ALERT --}}
@if(Session::has('mensaje'))
    <div class="alert-ok">
        <i class="fas fa-check-circle"></i> {{ Session::get('mensaje') }}
    </div>
@endif

{{-- ENCABEZADO --}}
<div class="page-hd">
    <div>
        <h2>Empleados</h2>
        <small>Gestión del personal registrado en el sistema</small>
    </div>
    <a href="{{ url('/empleados/create') }}" class="btn-agregar">
        <i class="fas fa-plus"></i> Agregar Empleado
    </a>
</div>

<div class="employee-search-wrap">

    <form method="GET" action="{{ url('/empleados') }}" class="employee-search-form">

        <input
            type="text"
            name="buscar"
            value="{{ $buscar ?? '' }}"
            class="employee-search-input"
            placeholder="Buscar por nombre, apellido, alias, CURP o correo"
        >

        <button type="submit" class="employee-search-btn">
            <i class="fas fa-search"></i>
            Buscar
        </button>

        @if(!empty($buscar))
            <a href="{{ url('/empleados') }}" class="employee-clear-btn">
                Limpiar
            </a>
        @endif

    </form>

</div>

{{-- TABLA --}}
<div class="table-card">
    <div class="table-card-head">
        <span>Lista de empleados</span>
        <span class="badge-count">{{ $empleados->total() }} registros</span>
    </div>

    <div class="table-responsive">
        <table class="emp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>CURP</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                <tr>
                    <td class="row-n">{{ ($empleados->currentPage() - 1) * $empleados->perPage() + $loop->iteration }}</td>
                    <td>
                        @if ($empleado->foto)
                            <img src="{{ Storage::url($empleado->foto) }}"
                                 class="emp-img" alt="{{ $empleado->nombre }}">
                        @else
                            <div class="emp-img placeholder">SIN FOTO</div>
                        @endif
                    </td>
                    <td class="emp-name">{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellidoPaterno }}</td>
                    <td>{{ $empleado->apellidoMaterno }}</td>
                    <td>
                        <span class="curp-pill">
                            {{ $empleado->curp }}
                        </span>
                    </td>
                    <td>
                        <span class="email-pill">
                            <i class="fas fa-envelope" style="font-size:10px"></i>
                            {{ $empleado->Correo }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/empleados/'.$empleado->id.'/edit') }}" class="btn-edit-t">
                                <i class="fas fa-pen"></i> Editar
                            </a>
                            <form action="{{ url('/empleados/'.$empleado->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del-t"
                                    onclick="return confirm('¿Eliminar a {{ $empleado->nombre }}?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding: 30px 0; color: #64748b;">
                        No hay empleados registrados aún. Agrega uno para comenzar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="pag-wrap">
        @if ($empleados->total() > 0)
            {{ $empleados->links('pagination::bootstrap-5') }}
        @endif
    </div>

@endsection