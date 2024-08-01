<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\OrderPaymentTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class OrderPaymentController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function orderPayment(Request $request)
    {
        return view('dashboard.common.payment');
    }

    /**
     * Get the payment information.
     *
     * @param Request $request
     * 
     * Illuminate\Http\JsonResponse
     */
    
    public function getPaymentInfo(Request $request){
        try {
            $perPage = $request->input('per_page', 10);

            $data = Order::paginate($perPage);

            $resource = new Collection($data, new OrderPaymentTransformer());
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
            $transformedData = $this->fractal->createData($resource)->toArray();

            // dd($transformedData);
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => 'Payment information fetched successfully',
                    'data' => $transformedData['data'],
                    'meta' => $transformedData['meta']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => 'Failed to fetch payment information',
                ]
            ]);
        }

    }
}
