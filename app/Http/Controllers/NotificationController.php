<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use App\Models\UserRole;
use App\Notifications\AdminNotificaton;
use App\Services\UserPolicyService;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendAdminNotification(Product $product)
    {
        $role = UserRole::find(UserRole::USER_ADMIN);

        Notification::send($role, new AdminNotificaton([
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
            'send_at' => now(),
        ]));

        $product->update(['status_id' => Status::where('name', '=', 'На рассмотрении')->first()->id]);

        return redirect()->route('profile')->with(['success' => 'Заявка отправлена']);
    }

    public function deleteNotify($id)
    {
        if(UserPolicyService::isAdminUser()) return UserPolicyService::toProfile();

        $notification = auth()->user()->role->notifications->where('id', $id);

        $notification->markAsRead();

        return back()->with(['success' => 'Заявка прочитана']);
    }
}
