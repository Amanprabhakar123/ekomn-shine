<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ProductInventory;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductInvetoryController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Retrieve a paginated list of product inventories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            $userId = auth()->user()->id;
            $perPage = $request->input('per_page', 10);
            $paginator = ProductInventory::select(['product_inventories.*', 'product_variations.sku', 'product_variations.stock', 'product_variations.price_after_tax', 'product_variations.price_before_tax', 'product_variations.status', 'product_variations.dropship_rate', 'product_variations.potential_mrp', 'product_variations.tier_rate', 'product_variations.tier_shipping_rate'])
            ->join('product_variations', 'product_variations.product_id', '=', 'product_inventories.id')
            ->where('product_inventories.user_id', $userId)
            ->get();

            $products = $paginator->getCollection();
            $resource = new Collection($products, new UserTransformer());

            // Add pagination to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

            $data = $this->fractal->createData($resource)->toArray();

            return response()->json($data);
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            return view('dashboard.buyer.index');
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.index');
        }
        abort('403', 'Unauthorized action.');
        
    }
}
