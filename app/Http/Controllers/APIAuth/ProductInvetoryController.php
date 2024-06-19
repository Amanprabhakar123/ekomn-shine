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
    
        public function index()
        {
            $perPage = 10;
            $paginator = ProductInventory::paginate($perPage);
            
    
            $users = $paginator->getCollection();
            $resource = new Collection($users, new UserTransformer());
    
            // Add pagination to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
    
            $data = $this->fractal->createData($resource)->toArray();
            //  die(json_encode($data));
            return response()->json($data);
            // return (['data' => $data, 'paginator' => $paginator]);
        }

}
