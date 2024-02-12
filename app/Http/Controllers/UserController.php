<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', 
        [
            'users' => User::query()
                ->when(RequestFacade::input('search'),function($query, $search) {
                    $query->where('name','like','%'.$search.'%')
                    ->OrWhere('email','like','%'.$search.'%');
                })->when(RequestFacade::input('estado_users'), function ($query, $estado) {
                    $query->where('estado', $estado);
                })->with('roles')->paginate(5)
                ->withQueryString(),
                'filters' => RequestFacade::only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return to_route('users.index');
    }

    public function edit(Request $request,$id_user)
    {
        $usuario = User::findOrFail($id_user);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $usuario->roles->pluck('name', 'name')->all();
        return Inertia::render('Users/Edit', compact('usuario','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        // Validar los datos de entrada
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique('users')->ignore($user)],
            'estado' => ['required'],
            'roles_user' => 'required'
        ]);
        // Actualizar el modelo de usuario con los datos validados
        $user->fill($data)->save();
        $user->syncRoles($request->input('roles_user'));
        return Redirect::route('users.edit',$user->id);
    }
}
