<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\MovieCollection;
use Validator;
use App\Http\Resources\MovieResource as MovieResources;

class MovieController extends BaseController
{
    /**
     * Mengambil data Movie
     */
    public function index()
    {
        $movie = Movie::all();
        return $this->sendResponse(MovieResources::collection($movie),
            'Movie ditampilkan');
    }

    /**
     * Membuat data Movie baru
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'genre' => 'required',
            'actors' => 'required',
            'sutradara' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $movie = Movie::create($input); //buat Movie baru
        return $this->sendResponse(new MovieResources($movie),
            'Data Movie ditambahkan');
    }


    /**
     * menampilkan Movie dengan id tertentu
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        if (is_null($movie)) {
            return $this->sendError('Data does not exist');
        }
        return $this->sendResponse(new MovieResources($movie),
            'Data Movie ditampilkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'genre' => 'required',
            'actors' => 'required',
            'sutradara' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $movie->title = $input['title'];
        $movie->genre = $input['genre'];
        $movie->actors = $input['actors'];
        $movie->sutradara = $input['sutradara'];
        $movie->image = $input['image'];
        $movie->save();

        return $this->sendResponse(new MovieResources($movie),
            'Data updated');
    }

    /**
     * Search based on title and genre
     */
    public function search(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $query = Movie::query();

        $title = $request->input('title');
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        $genre = $request->input('genre');
        if ($genre) {
            $query->where('genre', 'like', '%' . $genre . '%');
        }

        $movies = $query->paginate($size, ['*'], 'page', $page);

        if ($movies->isEmpty()) {
            return $this->sendError('No books found');
        }

        return $this->sendResponse(new MovieCollection($movies), 'Movies found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return $this->sendResponse([], 'Data deleted');
    }
}
