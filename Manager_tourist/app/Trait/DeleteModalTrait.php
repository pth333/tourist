<?php

namespace App\Trait;

use Illuminate\Support\Facades\Log;

trait DeleteModalTrait
{
    public function deleteModalTrait($id, $modal)
    {
        try {
            $modal->find($id)->delete();
            return response()->json([
                'code' => 200
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
