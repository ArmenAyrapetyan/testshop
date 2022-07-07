<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\AdminNotificaton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationResponseController extends Controller
{
    public function sendAdminNotification($id)
    {
        $product = Product::find($id);
        $user = auth('sanctum')->user();
        $role = UserRole::where('name', '=', 'Администратор')->first();

        $notify = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'send_at' => now(),
        ];

        Notification::send($role, new AdminNotificaton($notify));

        $product->update([
            'status_id' => Status::where('name', '=', 'На рассмотрении')->first()->id,
        ]);

        return [
            'message' => 'Заявка отправлена',
        ];
    }

    public function deleteNotify($id)
    {
        if (auth('sanctum')->user()->cannot('isAdmin', User::class)){
            return [
              'message' => 'Доступ запрещен'
            ];
        }

        $notification = auth('sanctum')->user()->role->notifications->where('id', $id);

        $notification->markAsRead();

        return [
            'message' => 'Заявка прочитана'
        ];
    }
}
