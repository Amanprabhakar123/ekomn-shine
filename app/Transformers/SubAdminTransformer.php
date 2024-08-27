<?php

namespace App\Transformers;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class SubAdminTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
       try{
        $data = [
            'id' => salt_encrypt($user->id),
            // 'link' => route('view.page', salt_encrypt($user->companyDetails->id)),
            'name' => $user->name,
            'email' => $user->email,
            // 'role' => ucfirst($user->getRoleNames()->first()),
            'status' => $user->isactive,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
        // dd($data);
        return $data;
         }catch(\Exception $e){
            Log::error('Error transforming User list: ' . $e->getMessage());
            return [];
         }
    }

    
}