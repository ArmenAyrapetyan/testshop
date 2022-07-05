<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Image;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function create($id)
    {
        return view('crud.review.create', compact('id'));
    }

    public function store(ReviewRequest $request)
    {
        $review = Review::create([
            'text' => $request['text'],
            'user_id' => $request->user()->id,
            'product_id' => $request['product_id'],
        ]);

        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach ($files as $file) {
                $upload_folder = "public/images/" . date('Y-m-d');
                $name = $file->getClientOriginalName();
                $name = strstr($name, '.', true);
                $extension = $file->getClientOriginalExtension();
                $name = $name . date('Y-m-d') . '.' . $extension;
                $path = Storage::putFileAs($upload_folder, $file, $name);

                $path = str_replace('public', 'storage', $path);

                Image::create([
                    'path' => $path,
                    'imageable_type' => Review::class,
                    'imageable_id' => $review->id,
                ]);
            }
        }
        return back()->with([
            'success' => 'Комментарий оставлен'
        ]);
    }

    public function createClaim($id)
    {
        return view('crud.review.claim', compact('id'));
    }

    public function claimStore(ReviewRequest $request)
    {
        if (Review::where('user_id', '=', $request->user()->id)
                ->where('product_id', '=', $request['product_id'])
                ->where('is_claim', '=', '1')
                ->count() == 0) {
            Review::create([
                'text' => $request['text'],
                'user_id' => $request->user()->id,
                'product_id' => $request['product_id'],
                'is_claim' => 1,
            ]);

            return back()->with([
                'success' => 'Жалоба отправлена'
            ]);
        }
        return back()->with([
            'success' => 'Вы уже жаловались на этот продукт'
        ]);
    }
}
