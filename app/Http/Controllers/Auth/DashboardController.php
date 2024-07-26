<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\BuyerInventory;
use App\Models\CanHandle;
use App\Models\Category;
use App\Models\CompanyAddressDetail;
use App\Models\CompanyDetail;
use App\Models\Order;
use App\Models\Pincode;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use App\Models\SalesChannel;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.profile', get_defined_vars());
        }
        abort('403', 'Unauthorized action.');
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
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
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {

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
     * @param  $buyer_id
     * but not used in the code
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
            ->get();

        $city = DB::table('cities')
            ->where('country_id', 101)
            ->where('state_id', $request->id)
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
    public function viewOrder()
    {
        return view('dashboard.common.view-order');
    }
}
