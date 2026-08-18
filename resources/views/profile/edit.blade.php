@extends('layouts.app')

@section('content')

<div style="max-width:900px; margin:30px auto;">

    <div style="
        background:white;
        border:1px solid #e2e8f0;
        border-radius:18px;
        padding:28px;
        margin-bottom:24px;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
    ">
        <h2 style="font-size:24px; font-weight:800; margin-bottom:8px;">
            MI PERFIL
        </h2>

        <p style="color:#64748b; margin-bottom:24px;">
            Modifica nombre y correo electrónico.
        </p>

        @include('profile.partials.update-profile-information-form')
    </div>


    <div style="
        background:white;
        border:1px solid #e2e8f0;
        border-radius:18px;
        padding:28px;
        margin-bottom:24px;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
    ">
        <h2 style="font-size:24px; font-weight:800; margin-bottom:8px;">
            Cambiar contraseña
        </h2>

        <p style="color:#64748b; margin-bottom:24px;">
            Actualiza la contraseña de tu cuenta.
        </p>

        @include('profile.partials.update-password-form')
    </div>

</div>

@endsection