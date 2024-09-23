<?php

namespace App\Http\Controllers\Shine;

use App\Models\User;
use App\Models\Import;
use App\Models\ShineProduct;
use App\Models\MyShine;
use App\Models\ShineProductReview;
use App\Models\QueueName;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AssignShineJob;

class MyShineController extends Controller
{
    public function my_shine()
    {
        $user = auth()->user();
        if ($user->hasRole(User::ROLE_BUYER)) {
            $shineProducts = MyShine::where('user_id', $user->id)->get();
            // return view('dashboard.buyer.my_shine', compact('shineProducts'));
            $assignedProducts = ShineProduct::with('review')->where('assigner_id', $user->id)->get();
            return view('dashboard.buyer.my_shine', compact('shineProducts', 'assignedProducts'));
        }
    }

    public function assignProductsToAssigner(Request $request, $assignerId)
    {
        $productIds = $request->input('product_ids');

        // Assign products to the assigner
        ShineProduct::whereIn('id', $productIds)->update(['assigner_id' => $assignerId]);

        // Dispatch job
        foreach ($productIds as $productId) {
            $product = ShineProduct::find($productId);
            \Log::info('Dispatching AssignShineJob', ['product_id' => $productId]);
            dispatch(new AssignShineJob($product));
        }

        return response()->json(['message' => 'Products assigned successfully']);
    }


    public function new_shine()
    {
        if (auth()->user()->hasRole(User::ROLE_BUYER)) {
            return view('dashboard.buyer.new_shine');
        }
    }

    public function complete_shine($id)
    {
        $user = auth()->user();
        if ($user->hasRole(User::ROLE_BUYER)) {
            $product = ShineProduct::findOrFail($id);
            $productReview = ShineProductReview::where('shine_product_id', $id)->firstOrFail();
            return view('dashboard.buyer.complete_shine', compact('product', 'productReview'));
        }
    }

    public function shine_status($id)
    {
        $user = auth()->user();
        if ($user->hasRole(User::ROLE_BUYER)) {
            $product = ShineProduct::findOrFail($id);
            $productReview = ShineProductReview::where('shine_product_id', $id)->firstOrFail();
            return view('dashboard.buyer.shine_status', compact('product', 'productReview'));
        }
    }

