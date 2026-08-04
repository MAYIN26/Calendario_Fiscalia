<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    public function index()
    {
        $datos['empleados'] = Empleados::paginate(5);
        return view('Empleados.index', $datos);
    }


    public function create()
    {
        return view('Empleados.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nombre'          => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidoPaterno' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidoMaterno' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'Correo'          => 'required|email|unique:empleados,Correo',
            'curp'            => [
                'required',
                'size:18',
                'unique:empleados,curp',
                'regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]$/'
            ],
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nombre.required'          => 'El nombre es obligatorio',
            'nombre.min'               => 'El nombre debe tener mínimo 3 caracteres',
            'nombre.max'               => 'El nombre no puede tener más de 50 caracteres',
            'nombre.regex'             => 'El nombre solo puede contener letras',

            'apellidoPaterno.required' => 'El apellido paterno es obligatorio',
            'apellidoPaterno.min'      => 'El apellido paterno debe tener mínimo 3 caracteres',
            'apellidoPaterno.max'      => 'El apellido paterno no puede tener más de 50 caracteres',
            'apellidoPaterno.regex'    => 'Solo puede contener letras',

            'apellidoMaterno.required' => 'El apellido materno es obligatorio',
            'apellidoMaterno.min'      => 'El apellido materno debe tener mínimo 3 caracteres',
            'apellidoMaterno.max'      => 'El apellido materno no puede tener más de 50 caracteres',
            'apellidoMaterno.regex'    => 'Solo puede contener letras',

            'Correo.required'          => 'El correo es obligatorio',
            'Correo.email'             => 'Ingresa un correo válido',
            'Correo.unique'            => 'Este correo ya está registrado',

            'curp.required'            => 'La CURP es obligatoria',
            'curp.size'                => 'La CURP debe tener exactamente 18 caracteres',
            'curp.unique'              => 'Esta CURP ya está registrada',
            'curp.regex'               => 'La CURP no tiene un formato válido',

            'foto.image'               => 'El archivo debe ser una imagen válida',
            'foto.mimes'               => 'Solo se permiten archivos jpg, jpeg, png o webp',
            'foto.max'                 => 'La imagen no puede pesar más de 2MB',
        ]);

        $datosEmpleado = $request->except('_token');
        $datosEmpleado['curp'] = strtoupper($request->curp);

        if ($request->hasFile('foto')) {
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        Empleados::insert($datosEmpleado);

        return redirect('empleados')->with('mensaje', 'Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empleados = Empleados::findOrFail($id);
        return view('Empleados.edit', compact('empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empleados = Empleados::findOrFail($id);

        $request->validate([
            'nombre'          => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidoPaterno' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidoMaterno' => 'required|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'Correo'          => 'required|email|unique:empleados,Correo,' . $id,
            'curp'            => [
                'required',
                'size:18',
                'unique:empleados,curp,' . $id,
                'regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]$/'
            ],
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nombre.required'          => 'El nombre es obligatorio',
            'nombre.min'               => 'El nombre debe tener mínimo 3 caracteres',
            'nombre.max'               => 'El nombre no puede tener más de 50 caracteres',
            'nombre.regex'             => 'El nombre solo puede contener letras',

            'apellidoPaterno.required' => 'El apellido paterno es obligatorio',
            'apellidoPaterno.min'      => 'El apellido paterno debe tener mínimo 3 caracteres',
            'apellidoPaterno.max'      => 'El apellido paterno no puede tener más de 50 caracteres',
            'apellidoPaterno.regex'    => 'Solo puede contener letras',

            'apellidoMaterno.required' => 'El apellido materno es obligatorio',
            'apellidoMaterno.min'      => 'El apellido materno debe tener mínimo 3 caracteres',
            'apellidoMaterno.max'      => 'El apellido materno no puede tener más de 50 caracteres',
            'apellidoMaterno.regex'    => 'Solo puede contener letras',

            'Correo.required'          => 'El correo es obligatorio',
            'Correo.email'             => 'Ingresa un correo válido',
            'Correo.unique'            => 'Este correo ya está registrado',

            'curp.required'            => 'La CURP es obligatoria',
            'curp.size'                => 'La CURP debe tener exactamente 18 caracteres',
            'curp.unique'              => 'Esta CURP ya está registrada',
            'curp.regex'               => 'La CURP no tiene un formato válido',

            'foto.image'               => 'El archivo debe ser una imagen válida',
            'foto.mimes'               => 'Solo se permiten archivos jpg, jpeg, png o webp',
            'foto.max'                 => 'La imagen no puede pesar más de 2MB',
        ]);

        $datosEmpleado = $request->except(['_token', '_method']);
        $datosEmpleado['curp'] = strtoupper($request->curp);

        if ($request->hasFile('foto')) {
            if ($empleados->foto && Storage::disk('public')->exists($empleados->foto)) {
                Storage::disk('public')->delete($empleados->foto);
            }

            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        Empleados::where('id', '=', $id)->update($datosEmpleado);

        return redirect('empleados')->with('mensaje', 'Empleado modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleados = Empleados::findOrFail($id);

        $this->eliminarFotoEmpleado($empleados);

        $empleados->delete();

        return redirect('empleados')->with('mensaje', 'Empleado eliminado con exito');
    }

    private function eliminarFotoEmpleado(Empleados $empleado)
    {
        if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
            Storage::disk('public')->delete($empleado->foto);
        }
    }

    public function toggle($id)
{
    $empleado = Empleados::findOrFail($id);

    $empleado->activo = !$empleado->activo;
    $empleado->save();

    return redirect()->back()->with('mensaje', 'Estado actualizado');
}
}