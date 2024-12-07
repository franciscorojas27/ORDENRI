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

/**
 * @OA\Info(
 *     title="API de Autenticacion de Usuarios",
 *     version="1.0.0",
 *     description="Esta es una API para autenticar a los usuarios en el sistema.",
 *     @OA\Contact(
 *         name="Ing. Luis A. Albornoz C.",
 *         email="luis.albornoz@cantv.com.ve",
 *         url="https://github.com/luisalbornoz"
 *     ),
 *     @OA\License(
 *         name="GNU General Public License v2.0",
 *         url="https://opensource.org/licenses/GPL-2.0"
 *     )
 * )
 */
class AdminSecureUsersController extends Controller
{/**
 * @OA\Get(
 *     path="/api/test",
 *     tags={"Test"},
 *     summary="Test Route",
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     )
 * )
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
    public function create()
    {
        return view('secure.create', ['job_titles' => JobTitle::all(), 'resolution_areas' => Resolution_Area::all(), 'general_managements' => GeneralManagements::all()]);
    }
    public function edit(User $user)
    {
        return view('secure.edit', ['user' => $user, 'jobTitles' => JobTitle::all(), 'generalManagements' => GeneralManagements::all(), 'resolutionAreas' => Resolution_Area::all()]);
    }
    public function update(User $user, UpdateControlUserRequest $request)
    {
        $user->update($request->all());
        return redirect()->route('admin-secure.edit', $user);
    }
    public function store(RegisterRequest $request)
    {
        $user = User::create([
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
        ]);
        $user->passwordRecords()->create(['password' => Hash::make($request->password)]);

        return redirect(route('admin-secure.index'));
    }
    public function destroy(User $user)
    {
        $user->update(['is_deleted' => true]);
        return redirect()->route('admin-secure.index');
    }
    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make(config('auth.defaults.passwords','cantv1234'))]);
        return back();
    }

}