    public function addShine(Request $request) {
        $shineProducts = [];
        $shineProductReviews = [];
        $userId = auth()->id(); // Get the currently authenticated user's ID
    
        $batchIds = $request->input('batchid');
        $requestNos = $request->input('request_no');
        $productNames = $request->input('product_name');
        $platforms = $request->input('platform');
        $productLinks = $request->input('product_link');
        $productIds = $request->input('product_id');
        $sellerNames = $request->input('seller_name');
        $searchTerms = $request->input('search_term');
        $amounts = $request->input('amount');
        $feedbackTitles = $request->input('feedback_title');
        $reviewRatings = $request->input('review_rating');
        $feedbackComments = $request->input('feedback_comment');
        $statuses = $request->input('status', array_fill(0, count($requestNos), 1));
    
        foreach ($requestNos as $index => $requestNo) {
            $shineProducts[] = [
                'user_id' => $userId,
                'batch_id' => $batchIds[$index],
                'request_no' => $requestNos[$index],
                'name' => $productNames[$index],
                'platform' => $platforms[$index],
                'url' => $productLinks[$index],
                'product_id' => $productIds[$index],
                'seller_name' => $sellerNames[$index],
                'search_term' => $searchTerms[$index],
                'amount' => $amounts[$index],
                'feedback_title' => $feedbackTitles[$index],
                'review_rating' => $reviewRatings[$index],
                'feedback_comment' => $feedbackComments[$index],
                'status' => $statuses[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::beginTransaction();
        try {
            // Insert shine products
            ShineProduct::insert($shineProducts);
    
            // Retrieve the IDs of the inserted shine products
            $insertedShineProducts = ShineProduct::where('user_id', $userId)
                                                 ->whereIn('request_no', $requestNos)
                                                 ->get();
    
            $shineProductReviews = [];
            foreach ($insertedShineProducts as $shineProduct) {
                $shineProductReviews[] = [
                    'shine_product_id' => $shineProduct->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert reviews
            ShineProductReview::insert($shineProductReviews);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'data' => $shineProducts
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error adding shine products and reviews: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function update_product_review1(Request $request, $productId)
    {
        $request->validate([
            'order_number' => 'required|string',
            'order_invoice' => 'required|file|mimes:pdf,jpg,png'
        ]);

        $productReview = ShineProductReview::where('shine_product_id', $productId)->firstOrFail();
        $productReview->order_number = $request->order_number;

        if ($request->hasFile('order_invoice')) {
            $file = $request->file('order_invoice');
            $filePath = $file->store('shine_order_invoices', 'public');
            $productReview->order_invoice = $filePath;
        }

        $productReview->save();
    
        // Update the status of the corresponding ShineProduct
        $shineProduct = ShineProduct::findOrFail($productId);
        $shineProduct->status = 3;
        $shineProduct->save();

        return response()->json(['success' => 'Product review updated successfully.']);
    }

    public function download_shine_order_invoice($id)
    {
        $productReview = ShineProductReview::where('shine_product_id', $id)->firstOrFail();

        if ($productReview && $productReview->order_invoice) {
            $filePath = storage_path('app/public/' . $productReview->order_invoice);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Invoice not available.');
        }
    }

    public function download_shine_screenshots($id)
    {
        $productReview = ShineProductReview::where('shine_product_id', $id)->firstOrFail();

        if ($productReview && $productReview->screenshots) {
            $filePath = storage_path('app/public/' . $productReview->screenshots);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Invoice not available.');
        }
    }

    public function update_product_review2(Request $request, $productId)
    {
        $request->validate([
            'requestor_confirmation' => 'required|integer',
            'requestor_comment' => 'required|string'
        ]);

        $productReview = ShineProductReview::where('shine_product_id', $productId)->firstOrFail();
        $productReview->requestor_confirmation = $request->requestor_confirmation;
        $productReview->requestor_comment = $request->requestor_comment;

        $productReview->save();
    
        // Update the status of the corresponding ShineProduct
        $shineProduct = ShineProduct::findOrFail($productId);
        $shineProduct->status = 4;
        $shineProduct->save();

        return response()->json(['success' => 'Product review updated successfully.']);
    }

    public function update_product_review3(Request $request, $productId)
    {
        $request->validate([
            'feedback_comment' => 'required|string',
            'screenshots' => 'required|file|mimes:pdf,jpg,png'
        ]);

        $productReview = ShineProductReview::where('shine_product_id', $productId)->firstOrFail();
        $productReview->feedback_comment = $request->feedback_comment;

        if ($request->hasFile('screenshots')) {
            $file = $request->file('screenshots');
            $filePath = $file->store('shine_order_screenshots', 'public');
            $productReview->screenshots = $filePath;
        }

        $productReview->save();
    
        // Update the status of the corresponding ShineProduct
        $shineProduct = ShineProduct::findOrFail($productId);
        $shineProduct->status = 5;
        $shineProduct->save();

        return response()->json(['success' => 'Product review updated successfully.']);
    }

    public function update_product_review4(Request $request, $productId)
    {
        $request->validate([
            'requestor_confirmation_complition' => 'required|integer',
        ]);

        $productReview = ShineProductReview::where('shine_product_id', $productId)->firstOrFail();
        $productReview->requestor_confirmation_complition = $request->requestor_confirmation_complition;

        $productReview->save();
    
        // Update the status of the corresponding ShineProduct
        $shineProduct = ShineProduct::findOrFail($productId);
        $shineProduct->status = 6;
        $shineProduct->save();

        return response()->json(['success' => 'Product review updated successfully.']);
    }
}
