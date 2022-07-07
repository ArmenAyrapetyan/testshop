<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\AdminNotificaton;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendAdminNotification(Product $product)
    {
        $user = auth()->user();
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

        return redirect()->route('profile')->with([
            'success' => 'Заявка отправлена',
        ]);
    }

    public function deleteNotify($id)
    {
        if (auth()->user()->cannot('isAdmin', User::class)){
            return back()->withErrors([
                'error' => 'Доступ запрещен'
            ]);
        }

        $notification = auth()->user()->role->notifications->where('id', $id);

        $notification->markAsRead();

        return back()->with([
            'success' => 'Заявка прочитана'
        ]);
    }
}
