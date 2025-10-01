<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::all();
        // $users = User::orderBy('created_at', 'desc')->paginate(8);
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {

            $users = User::whereHasRole(['user', 'admin', 'super_admin'])->where(function ($q) use ($request) {
                    return $q->when($request->search, function ($query) use ($request) {
                        return $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            })->orderBy('created_at', 'desc')->paginate(8);

        } else {

            $users = User::whereHasRole(['user', 'admin'])->where(function ($q) use ($request) {
                    return $q->when($request->search, function ($query) use ($request) {
                        return $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            })->orderBy('created_at', 'desc')->paginate(8);

        }

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // @dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|' . Rule::in(['user', 'admin', 'super_admin']),
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newUser = User::create($validatedData);

        $newUser->addRole($request->role);

        $newUser->syncPermissions($validatedData['permissions'] ?? []);

        if ($request->hasFile('image')) {
            $this->verifyAndStoreImage($request, 'image', 'users', 'upload_image', $newUser->id, User::class);
        }

        Alert::toast(__('site.added_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $rolesList = Role::all();
        // $roles = $user->roles()->pluck('name');
        // $permissions = $user->allPermissions()->pluck('name')->toArray();
        // return view('dashboard.users.edit', compact(['user', 'rolesList', 'roles', 'permissions']));
        return view('dashboard.users.edit', compact(['user', 'rolesList']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:30',
            'email' => 'required|email|' . Rule::unique('users')->ignore($user->id),
            'password' => 'nullable|min:6',
            'role' => 'required|' . Rule::in(['user', 'admin', 'super_admin']),
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $requestData = $request->except(['password', '_token', 'role', 'permissions']);

        if ($request->filled('password')) {
            $requestData['password'] = Hash::make($request->password);
        }

        $user->update($requestData);

        $user->syncRoles([$request->input('role')]);

        $user->syncPermissions($request->input('permissions', []));

        if ($request->hasFile('image')) {
            // Delete old image
            if ($user->image) {
                $old_image = $user->image->file;
                $this->Delete_attachment('upload_image', 'users/'.$old_image, $user->id);
            }
            // Store new image
            $this->verifyAndStoreImage($request, 'image', 'users', 'upload_image', $user->id, User::class);
        }

        Alert::toast(__('site.updated_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image && $user->image->file) {
            $old_image = $user->image->file;
            $this->Delete_attachment('upload_image', 'users/'.$old_image, $user->id);
        }
        $user->removeRoles();
        $user->permissions()->detach();
        $user->delete();
        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.users.index');
    }
}
