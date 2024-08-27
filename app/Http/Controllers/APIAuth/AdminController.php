<?php

namespace App\Http\Controllers\ApiAuth;

use App\Models\User;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Resource\Collection;
use Spatie\Permission\Models\Permission;
use App\Transformers\SubAdminTransformer;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;




class AdminController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }
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
        $permissionsArray = User::SUB_ADMIN_PERMISSION_LIST;

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
    public function adminList(Request $request){
       
        try {
            $perPage = $request->get('per_page', 10);

            $searchTerm = $request->input('query', null);
            // $sort_by_status = $request->input('sort_by_status'); // Default sort by 'all'
            $users = User::role(User::ROLE_SUB_ADMIN);

            // $users =  $users = User::role(User::ROLE_SUB_ADMIN)->get()->when($searchTerm, function ($query, $searchTerm) {
            //     $query->where('name', 'like', '%' . $searchTerm . '%')
            //         ->orWhere('email', 'like', '%' . $searchTerm . '%')
            //         ->orWhereHas('companyDetails', function ($query) use ($searchTerm) {
            //             $query->where('business_name', 'like', '%' . $searchTerm . '%')
            //             ->orWhere('company_serial_id', 'like', '%' . $searchTerm . '%') // Search by company serial id
            //                 ->orWhere('mobile_no', 'like', '%' . $searchTerm . '%');
            //         });
            // });

            $users = $users->paginate($perPage);
            

            // Transform the paginated results using Fractal
            $resource = new Collection($users, new SubAdminTransformer);

            // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($users));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();
            // dd($data);
            // Return the JSON response with paginated data
            return response()->json($data);
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];

            dd($exceptionDetails, $e->getMessage());
            event(new ExceptionEvent($exceptionDetails));
        }
    }

    public function updateUserActive(Request $request)
    {
        try {
            $user = User::find(salt_decrypt($request->id));
            $user->isactive = $request->status;
            $user->save();
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.userUpdated'),
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $e->getMessage(),
                ],
            ], __('statusCode.statusCode422'));
        }
    }
}