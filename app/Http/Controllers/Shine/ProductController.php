<?php

namespace App\Http\Controllers\Shine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyShine;
use App\Models\ShineProductReview;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function showAssignedProducts()
    {
        $assignedProducts = ShineProduct::where('assigner_id', auth()->id())->get();
        return view('dashboard.buyer.my_shine', compact('assignedProducts'));
    }

    public function showOrderDetailsForm($id)
    {
        $shineProduct = ShineProduct::findOrFail($id);
        return view('dashboard.assigner.submit_order_details', compact('shineProduct'));
    }

    public function submitOrderDetails(Request $request)
    {
        $request->validate([
            'shine_product_id' => 'required|exists:shine_products,id',
            'order_number' => 'required|string|max:255',
            'order_invoice' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'acknowledgment' => 'required|accepted',
            'review_screenshots.*' => 'required|file|mimes:jpg,jpeg,png',
            'comments' => 'required|string'
        ]);

        $shineProduct = ShineProduct::find($request->shine_product_id);

        // Save order invoice
        if ($request->hasFile('order_invoice')) {
            $orderInvoicePath = $request->file('order_invoice')->store('order_invoices');
        }

        // Save review screenshots
        $screenshotsPaths = [];
        if ($request->hasFile('review_screenshots')) {
            foreach ($request->file('review_screenshots') as $screenshot) {
                $screenshotsPaths[] = $screenshot->store('review_screenshots');
            }
        }

        // Create review
        $review = ShineProductReview::create([
            'shine_product_id' => $shineProduct->id,
            'assigner_id' => auth()->id(),
            'feedback_title' => $shineProduct->feedback_title,
            'feedback_comment' => $request->comments,
            'review_rating' => $shineProduct->review_rating,
            'order_invoice' => $orderInvoicePath,
            'order_number' => $request->order_number,
            'screenshots' => json_encode($screenshotsPaths),
        ]);

        // Update Shine Product status
        $shineProduct->update(['status' => 'completed']);

        return redirect()->route('assigner.products')->with('success', 'Shine job completed successfully.');
    }
}