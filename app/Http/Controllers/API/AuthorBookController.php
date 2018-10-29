<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Book;
use App\Jobs\BookStore;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        try {
            $transformer = new BookTransformer();
            $author = Author::findOrFail($id);
            $books = $author->books()->with($transformer->getEagerLoads($request))->get();
        } catch (ModelNotFoundException $e) {
            $this->abort($status = 404, 'Author not found');
        }

        $data = fractal()
        ->collection($books)
        ->transformWith($transformer)
        ->withResourceName('books')
        ->toArray();

        // Set link
        $data['links']['self'] = route('author.book.index', ['author' => $id]);

        // Response
        return response()->json($data, 200, [
            'Content-Type' => 'application/vnd.api+json'
        ], JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'data' => 'required',
            'data.type' => 'required|in:books',
            'data.attributes.title' => 'required',
            'data.attributes.description' => 'required',
        ]);

        try {
            $author = Author::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->abort($status = 404, 'Author not found');
        }

        dispatch($job = new BookStore($request->all(), $author));
        $book =  $job->response();

        $data = fractal()
        ->item($book)
        ->transformWith(new BookTransformer())
        ->withResourceName('books')
        ->toArray();

        return response()->json($data, 201, [
            'Location' => route('book.show', ['id' => $book->id]),
            'Content-Type' => 'application/vnd.api+json'
        ]);
    }
}
