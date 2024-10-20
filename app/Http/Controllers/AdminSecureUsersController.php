<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobTitle;
use Illuminate\Http\Request;
use App\Models\GeneralManagements;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateControlUserRequest;

class AdminSecureUsersController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $users = User::where('name', 'LIKE', "%{$request->search}%")
            ->orderBy('id', 'asc')
            ->paginate(10);
            if($users->count() == 0){
                return redirect()->route('admin-secure');
            }
            return view('secure.index', compact('users'));
        }
        $users = User::orderBy('id', 
        'asc')->paginate(10);
        return view('secure.index', compact('users'));
    }
    public function create(){
        return view('secure.create', ['job_titles' => JobTitle::all(),'general_managements' => GeneralManagements::all()]);
    }
    public function edit(Request $request){
        $user = User::findOrFail($request->id);
        return view('secure.edit', ['user' => $user, 'jobTitles' => JobTitle::all(),'generalManagements' => GeneralManagements::all()]);
    }
    public function update(User $user,UpdateControlUserRequest $request){
        $user->update($request->all());
        return redirect()->route('admin-secure.edit',$user);
    }
    public function store(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'job_title_id' => $request->job_title,
            'phone' => $request->phone,
            'ip_address' => $request->ip(),
            'coordination_management' => $request->coordination_management,
            'last_connection' => now(),
            'general_management_id' => $request->general_management,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->passwordRecords()->create(['password' => Hash::make($request->password)]);

        return redirect(route('admin-secure'));
    }
    public function destroy(User $user){
        $user->update(['is_deleted' => true]);
        return redirect()->route('admin-secure');
    }
    public function resetPassword(User $user){
        $user->update(['password' => Hash::make('cantv1234')]);
        return back();
    }

}
