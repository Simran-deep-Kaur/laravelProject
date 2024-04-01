<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationAdmin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->hasRole('super-admin')) {
            $data = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();
        } else {
            abort(403, 'You are not authorized to view this page.');
        }
        return view('admins.index', ['data' => UserResource::collection($data)->resolve()]);
    }


    public function store(ValidationAdmin $request)
    {
        $profileImage = $request->file('profile_image');

        $profileImageName = null;

        if (!empty($profileImage)) {
            $profileImageName = $profileImage->getClientOriginalName();
            $profileImage->store('public/uploads');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
            'age'=>$request->age,
            'gender'=>$request->gender,
            'profile_image'=>$profileImageName,
        ]);
        $user->save();

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user->roles()->attach($adminRole->id);
        } else {
            return redirect()->back()->with('error', 'Admin role not found.');
        }

        return redirect(route('admins'));
    }

    public function show(User $user)
    {
        return view('admins.show', ['user' => new UserResource($user)]);
    }
    

    public function edit(User $user)
    {
        return view('admins.edit', ['user' => new UserResource($user)]);
    }

    public function update(Request $request, User $user)
    {
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $profileImageName = $profileImage->getClientOriginalName();
            $profileImage->store('public/uploads');
            $user->profile_image = $profileImageName;
        } else {
            $profileImageName = $user->profile_image;
        }
        $data = $request->all();
        $data['profile_image'] = $profileImageName;
        $user->update($data);
        
        return redirect()->route('admins')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admins')->with('success', 'Admin deleted successfully');
    }
}
