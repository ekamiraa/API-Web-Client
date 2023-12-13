<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\BookCollection;
use Illuminate\Http\Request;
use Validator;
use App\Models\Book;
use App\Http\Resources\BookResource as BookResources;

class BookController extends BaseController
{
    /**
     * Mengambil data Buku
     */
    public function index()
    {
        $book = Book::all();
        return $this->sendResponse(BookResources::collection($book),
            'Buku ditampilkan');
    }

    /**
     * Membuat data Buku baru
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $book = Book::create($input); //buat Book baru
        return $this->sendResponse(new BookResources($book),
            'Data Buku ditambahkan');
    }


    /**
     * menampilkan Buku dengan id tertentu
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Data does not exist');
        }
        return $this->sendResponse(new BookResources($book),
            'Data Buku ditampilkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $book->title = $input['title'];
        $book->author = $input['author'];
        $book->publisher = $input['publisher'];
        $book->genre = $input['genre'];
        $book->image = $input['image'];
        $book->save();

        return $this->sendResponse(new BookResources($book),
            'Data updated');
    }

    /**
     * Search based on user_id and reveiwer_id
     */
    public function search(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $query = Book::query();

        $title = $request->input('title');
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        $author = $request->input('author');
        if ($author) {
            $query->where('author', 'like', '%' . $author . '%');
        }

        $books = $query->paginate($size, ['*'], 'page', $page);

        if ($books->isEmpty()) {
            return $this->sendError('No books found');
        }

        return $this->sendResponse(new BookCollection($books), 'Books found');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return $this->sendResponse([], 'Data deleted');
    }
}
