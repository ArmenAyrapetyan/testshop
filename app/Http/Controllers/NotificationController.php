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
    public function sendAdminNotification($id, Product $product)
    {
        $user = User::where('id', '=', $id)->first();
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
}
