<?php

namespace App\Transformers;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class UserListTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
       try{
        $data = [
            'id' => salt_encrypt($user->id),
            'link' => route('view.page', salt_encrypt($user->companyDetails->id)),
            'name' => $user->name,
            'business_name' => $user->companyDetails->business_name,
            'email' => $user->email,
            'mobile_no' => $user->companyDetails->mobile_no,
            'role' => ucfirst($user->getRoleNames()->first()),
            'pan_verified' => $user->companyDetails->pan_verified,
            'gst_verified' => $user->companyDetails->gst_verified,
            'company_serial_id' => $user->companyDetails->company_serial_id,
            'status' => $user->isactive,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
        return $data;
         }catch(\Exception $e){
            Log::error('Error transforming User list: ' . $e->getMessage());
            return [];
         }
    }
}