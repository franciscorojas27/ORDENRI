<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobTitle;
use Illuminate\Http\Request;
use App\Models\Resolution_Area;
use App\Models\GeneralManagements;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateControlUserRequest;

class AdminSecureUsersController extends Controller
{
    /**
     *  Muestra la lista de usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $users = User::with('jobTitle', 'generalManagement')
                ->where('name', 'LIKE', "%{$request->search}%")
                ->orderBy('id', 'asc')
                ->paginate(10);
            if ($users->isEmpty()) {
                return redirect()->route('admin-secure.index');
            }
            return view('secure.index', compact('users'));
        }
        $users = User::with(['jobTitle', 'generalManagement'])->orderBy(
            'id',
            'asc'
        )->paginate(10);
        return view('secure.index', compact('users'));
    }
    /**
     * Muestra el formulario para crear un nuevo usuario.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('secure.create', ['job_titles' => JobTitle::all(), 'resolution_areas' => Resolution_Area::all(), 'general_managements' => GeneralManagements::all()]);
    }
    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param  \App\Models\User  $user  El usuario que se va a editar.
     * @return \Illuminate\Contracts\View\View  La vista del formulario de edición del usuario.
     */
    public function edit(User $user)
    {
        return view('secure.edit', ['user' => $user, 'jobTitles' => JobTitle::all(), 'generalManagements' => GeneralManagements::all(), 'resolutionAreas' => Resolution_Area::all()]);
    }
    /**
     * Actualiza un usuario existente.
     * 
     * @param  \App\Models\User  $user  El usuario que se va a editar.
     * @param  \App\Http\Requests\UpdateControlUserRequest  $request  El request que contiene los campos a actualizar del usuario.
     * @return \Illuminate\Http\RedirectResponse  Redirige hacia la ruta de edición del usuario.
     */
    public function update(User $user, UpdateControlUserRequest $request)
    {
        $user->update($request->all());
        return redirect()->route('admin-secure.edit', $user);
    }
    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request  El request que contiene los datos del nuevo usuario.
     * @return \Illuminate\Http\RedirectResponse  Redirige hacia la lista de usuarios.
     */
    public function store(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'job_title_id' => $request->job_title ?? config('custom.defaults_job_title', 1),
            'resolution_area_id' => $request->resolution_area,
            'phone' => $request->phone,
            'ip_address' => $request->ip(),
            'coordination_management' => $request->coordination_management,
            'last_connection' => now(),
            'general_management_id' => $request->general_management,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->passwordRecords()->create(['password' => Hash::make($request->password)]);

        return redirect(route('admin-secure.index'));
    }
    /**
     * Marca un usuario como eliminado.
     *
     * Este método actualiza el campo 'is_deleted' del usuario a true, 
     * marcándolo como eliminado en el sistema sin eliminarlo de la base de datos.
     * Luego, redirige a la lista de usuarios.
     *
     * @param \App\Models\User $user El usuario que se va a marcar como eliminado.
     * @return \Illuminate\Http\RedirectResponse Redirige a la ruta de la lista de usuarios.
     */
    public function destroy(User $user)
    {
        $user->update(['is_deleted' => true]);
        return redirect()->route('admin-secure.index');
    }
    /**
     * Restablece la contraseña de un usuario a su valor predeterminado.
     * 
     * @param  \App\Models\User  $user  El usuario cuya contraseña se va a restablecer.
     * @return \Illuminate\Http\RedirectResponse  Redirige hacia la ruta de edición del usuario.
     */
    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make(config('custom.defaults_passwords', 'cantv1234'))]);
        return back();
    }

}
