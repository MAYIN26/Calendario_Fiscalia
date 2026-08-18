<style>
    /* ── FORM FIELDS ─────────────────────────────────── */
    .f-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .f-label .req {
        color: #ef4444;
        margin-left: 2px;
    }

    .f-input {
        width: 100%;
        padding: 10px 13px;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        color: #0f172a;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        background: #fafafa;
    }

    .f-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: white;
    }

    .f-input.is-invalid {
        border-color: #ef4444;
    }

    .f-error {
        font-size: 12px;
        color: #dc2626;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 5px;
    }

    .f-group {
        margin-bottom: 18px;
    }

    /* ── FOTO UPLOAD ─────────────────────────────────── */
    .foto-preview {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .foto-preview img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
    }

    .foto-lbl {
        font-size: 11px;
        color: #94a3b8;
    }

    .foto-name {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin-top: 2px;
    }

    .upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        position: relative;
    }

    .upload-zone:hover {
        border-color: #6366f1;
        background: rgba(99,102,241,.03);
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon {
        font-size: 22px;
        color: #94a3b8;
        margin-bottom: 6px;
    }

    .upload-text {
        font-size: 13px;
        color: #64748b;
    }

    .upload-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* ── DIVIDER ─────────────────────────────────────── */
    .f-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 22px 0;
    }

    .f-divider hr {
        flex: 1;
        border: none;
        border-top: 1px solid #f1f5f9;
    }

    .f-divider span {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: .8px;
    }

    /* ── SUBMIT BTN ──────────────────────────────────── */
    .btn-submit {
        width: 100%;
        padding: 11px;
        border-radius: 9px;
        border: none;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: white;
        letter-spacing: .3px;
        transition: opacity .15s, transform .1s;
    }

    .btn-submit:hover {
        opacity: .88;
        transform: translateY(-1px);
    }

    .btn-submit.crear {
        background: linear-gradient(135deg, #6366f1, #a855f7);
    }

    .btn-submit.editar {
        background: linear-gradient(135deg, #0ea5e9, #6366f1);
    }

    /* GRID 2 columnas */
    .f-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 18px;
    }

    @media (max-width: 520px) {
        .f-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="f-grid">

    {{-- NOMBRE --}}
    <div class="f-group">
        <label class="f-label">
            Nombre <span class="req">*</span>
        </label>

        <input
            type="text"
            name="nombre"
            id="nombre"
            class="f-input {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
            value="{{ old('nombre', $empleados->nombre ?? '') }}"
            placeholder="Ej: Mario Andree"
        >

        @error('nombre')
            <div class="f-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- CORREO --}}
    <div class="f-group">
        <label class="f-label">
            Correo
            <span style="font-size:11px; color:#94a3b8; font-weight:400;">
                (Opcional)
            </span>
        </label>

        <input
            type="email"
            name="Correo"
            id="correo"
            class="f-input {{ $errors->has('Correo') ? 'is-invalid' : '' }}"
            value="{{ old('Correo', $empleados->Correo ?? '') }}"
            placeholder="ejemplo@correo.com"
        >

        @error('Correo')
            <div class="f-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- ALIAS --}}
    <div class="f-group">
        <label class="f-label">
            Alias
            <span style="font-size:11px; color:#94a3b8; font-weight:400;">
                (Opcional)
            </span>
        </label>

        <input
            type="text"
            name="alias"
            id="alias"
            class="f-input {{ $errors->has('alias') ? 'is-invalid' : '' }}"
            value="{{ old('alias', $empleados->alias ?? '') }}"
            placeholder="Ej: Machin 01"
            maxlength="100"
        >

        @error('alias')
            <div class="f-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- APELLIDO PATERNO --}}
    <div class="f-group">
        <label class="f-label">
            Apellido Paterno <span class="req">*</span>
        </label>

        <input
            type="text"
            name="apellidoPaterno"
            id="apellidoPaterno"
            class="f-input {{ $errors->has('apellidoPaterno') ? 'is-invalid' : '' }}"
            value="{{ old('apellidoPaterno', $empleados->apellidoPaterno ?? '') }}"
            placeholder="Ej: Carmona"
        >

        @error('apellidoPaterno')
            <div class="f-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- APELLIDO MATERNO --}}
    <div class="f-group">
        <label class="f-label">
            Apellido Materno
        </label>

        <input
            type="text"
            name="apellidoMaterno"
            id="apellidoMaterno"
            class="f-input {{ $errors->has('apellidoMaterno') ? 'is-invalid' : '' }}"
            value="{{ old('apellidoMaterno', $empleados->apellidoMaterno ?? '') }}"
            placeholder="Ej: Aguayo"
        >

        @error('apellidoMaterno')
            <div class="f-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>

</div>


{{-- CURP --}}
<div class="f-group">
    <label class="f-label">
        CURP <span class="req">*</span>
    </label>

    <input
        type="text"
        name="curp"
        id="curp"
        class="f-input {{ $errors->has('curp') ? 'is-invalid' : '' }}"
        value="{{ old('curp', $empleados->curp ?? '') }}"
        maxlength="18"
        style="text-transform: uppercase;"
        placeholder="Ejemplo: CAAM060826HMNRGRA8"
    >

    @error('curp')
        <div class="f-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $message }}
        </div>
    @enderror
</div>


{{-- FOTO --}}
<div class="f-divider">
    <hr>
    <span>Fotografía</span>
    <hr>
</div>

<div class="f-group">

    <label class="f-label">
        Foto del Empleado
        <span style="font-size:11px; color:#94a3b8; font-weight:400;">
            (Opcional)
        </span>
    </label>

    @if(!empty($empleados->foto))
        <div class="foto-preview">

            <img
                src="{{ Storage::url($empleados->foto) }}"
                alt="Foto actual"
            >

            <div>
                <div class="foto-lbl">
                    Foto actual
                </div>

                <div class="foto-name">
                    {{ basename($empleados->foto) }}
                </div>
            </div>

        </div>
    @endif


    <div class="upload-zone" id="uploadZone">

        <input
            type="file"
            name="foto"
            id="foto"
            accept="image/*"
            onchange="previewFoto(this)"
        >

        <div id="uploadContent">

            <div class="upload-icon">
                <i class="fas fa-camera"></i>
            </div>

            <div class="upload-text">
                {{ !empty($empleados->foto)
                    ? 'Haz clic para cambiar la foto'
                    : 'Haz clic para subir una foto'
                }}
            </div>

            <div class="upload-hint">
                PNG, JPG, WEBP — máx. 2 MB
            </div>

        </div>

    </div>

    @error('foto')
        <div class="f-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $message }}
        </div>
    @enderror

</div>


<div class="f-divider">
    <hr>
</div>


{{-- SUBMIT --}}
<button
    type="submit"
    class="btn-submit {{ $modo == 'Crear' ? 'crear' : 'editar' }}"
>

    @if($modo == 'Crear')

        <i class="fas fa-plus me-2"></i>
        Agregar Empleado

    @else

        <i class="fas fa-save me-2"></i>
        Guardar Cambios

    @endif

</button>


<script>
function previewFoto(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = e => {

            document.getElementById('uploadContent').innerHTML = `
                <img
                    src="${e.target.result}"
                    style="
                        max-height:100px;
                        border-radius:10px;
                        object-fit:cover;
                        margin-bottom:8px;
                    "
                >

                <div
                    class="upload-text"
                    style="color:#10b981"
                >
                    <i class="fas fa-check-circle"></i>
                    ${input.files[0].name}
                </div>
            `;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>