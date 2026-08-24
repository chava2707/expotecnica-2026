<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Role;
use App\Models\Persona;
use App\Models\Correo;
use App\Models\Telefono;
use App\Mail\CuentaCreadaMail;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['persona', 'rol', 'persona.telefonos', 'persona.correos']);
        
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function ($q) use ($busqueda) {
                $q->where('name', 'like', "%{$busqueda}%")
                  ->orWhere('email', 'like', "%{$busqueda}%")
                  ->orWhere('Nombre_usuario', 'like', "%{$busqueda}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('IDrol', $request->input('rol'));
        }

        if ($request->filled('estado')) {
            $estado = $request->input('estado');
            if ($estado === 'activo') {
                $query->where('Activo', true);
            } elseif ($estado === 'inactivo') {
                $query->where('Activo', false);
            }
        }

        $usuarios = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        $totalUsuarios = User::count();
        $juecesActivos = User::whereHas('rol', function ($q) {
            $q->where('Nombre_rol', 'Juez');
        })->where('Activo', true)->count();
        $totalAdmins = User::whereHas('rol', function ($q) {
            $q->where('Nombre_rol', 'Administrador');
        })->count();

        return view('admin.usuarios.index', compact(
            'usuarios', 'roles', 'totalUsuarios', 'juecesActivos', 'totalAdmins'
        ));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'cedula'            => ['required', 'integer', function ($attribute, $value, $fail) {
                if (User::where('IDPersona', $value)->exists()) {
                    $fail('Esta cédula ya tiene un usuario registrado.');
                }
            }],
            'nombre'            => 'required|string|max:255',
            'apellido_1'        => 'required|string|max:255',
            'apellido_2'        => 'nullable|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email',
            'telefono'          => 'required|string|max:255',
            'nombre_usuario'    => 'nullable|string|max:255|unique:users,Nombre_usuario',
            'id_rol'            => 'required|exists:roles,ID_Roles',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('_modal', 'crear');
        }

        $request->replace($validator->validated());

        DB::transaction(function () use ($request) {
            $persona = Persona::find($request->cedula);

            if ($persona) {
                $persona->update([
                    'Nombre'     => $request->nombre,
                    'Apellido_1' => $request->apellido_1,
                    'Apellido_2' => $request->apellido_2,
                    'Estado'     => true,
                ]);
            } else {
                $persona = Persona::create([
                    'ID_Cedula'         => $request->cedula,
                    'Nombre'            => $request->nombre,
                    'Apellido_1'        => $request->apellido_1,
                    'Apellido_2'        => $request->apellido_2,
                    'Estado'            => true,
                ]);
            }

            User::create([
                'IDPersona'         => $persona->ID_Cedula,
                'IDrol'             => $request->id_rol,
                'name'              => $request->nombre . ' ' . $request->apellido_1,
                'Nombre_usuario'    => $request->nombre_usuario,
                'email'             => $request->email,
                'password'          => Hash::make($request->cedula),
                'Activo'            => true,
            ]);

            Correo::updateOrCreate(
                ['IDPersona' => $persona->ID_Cedula, 'Es_Principal' => true],
                ['Correo'    => $request->email, 'Activo' => true]
            );

            Telefono::updateOrCreate(
                ['IDPersona' => $persona->ID_Cedula, 'Es_Principal' => true],
                ['Numero_Telefono' => $request->telefono, 'Activo' => true]
            );
        });

        $nombreCompleto = $request->nombre . ' ' . $request->apellido_1;
        Mail::to($request->email)->send(new CuentaCreadaMail(
            $nombreCompleto,
            $request->email,
            $request->cedula,
            $request->nombre_usuario ?? '',
        ));

        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado correctamente. Se ha enviado un correo con las credenciales de acceso.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:users,email,' . $id,
            'Nombre_usuario'   => 'nullable|string|max:255|unique:users,Nombre_usuario,' . $id,
            'IDrol'            => 'required|exists:roles,ID_Roles',
            'Activo'           => 'required|boolean',
        ]);

        $usuario = User::findOrFail($id);
        $emailOriginal = $usuario->email;

        $usuario->update([
            'name'             => $request->name,
            'email'            => $request->email,
            'Nombre_usuario'   => $request->Nombre_usuario,
            'IDrol'            => $request->IDrol,
            'Activo'           => $request->boolean('Activo'),
        ]);

        if ($emailOriginal !== $request->email && $usuario->IDPersona) {
            Correo::where('IDPersona', $usuario->IDPersona)
                ->where('Es_Principal', true)
                ->update(['Correo' => $request->email]);
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function reenviarCredenciales(string $id)
    {
        $usuario = User::with('persona')->findOrFail($id);

        Mail::to($usuario->email)->send(new CuentaCreadaMail(
            $usuario->name,
            $usuario->email,
            (string) $usuario->IDPersona,
            $usuario->Nombre_usuario ?? '',
        ));

        return redirect()->route('admin.usuarios')
            ->with('success', 'Correo de credenciales reenviado a ' . $usuario->email . '.');
    }

    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        DB::transaction(function () use ($usuario) {
            $idPersona = $usuario->IDPersona;

            $usuario->delete();

            if ($idPersona) {
                Correo::where('IDPersona', $idPersona)->delete();
                Telefono::where('IDPersona', $idPersona)->delete();
                Persona::where('ID_Cedula', $idPersona)->delete();
            }
        });

        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente.');
    }
}
