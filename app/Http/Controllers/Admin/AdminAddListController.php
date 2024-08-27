<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AdminAddListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admin.admin_list');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function addAdmin()
    {
        $permission = Permission::all();
        $permissionsArray = $permission->toArray();

        // dd($permissionsArray);
        $permissions = [];

        foreach ($permissionsArray as $key =>  $item) {
            $permissions[$item['name']] = str_replace('_', ' ', ucfirst($item['name']));
        }

        // dd($permissions);
        return view('dashboard.admin.create_admin', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function subAdminStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'permissions' => 'required|string',
                'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode400'));
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role to user
            $user->assignRole(User::ROLE_SUB_ADMIN);

            $permission =  explode(',', $request->permissions);
            // Assign permission to user
            $user->givePermissionTo($permission);

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.registerSuccess'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode500'));
        }
    }

    /**
     * Display the admin list.
     */
    public function adminList(){
        $users = User::role(User::ROLE_SUB_ADMIN)->get();
         
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
            'data' => $users
        ]], __('statusCode.statusCode200'));
    }
}
