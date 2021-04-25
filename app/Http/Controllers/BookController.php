<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()
            ->with(['authors'])
            ->paginate(10);

        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $book = new Book();
        $book->title = $request->get('name');
        $book->save();

        return BookResource::make($book);
    }

    public function show(Book $book)
    {
        return BookResource::make($book);
    }

    public function update(Request $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        //
    }
}
