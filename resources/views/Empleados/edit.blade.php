@extends("layouts.app")

@section("content")

<style>
    .form-card {
        max-width: 620px; margin: 0 auto;
        background: white; border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .form-card-head {
        display: flex; align-items: center; gap: 12px;
        padding: 20px 24px; border-bottom: 1px solid #f1f5f9;
    }
    .form-head-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: #0ea5e9; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 16px; flex-shrink: 0;
    }
    .form-head-title { font-size: 16px; font-weight: 700; color: #0f172a; }
    .form-head-sub   { font-size: 12px; color: #94a3b8; margin-top: 2px; }
    .form-head-badge {
        margin-left: auto; background: #eff6ff; border: 1px solid #bfdbfe;
        color: #1d4ed8; font-size: 11px; font-weight: 700;
        padding: 4px 12px; border-radius: 20px;
    }

    .form-card-body { padding: 24px; }
</style>

{{-- BACK LINK ────────────────────────────────────── --}}
<a href="{{ url('/empleados') }}"
   style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#64748b;
          text-decoration:none;margin-bottom:20px;transition:color .15s"
   onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
    <i class="fas fa-arrow-left" style="font-size:11px"></i> Volver a Empleados
</a>

<div class="form-card">
    <div class="form-card-head">
        <div class="form-head-icon"><i class="fas fa-user-edit"></i></div>
        <div>
            <div class="form-head-title">Editar Empleado</div>
            <div class="form-head-sub">Modifica la información del empleado</div>
        </div>
        <span class="form-head-badge">ID #{{ $empleados->id }}</span>
    </div>
<form action="{{ url('/empleados/'.$empleados->id.'/toggle') }}" method="POST">
    @csrf
    @method('PUT')

    @if($empleados->activo)
        <button class="btn btn-warning mb-3">
            Deshabilitar empleado
        </button>
    @else
        <button class="btn btn-success mb-3">
            Habilitar empleado
        </button>
    @endif
</form>
    <div class="form-card-body">
        <form action="{{ url('/empleados/'.$empleados->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            @include('Empleados.form', ['modo' => 'Modificar'])
        </form>
    </div>
</div>

@endsection