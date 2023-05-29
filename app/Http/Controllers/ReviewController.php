<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewStoreRequest;
use App\Http\Requests\Review\ReviewUpdateRequest;
use App\Http\Resources\Review\ReviewFullResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getAll()
    {
        return ReviewFullResource::collection(Review::orderBy('created_at', 'desc')->get());
    }



    public function store(ReviewStoreRequest $request)
    {
        $data = $request->validated();
        $user_id = $data['user'];
        unset($data['user']);
        $data['user_id'] = $user_id ?? null;
        $reviews = Review
            ::where('is_active' ,'=', true)
            ->where('user_id ', '=', $user_id)
            ->get()
            ->count();
        if($reviews > 0){
            return response()->json('Вы уже оставляли комментарий!', 206);
        }
        $review = Review::create($data);
        $review->save();
        return ReviewFullResource::make($review);
    }

    public function getById(int $id){

        $review = Review::findOrFail($id);
        return ReviewFullResource::make($review);

    }



    public function update(ReviewUpdateRequest $request, int $id)
    {
        $review = Review::findOrFail($id);
        $data = $request->validated();
        $review->update($data);
        $review->save();
        return ReviewFullResource::make($review);
    }


    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(null, 206);

    }
}
