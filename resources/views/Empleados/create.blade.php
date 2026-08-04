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
        background: #6366f1; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 16px; flex-shrink: 0;
    }
    .form-head-title { font-size: 16px; font-weight: 700; color: #0f172a; }
    .form-head-sub   { font-size: 12px; color: #94a3b8; margin-top: 2px; }

    .form-card-body { padding: 24px; }

    .form-card-foot {
        padding: 16px 24px; border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex; justify-content: space-between; align-items: center;
    }

    .btn-back {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; text-decoration: none;
        background: white; border: 1px solid #e2e8f0; color: #64748b;
        transition: all .15s;
    }
    .btn-back:hover { border-color: #cbd5e1; color: #374151; }
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
        <div class="form-head-icon"><i class="fas fa-user-plus"></i></div>
        <div>
            <div class="form-head-title">Nuevo Empleado</div>
            <div class="form-head-sub">Completa el formulario para registrar un empleado</div>
        </div>
    </div>

    <div class="form-card-body">
        <form action="{{ url('/empleados') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('Empleados.form', ['modo' => 'Crear'])
        </form>
    </div>
</div>

@endsection