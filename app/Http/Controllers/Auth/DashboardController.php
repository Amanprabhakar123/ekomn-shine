<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Pincode;
use App\Models\Category;
use App\Models\CanHandle;
use League\Fractal\Manager;
use App\Models\BusinessType;
use App\Models\OrderAddress;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Events\ExceptionEvent;
use App\Models\BuyerInventory;
use App\Models\CourierDetails;
use App\Models\ProductVariation;
use App\Services\CompanyService;
use Faker\Provider\ar_EG\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;
use App\Models\ProductVariationMedia;
use League\Fractal\Resource\Collection;
use App\Transformers\UserListTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class DashboardController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display the dashboard based on the user's role.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            return view('dashboard.supplier.index');
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            $distance = new Pincode();
            $distance = $distance->calculateDistance('122016', '226018');

            return view('dashboard.buyer.index', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) {
            return view('dashboard.admin.index');
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function editProfile()
    {
        $product_category = Category::where([
            'root_parent_id' => 0,
            'is_active' => true,
            'depth' => 0,
        ])->get();
        $selected_product_category = auth()->user()->companyDetails->productCategory->pluck('product_category_id')->toArray();
        $alternate_business_contact = json_decode(auth()->user()->companyDetails->alternate_business_contact);
        $languages = ['English', 'Hindi', 'Bengali', 'Telugu', 'Marathi', 'Tamil', 'Gujarati', 'Malayalam', 'Kannada'];
        $read_selected_languages = json_decode(auth()->user()->companyDetails->language_i_can_read, true) ?? [];
        $understand_selected_languages = json_decode(auth()->user()->companyDetails->language_i_can_understand, true) ?? [];
        $billing_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();

        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            $shipping_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
            $business_type = BusinessType::where('type', BusinessType::TYPE_SUPPLIER)->get();
            $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();
            $can_handle = CanHandle::all();
            $selected_can_handle = auth()->user()->companyDetails->canHandle->pluck('can_handles_id')->toArray();

            return view('dashboard.supplier.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            $delivery_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();

            $business_type = BusinessType::where('type', BusinessType::TYPE_BUYER)->get();
            $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();
            $sales = SalesChannel::where('is_active', true)->get();
            $selected_sales = auth()->user()->companyDetails->salesChannel->pluck('sales_channel_id')->toArray();

            return view('dashboard.buyer.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) {
            return view('dashboard.admin.profile', get_defined_vars());
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * View profile page.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewPage(Request $request, $id)
    {
        $companyDetails = CompanyDetail::where('id', salt_decrypt($id))->with('address')->first();
        $shipping_address = $companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
        $billing_address = $companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
        $delivery_address = $companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
        $business_type = BusinessType::where('type', BusinessType::TYPE_SUPPLIER)->get();
        $business_types = BusinessType::where('type', BusinessType::TYPE_BUYER)->get();
        $sales = SalesChannel::where('is_active', true)->get();
        $selected_sales = $companyDetails->salesChannel->pluck('sales_channel_id')->toArray();
        $selected_business_type = $companyDetails->businessType->pluck('business_type_id')->toArray();
        $selected_product_category = $companyDetails->productCategory->pluck('product_category_id')->toArray();
        $alternate_business_contact = json_decode($companyDetails->alternate_business_contact);
        $selected_can_handle = $companyDetails->canHandle->pluck('can_handles_id')->toArray();
        $languages = ['English', 'Hindi', 'Bengali', 'Telugu', 'Marathi', 'Tamil', 'Gujarati', 'Malayalam', 'Kannada'];
        $read_selected_languages = json_decode($companyDetails->language_i_can_read, true) ?? [];
        $understand_selected_languages = json_decode($companyDetails->language_i_can_understand, true) ?? [];
        $role = $companyDetails->user->getRoleNames()->first();
        $product_category = Category::where([
            'root_parent_id' => 0,
            'is_active' => true,
            'depth' => 0,
        ])->get();
        $can_handle = CanHandle::all();

        return view('dashboard.admin.view-profile', get_defined_vars());
    }

    /**
     * Update the pan and gst verifeid or not.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePanGstVerified(Request $request)
    {
        try {
            $companyDetail = CompanyDetail::find(salt_decrypt($request->id));
            if ($request->has('pan_verified')) {
                $companyDetail->pan_verified = $request->pan_verified;
            }
            if ($request->has('gst_verified')) {
                $companyDetail->gst_verified = $request->gst_verified;
            }
            $companyDetail->save();
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.userUpdated'),
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $e->getMessage(),
                ],
            ], __('statusCode.statusCode422'));
        }
    }

    /**
     * Update the user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCompanyDetails(Request $request)
    {
        try {
            $response = (new CompanyService())->updateCompanyDetails($request);

            return successResponse(null, $response['data']);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Display the user's inventory.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myInventory()
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
            return view('dashboard.supplier.inventory');
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            $selectData = SalesChannel::all();
            if ($selectData->isNotEmpty()) {
                $selectData = $selectData->map(function ($item) {
                    return [
                        'id' => base64_encode($item->id),
                        'name' => $item->name,
                    ];
                })->toArray();
            }

            //
            $inventory_count = BuyerInventory::join('product_variations', 'buyer_inventories.product_id', '=', 'product_variations.id')
                ->where('buyer_inventories.buyer_id', auth()->user()->id)
                ->whereNot('product_variations.status', ProductVariation::STATUS_DRAFT)
                ->groupBy('product_variations.product_id')
                ->select('product_variations.product_id')
                ->get()->count();

            return view('dashboard.buyer.inventory', compact('selectData', 'inventory_count'));
        } elseif ((auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
            return view('dashboard.admin.inventory');
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Display the form to add a new product to the inventory.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function addInventory()
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            return view('dashboard.common.add_inventory');
        } elseif ((auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            return view('dashboard.common.add_inventory');
        }
        abort('403', 'Unauthorized action.');
        
    }

    /**
     * Display the form to bulk upload products to the inventory.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function bulkUpload()
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            return view('dashboard.common.bulk_upload');
        } elseif ((auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN))  && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            return view('dashboard.common.bulk_upload');
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Display the list of bulk uploads.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function bulkUploadList()
    {
        if (auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            return view('dashboard.common.bulk_upload_list');
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Edit the user's orders.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function editInventory(Request $request, $variation_id)
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
            $variation_id = salt_decrypt($variation_id);
            $userId = auth()->user()->id;
            // DB::enableQueryLog();
            $variations = ProductVariation::where('id', $variation_id)
                ->whereHas('product', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->with([
                    'media',
                    'product',
                    'product.category',
                    'product.subCategory',
                    'product.company',
                    'product.keywords',
                    'product.features',
                ]) // Eager load the product and category relationships
                ->first();
            $image = $variations->media->where('media_type', ProductVariationMedia::MEDIA_TYPE_IMAGE);
            $video = $variations->media->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO)->first();

            // dd(DB::getQueryLog());
            return view('dashboard.common.edit_inventory', compact('variations', 'image', 'video'));
        } elseif ((auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {

            $variation_id = salt_decrypt($variation_id);
            // DB::enableQueryLog();
            $variations = ProductVariation::where('id', $variation_id)
                ->with([
                    'media',
                    'product',
                    'product.category',
                    'product.subCategory',
                    'product.company',
                    'product.keywords',
                    'product.features',
                ]) // Eager load the product and category relationships
                ->first();
            $image = $variations->media->where('media_type', ProductVariationMedia::MEDIA_TYPE_IMAGE);
            $video = $variations->media->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO)->first();

            return view('dashboard.common.edit_inventory', compact('variations', 'image', 'video'));
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Place your order.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request)
    {
        if (auth()->user()->hasRole(User::ROLE_BUYER)) {
            $delivery_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
            $billing_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
            $business_type = BusinessType::where('type', BusinessType::TYPE_BUYER)->get();
            $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();
            $sales = SalesChannel::where('is_active', true)->get();
            $selected_sales = auth()->user()->companyDetails->salesChannel->pluck('sales_channel_id')->toArray();

            return view('dashboard.common.create_order', get_defined_vars());
        }
    }

    /**
     * Get the buyer details.
     *
     * @param  $buyer_id
     *                   but not used in the code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuyerId($buyer_id)
    {
        $companyDetail = CompanyDetail::where('company_serial_id', $buyer_id)->first();
        if ($companyDetail) {
            $delivery_address = $companyDetail->address()->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
            $billing_address = $companyDetail->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
            if ($companyDetail->user->hasRole(User::ROLE_BUYER)) {
                $data = [
                    'first_name' => $companyDetail->first_name,
                    'last_name' => $companyDetail->last_name,
                    'email' => $companyDetail->email,
                    'mobile' => $companyDetail->mobile_no,
                    'delevery_address' => $delivery_address->address_line1,
                    'city' => $delivery_address->city,
                    'state' => $delivery_address->state,
                    'pincode' => $delivery_address->pincode,
                    'biiling_address' => $billing_address->address_line1,
                    'billing_city' => $billing_address->city,
                    'billing_state' => $billing_address->state,
                    'billing_pincode' => $billing_address->pincode,
                    // 'billing_address' => $billing_address,
                ];

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => [__('auth.buyerFound')],
                    'data' => $data,
                ]], __('statusCode.statusCode200'));
            } else {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => [__('auth.buyerNotFound')],
                ]], __('statusCode.statusCode200'));
            }
        } else {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => [__('auth.buyerNotFound')],
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Get the list of states and cities.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStateCityList(Request $request)
    {
        $state = DB::table('states')
            ->where('country_id', 101)
            ->orderBy('name', 'asc')
            ->get();

        $city = DB::table('cities')
            ->where('country_id', 101)
            ->where('state_id', $request->id)
            ->orderBy('name', 'asc')
            ->get();

        if ($state->isNotEmpty()) {
            $statsList = [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'state' => $state->toArray(),
                'city' => $city->toArray(),
            ];

            return response()->json(['data' => $statsList], __('statusCode.statusCode200'));
        } else {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => 'State not found',
                ],
            ], __('statusCode.statusCode200'));
        }
    }

    /**
     * Display the user's orders.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myOrders()
    {
        return view('dashboard.common.my_orders');
    }

    /**
     * Display the view order.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewOrder(Request $request, $id)
    {
        $myOrderId = salt_decrypt($id);
        $orderData = OrderAddress::where('order_id', $myOrderId)->first();
        $orderUpdate = Order::where('id', $myOrderId)->first();
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            if ($orderUpdate->status == Order::STATUS_PENDING) {
                $orderUpdate->status = Order::STATUS_IN_PROGRESS;
                $orderUpdate->save();
            }
        }
        $courier_detatils = null;
        $shipment_date = null;
        $delivery_date = null;
        $shipment = $orderUpdate->shipments()->first();
        if ($shipment) {
            if ($shipment->shipmentAwb()->first()) {
                $courier_detatils = $shipment->shipmentAwb()->first();
                $shipment_date = $shipment->shipment_date;
                $delivery_date = $shipment->delivery_date;
            }
        }

        $billing_address = OrderAddress::where('order_id', $myOrderId)->Billing()->first();
        $delivery_address = OrderAddress::where('order_id', $myOrderId)->Delivery()->first();
        $pickup_address = OrderAddress::where('order_id', $myOrderId)->Pickup()->first();
        $courierList = CourierDetails::orderBy('id', 'desc')->get();
        return view('dashboard.common.view-order', get_defined_vars());
    }

    /**
     * Display the user's orders.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function orderTracking()
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_ORDER_TRACKING)) {
            return abort('403', 'Unauthorized action.');
        }
        return view('dashboard.admin.order_tracking');
    }

    /**
     * User list view for admin.
     * 
     * @return \Illuminate\Contracts\View\View
     */

    public function userList()
    {
        // Check if the user has the permission to cancel an order
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_USER_LIST)) {
            return abort('403', 'Unauthorized action.');
        }
        return view('dashboard.admin.user-list');
    }

    /**
     * User list get data for admin.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserList(Request $request)
    {
        try {
            // Check if the user has the permission to cancel an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_USER_LIST)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $perPage = $request->get('perPage', 10);
            $searchTerm = $request->input('query', null);
            $sort_by_status = $request->input('sort_by_status'); // Default sort by 'all'
            $sort_by_gst = $request->input('sort_by_gst',  null); // Default sort by 'all'
            $sort_by_pan = $request->input('sort_by_pan', null); // Default sort by 'all'

            $users = User::with('companyDetails')->when($searchTerm, function ($query, $searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('companyDetails', function ($query) use ($searchTerm) {
                        $query->where('business_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('company_serial_id', 'like', '%' . $searchTerm . '%') // Search by company serial id
                            ->orWhere('mobile_no', 'like', '%' . $searchTerm . '%');
                    });
            });
            
            if (! is_null($sort_by_gst)) {
                $users = $users->whereHas('companyDetails', function ($query) use ($sort_by_gst) {
                    $query->where('gst_verified', $sort_by_gst);
                });
            }

            if (! is_null($sort_by_pan)) {
                $users = $users->whereHas('companyDetails', function ($query) use ($sort_by_pan) {
                    $query->where('pan_verified', $sort_by_pan);
                });
            } 
            if ($sort_by_status == ROLE_BUYER || $sort_by_status == ROLE_SUPPLIER) {
                $users = $users->role([$sort_by_status]);
            } else {
                $users = $users->role([ROLE_BUYER, ROLE_SUPPLIER]);
            }
            $users = $users->paginate($perPage);

            // Transform the paginated results using Fractal
            $resource = new Collection($users, new UserListTransformer);

            // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($users));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
        }
    }
    /**
     * Update the user's status.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserStatus(Request $request)
    {
        try {
            // Check if the user has the permission to cancel an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_USER_LIST)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
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

    /**
     * This subscription view 
     * @param Request $request
     * @return void
     */
    public function subscriptionList()
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_SUBSCRIPTION_LIST)) {
            abort('403');
        }
        return view('dashboard.common.subscription_list');
    }

    /**
     * This function is used to get the list of all subscriptions.
     * @param Request $request
     * @return void
     */
    public function subscriptionView(Request $request)
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_SUBSCRIPTION_VIEW)) {
            abort('403');
        }
        return view('dashboard.common.subscription_view');
    }

    /**
     * admin plans view
     * @param Request $request
     * @return void
     * 
     * public function plans()
     */ 

     public function plansView()
     {
       
        return view('dashboard.admin.admin_plan');
     }

     /**
      * This function is used to get the list of all plans.
      * @param Request $request
      * @return void
      */
        public function plansList(Request $request)
        {
            // if (! auth()->user()->hasPermissionTo(User::PERMISSION_PLAN_LIST)) {
            //     abort('403');
            // }

            try{
                $plans = Plan::where('status', Plan::STATUS_ACTIVE)->get()->toArray();
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.plansList'),
                        'data' => $plans,
                    ],
                ], __('statusCode.statusCode200'));
            }
            catch (\Exception $e) {
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
