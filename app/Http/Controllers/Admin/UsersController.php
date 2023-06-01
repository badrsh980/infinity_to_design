<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return Inertia::render('Admin/User/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sts = [
            'pending' => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];

        return Inertia::render('Admin/User/create', compact('sts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => "required|in:pending,active,inactive",
            'name' => "required|string|max:50",
            'username' => "required|string|max:50|unique:users,username",
            'email' => "required|string|max:50|unique:users,email",
            'password' => "required|confirmed",
            'specialization' => "required|string|max:30",
            'thumbnail' => "required|image|mimes:png,jpeg,jpg,gif|max:2048",
            'description' => "required|string|max:500"
        ]);

        if ($request->thumbnail) {
            try {
                $image = null;
                if ($request->thumbnail instanceof UploadedFile) {
                    $thumbnail = $request->thumbnail;

                    try {
                        $name = unique_str() . $thumbnail->getClientOriginalName();

                        $thumbnail->storeAs('/public/images/users/', $name);

                        $image = $name;
                    } catch (\Throwable $th) {
                        return false;
                    }
                }

                $user = User::create([
                    'status' => $request->status,
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'specialization' => $request->specialization,
                    'thumbnail' => $image,
                    'description' => $request->description,
                    'token' => unique_str()
                ]);

                $user->assignRole('Member');

                return to_route('admin.users.index')->with('message', __('User has been created.'));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $sts = [
            'pending' => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];

        return Inertia::render('Admin/User/show', compact('sts', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = User::where('id', $id)->firstOrFail();

        $sts = [
            'pending' => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];

        return Inertia::render('Admin/User/edit', compact('sts', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $image = $user->thumbnail;
        $password = $user->password;

        $request->validate([
            'status' => "required|in:pending,active,inactive",
            'name' => "required|string|max:50",
            'username' => ["required", "string", "max:50", Rule::unique('users')->ignore($user)],
            'email' => ["required", "string", "max:50", Rule::unique('users')->ignore($user)],
            'specialization' => "required|string|max:30",
            'description' => "required|string|max:500"
        ]);

        if ($request->password) {
            $request->validate([
                'password' => "required|confirmed",
            ]);

            $password = Hash::make($request->password);
        }

        if ($request->thumbnail) {
            $request->validate([
                'thumbnail' => 'required|mimes:jpg,jpeg,png,gif|max:2048'
            ]);

            try {
                if ($request->thumbnail instanceof UploadedFile) {
                    $thumbnail = $request->thumbnail;

                    try {
                        $name = unique_str() . $thumbnail->getClientOriginalName();

                        $thumbnail->storeAs('/public/images/users/', $name);

                        $image = $name;
                    } catch (\Throwable $th) {
                        return false;
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        $user->update([
            'status' => $request->status,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'specialization' => $request->specialization,
            'thumbnail' => $image,
            'description' => $request->description
        ]);

        return to_route('admin.users.edit', compact('user'))->with('message', __('User has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $user->delete();

        return to_route('admin.users.index')->with('message', __('User has been deleted.'));
    }
}
