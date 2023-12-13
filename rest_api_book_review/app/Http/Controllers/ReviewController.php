<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ReviewCollection;
use Validator;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource as ReviewResources;


class ReviewController extends BaseController
{
    /**
     * Mengambil data Review
     */
    public function index()
    {
        $review = Review::all();
        return $this->sendResponse(ReviewResources::collection($review),
            'Review ditampilkan');
    }

    /**
     * Membuat data Review baru
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'rating' => 'required',
            'comment' => 'required',
            'book_id' => 'required',
            'reviewer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $review = Review::create($input); //buat Review baru
        return $this->sendResponse(new ReviewResources($review),
            'Data Review ditambahkan');
    }


    /**
     * menampilkan Review dengan id tertentu
     */
    public function show($id)
    {
        $review = Review::find($id);
        if (is_null($review)) {
            return $this->sendError('Data does not exist');
        }
        return $this->sendResponse(new ReviewResources($review),
            'Data Review ditampilkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'rating' => 'required',
            'comment' => 'required',
            'book_id' => 'required',
            'reviewer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $review->rating = $input['rating'];
        $review->comment = $input['comment'];
        $review->book_id = $input['book_id'];
        $review->reviewer_id = $input['reviewer_id'];
        $review->save();

        return $this->sendResponse(new ReviewResources($review),
            'Data updated');
    }

    /**
     * Search based on user_id and reveiwer_id
     */
    public function search(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $query = Review::query();

        $book_id = $request->input('book_id');
        if ($book_id) {
            $query->where('book_id', $book_id);
        }

        $reviewer_id = $request->input('reviewer_id');
        if ($reviewer_id) {
            $query->where('reviewer_id', $reviewer_id);
        }

        $reviews = $query->paginate($size, ['*'], 'page', $page);

        if ($reviews->isEmpty()) {
            return $this->sendError('No reviews found');
        }

        return $this->sendResponse(new ReviewCollection($reviews), 'Reviews found');
    }


    // public function searchByBookId($book_id)
    // {
    //     $reviews = Review::where('book_id', $book_id)->get();

    //     if ($reviews->isEmpty()) {
    //         return $this->sendError('Data does not exist');
    //     }

    //     return $this->sendResponse(ReviewResources::collection($reviews), 'Reviews found');
    // }

    // public function searchByReviewerId($reviewer_id)
    // {
    //     $reviews = Review::where('reviewer_id', $reviewer_id)->get();

    //     if ($reviews->isEmpty()) {
    //         return $this->sendError('Data does not exist');
    //     }

    //     return $this->sendResponse(ReviewResources::collection($reviews), 'Reviews found');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return $this->sendResponse([], 'Data deleted');
    }
}
