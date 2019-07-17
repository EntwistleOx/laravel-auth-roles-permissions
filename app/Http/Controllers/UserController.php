<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.edit', $user->id)->with('status', 'Usuario creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles;
        return view('users.edit', compact(['user', 'roles', 'userRoles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);

        $user->update($attributes);

        //Asignar Roles
        $user->syncRoles($request->get('role'));
        return redirect()->route('users.edit', $user->id)->with('status', 'Usuario actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Usuario eliminado!');
    }

    protected function validateRequest()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);
        return $attributes;
    }

    public function updatePassword(Request $request, User $user)
    {
        $attributes = $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($attributes['password'])
        ]);
        return redirect()->route('users.edit', $user->id)->with('status', 'Password actualizada!');
    }
}
