<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();
        return view('roles.index', compact(['roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #dd($request);
        $attributes = $this->validateRequest();
        $role = Role::create($attributes);
        return redirect()->route('roles.edit', $role->id)->with('status', 'Rol creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $rolePermissions = $role->permissions;

        #if(auth()->user()->hasRole('superadmin')){
            $permissions = Permission::all();
        #}else{
        #    $permissions = Permission::all()->whereNotIn('slug', ['permissions.create', 'permissions.show', 'permissions.edit', 'permissions.destroy'])->all();
        #}

        return view('roles.edit', compact(['role','permissions','rolePermissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $attributes = $this->validateRequest();
        $role->update($attributes);
        //Asignar Permisos
        $role->syncPermissions($request->get('permission'));
        return redirect()->route('roles.edit', $role->id)->with('status', 'Rol actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Rol eliminado!');
    }

    protected function validateRequest()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'special' => 'nullable'
        ]);
        return $attributes;
    }
}
