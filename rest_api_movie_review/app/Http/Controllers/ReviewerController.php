<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ReviewerCollection;
use Illuminate\Http\Request;
use Validator;
use App\Models\Reviewer;
use App\Http\Resources\ReviewerResource as ReviewerResources;

class ReviewerController extends BaseController
{
    /**
     * Mengambil data Reviewer
     */
    public function index()
    {
        $reviewer = Reviewer::all();
        return $this->sendResponse(ReviewerResources::collection($reviewer),
            'Reviewer ditampilkan');
    }

    /**
     * Membuat data Reviewer Baru
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'username' => 'required',
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $reviewer = Reviewer::create($input); //buat reviewer baru
        return $this->sendResponse(new ReviewerResources($reviewer),
            'Data Reviewer ditambahkan');
    }


    /**
     * menampilkan Reviewer dengan id tertentu
     */
    public function show($id)
    {
        $reviewer = Reviewer::find($id);
        if (is_null($reviewer)) {
            return $this->sendError('Data does not exist');
        }
        return $this->sendResponse(new ReviewerResources($reviewer),
            'Data reviewer ditampilkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'username' => 'required',
            'email' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $reviewer->username = $input['username'];
        $reviewer->email = $input['email'];
        $reviewer->save();

        return $this->sendResponse(new ReviewerResources($reviewer),
            'Data updated');
    }

    /**
     * Search by username and email
     */
    public function search(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $query = Reviewer::query();

        $username = $request->input('username');
        if ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        }

        $email = $request->input('email');
        if ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        $reviewers = $query->paginate($size, ['*'], 'page', $page);

        if ($reviewers->isEmpty()) {
            return $this->sendError('No reviewers found');
        }

        return $this->sendResponse(new ReviewerCollection($reviewers), 'Data pencarian berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviewer $reviewer)
    {
        $reviewer->delete();
        return $this->sendResponse([], 'Data deleted');
    }
}
