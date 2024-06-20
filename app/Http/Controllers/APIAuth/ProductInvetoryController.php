<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\ProductInventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;
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
    public function index()
    {
        $perPage = 10;
        $paginator = ProductInventory::paginate($perPage);

        $products = $paginator->getCollection();
        $resource = new Collection($products, new UserTransformer());

        // Add pagination to the resource
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $data = $this->fractal->createData($resource)->toArray();

        return response()->json($data);
    }
}
