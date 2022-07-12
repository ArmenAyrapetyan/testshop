<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Services\FileManager;

class ReviewController extends Controller
{
    public function create($id)
    {
        return view('crud.review.create', compact('id'));
    }

    public function store(ReviewRequest $request)
    {
        $request->request->add([
            'user_id' => $request->user()->id,
        ]);

        $review = Review::create($request->all());

        if ($request->hasFile('images'))
            FileManager::saveImage($request->file('images'), $review->id, Review::class);

        return redirect()->route('product.show', $request['product_id'])->with([
            'success' => 'Комментарий оставлен'
        ]);
    }

    public function createClaim($id)
    {
        return view('crud.review.claim', compact('id'));
    }

    public function claimStore(ReviewRequest $request)
    {
        if (!Review::where('user_id', $request->user()->id)
                ->where('product_id', $request['product_id'])
                ->where('is_claim', '1')
                ->count()) {

            $request->request->add([
                'user_id' => $request->user()->id,
                'is_claim' => 1,
            ]);

            Review::create($request->all());

            return redirect()->route('product.show', $request['product_id'])
                ->with(['success' => 'Жалоба отправлена']);
        }

        return redirect()->route('product.show', $request['product_id'])
            ->with(['success' => 'Вы уже жаловались на этот продукт']);
    }
}
