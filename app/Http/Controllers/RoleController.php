<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:rol-listar|rol-crear|rol-editar|rol-eliminar', ['only' => ['index', 'store']]);
        $this->middleware('permission:rol-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:rol-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rol-eliminar', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Roles/Index', [
            'roles' => Role::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::pluck('name')->all();
        return Inertia::render('Roles/Create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        
        $this->validate($request, [
            'name' => 'required|unique:roles,name,NULL,id',
            'permisos' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name')
        ]);
        $role->syncPermissions($request->input('permisos'));

        return Redirect::route('roles.index')->with('message', 'Registro almacenado.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::pluck('name')->all();
        $rolePermissions = $role->permissions()->pluck('name')->all();

        return Inertia::render('Roles/Edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id . ',id,id_tenant,' . session('tenant_id'),
            'permisos' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permisos'));
        Cache::forget('user_permissions_' . auth()->id());
        Cache::forget('user_roles_' . auth()->id());
        //Alert::info('Success', 'Rol has been updated !');
        return Redirect::route('roles.edit', $id)->with('message', 'Registro actualizado');
    }


    public function destroy(Request $request, $id)
    {

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Recurso eliminado exitosamente');
    }
}