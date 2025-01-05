<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    public function logCreate($model, $data)
    {
        $this->logActivity($model, $data, 'create');
    }

    public function logUpdate($model, $data)
    {
        $this->logActivity($model, $data, 'update');
    }

    public function logDelete($model, $data)
    {
        $this->logActivity($model, $data, 'delete');
    }

    public function logStockIn($product, $quantity)
    {
        $action = 'stock-in';
        $data = [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'quantity' => $quantity,
        ];
        $this->logActivity('product', $data, $action);
    }

    // New method for logging stock-out activity
    public function logStockOut($product, $quantity)
    {
        $action = 'stock-out';
        $data = [
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'quantity' => $quantity,
        ];
        $this->logActivity('product', $data, $action);
    }

    private function logActivity($model, $data, $action)
    {
        $user = Auth::user();
        $userName = $user ? $user->firstname : 'System';

        ActivityLog::create([
            'model' => $model,
            'data' => json_encode($data, JSON_PRETTY_PRINT),
            'action' => $action,
            'user_name' => $userName,
        ]);

        Log::info("{$action} record in {$model} by {$userName}", $data);
    }
}
