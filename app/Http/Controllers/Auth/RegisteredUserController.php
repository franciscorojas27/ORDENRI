<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Resolution_Area;
use App\Models\GeneralManagements;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'resolution_areas' => Resolution_Area::all(),'general_managements' => GeneralManagements::all()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'resolution_area_id' => $request->resolution_area,
            'job_title_id' => $request->job_title ?? config('custom.defaults_resolution_area',1),
            'phone' => $request->phone,
            'ip_address' => $request->ip(),
            'password_may_expire' => $request->password_may_expire ?? true,
            'coordination_management' => $request->coordination_management,
            'last_connection' => now(),
            'general_management_id' => $request->general_management,
            'email' => $request->email,
            'password_may_expire_at' => now()->addDays(30),
            'password' => Hash::make($request->password),
        ]);
        $user->passwordRecords()->create(['password' => Hash::make($request->password)]);
        event(new Registered($user));
        
        Auth::login($user);

        return redirect(route('order.index', absolute: false));
    }
}
