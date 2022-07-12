<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Status;
use App\Models\UserRole;
use App\Notifications\AdminNotificaton;
use App\Services\ProductPolicyService;
use App\Services\UserPolicyService;
use Illuminate\Support\Facades\Notification;

class NotificationResponseController extends Controller
{
    public function sendAdminNotification($id)
    {
        $product = Product::find($id);

        if (ProductPolicyService::canUpdate($product)) return ProductPolicyService::toProfile(true);

        $role = UserRole::where('name', '=', 'Администратор')->first();

        Notification::send($role, new AdminNotificaton([
            'user_id' => auth('sanctum')->id(),
            'product_id' => $product->id,
            'send_at' => now(),
        ]));

        $product->update(['status_id' => Status::STATUS_CONSIDERATION]);

        return ['message' => 'Заявка отправлена'];
    }

    public function deleteNotify($id)
    {
        if(UserPolicyService::isAdminUser()) return UserPolicyService::toProfile(true);

        $notification = auth('sanctum')->user()->role->notifications->find($id);

        $notification->markAsRead();

        return ['message' => 'Заявка прочитана'];
    }
}
