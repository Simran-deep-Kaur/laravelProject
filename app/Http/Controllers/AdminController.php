<?php

namespace App\Http\Controllers;

use App\Actions\Admins\CreateUser;
use App\Actions\Admins\DeleteUser;
use App\Actions\Admins\UpdateUser;
use App\Http\Resources\UserResource;
use App\Http\Requests\ValidationAdmin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');

        $data = User::query()
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->whereNotIn('users.id', [$request->user()->id])
            ->select('users.*', DB::raw('GROUP_CONCAT(roles.name) as role'))
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'desc')
            ->get();

        if ($roleFilter && $roleFilter !== "all") {
            $data = $data->filter(function ($user) use ($roleFilter) {
                return $user->roles->contains('id', $roleFilter);
            });
        }

        return view('admins.index', [
            'data' => UserResource::collection($data)->resolve(),
            'roles' => Role::all(),
        ]);
    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [Rule::unique('users')->ignore($request->Id, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first('email')]);
        }

        return response()->json(['status' => 'success']);
    }

    public function store(ValidationAdmin $request, CreateUser $createUser)
    {
        $user = $createUser->create($request->validated());

        return redirect(route('admins'))->with('success','Admin created successfully.');
    }

    public function show(User $user)
    {
        $user = User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.id', $user->id)
            ->select('users.*', DB::raw('GROUP_CONCAT(roles.name) as role'))
            ->groupBy('users.id')
            ->first();

        // dd((new UserResource($user))->resolve());

        return view('admins.show', ['user' => (new UserResource($user))->resolve()]);
    }


    public function edit(User $user)
    {
        $user = User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.id', $user->id)
            ->select('users.*', DB::raw('GROUP_CONCAT(roles.name) as role'))
            ->groupBy('users.id')
            ->first();

        return view('admins.edit', ['user' => new UserResource($user)]);
    }

    public function update(ValidationAdmin $request, User $user, UpdateUser $updateUser)
    {
        $user = $updateUser->update($user, $request->all());

        return redirect()->route('admins')->with('success', 'Admin updated successfully');
    }

    public function destroy(User $user, DeleteUser $deleteUser)
    {
        $user = $deleteUser->handle($user);

        return redirect()->route('admins')->with('success', 'Admin deleted successfully');
    }
}
